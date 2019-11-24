<?php
    function validDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    function check_password(string $password) {
        if(empty($password)) {
			throw new Exception("Empty password");
		} else {
			if(strlen($password) > 64) {
				throw new Exception("Invalid password max 64 char");
			} else {
				if(!preg_match("#[a-zA-Z0-9 !@#$%^&*]{8,64}$#", $password)) {
                    throw new Exception("Invalid password min 8 char");
                }
			}
		}
    }

    function check_profile_infos($data) {
		if(empty($data['first_name'])) {
			throw new Exception("Empty first name");
		} else {
			if(strlen($data['first_name']) > 15) {
				throw new Exception("Invalid first name (max 15 char)");
			} else {
				if(!preg_match("#^[a-zA-Z ]*$#", $data['first_name'])) {
					throw new Exception("Invalid first name (only letters)");
				}
			}
		}

		if(empty($data['last_name'])) {
			throw new Exception("Empty last name");
		} else {
			if(strlen($data['last_name']) > 15) {
				throw new Exception("Invalid last name (max 15 char)");
			} else {
				if(!preg_match("#^[a-zA-Z ]*$#", $data['last_name'])) {
					throw new Exception("Invalid last name (only letters)");
				}
			}
		}

		if(empty($data['mail'])) {
			throw new Exception("Empty mail");
		} else {
			if(strlen($data['mail']) > 80) {
				throw new Exception("Invalid mail (max 80 char)");
			} else {
				if(!filter_var($data['mail'], FILTER_VALIDATE_EMAIL)) {
                    throw new Exception("Invalid mail (user@mail.example.com)");
				} else {
                    $account = User::getAccount($data['mail']);
					if(isset($account) && !empty($account) && $account->id_account != $data['id']) {
                        throw new Exception("Mail already use");
                    }
				}
			}
        }
        
        if(!empty($data['phone'])) {
			if(!preg_match("#^\+[0-9]{8,13}#", $data['phone'])) {
				throw new Exception("Invalid phone format");
			}
		}

		if(!empty($data['birth_date'])) {
			if(!validDate($data['birth_date'])) {
				throw new Exception("Invalid date format");
			}
		}

		if(!empty($data['degrees'])) {
			if(!preg_match("#^[a-zA-Z0-9 ]{0,500}$#", $data['degrees'])) {
                throw new Exception("Invalid degrees, only letters and number maximum 500 char");
			}
        }
        
        if(isset($data['social_reason'])) {
            if(empty($data['social_reason'])) {
                throw new Exception("Empty social_reason");
            }
			else if(!preg_match("#^[a-zA-Z0-9 ]{0,40}$#", $data['social_reason'])) {
                throw new Exception("Invalid social_reason, only letters and number maximum 40 char");
			}
		}
    }


    require_once(__DIR__."/../models/m-article.php");
    require_once(__DIR__."/../models/m-user.php");

    $action = (isset($_REQUEST['action']) ? $_REQUEST['action'] : 'get_profile');
    $id_user = (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) ? $_REQUEST['id'] : null;
    $id_account = (isset($_SESSION['id_account']) && !empty($_SESSION['id_account'])) ? $_SESSION['id_account'] : -1;
    $is_admin = (isset($_SESSION['is_admin']) && !empty($_SESSION['is_admin'])) ? $_SESSION['is_admin'] : false;

    if($id_account > 0) {
        $is_member = User::isMember($id_account);
        if($is_member) {
            $status = "member";
        }
        else {
            $is_company = User::isCompany($id_account);
            if($is_company) $status = "company";
            else $status = "admin";
        }
    }
    else {
        $status = "not-connected";
    }

    switch ($action) {
        case 'get_profile':
            if(isset($id_user)) {    
                if(User::isMember($id_user)) {
                    $account = User::getMemberByID($id_user);
                    require(__DIR__."/../views/v-profile_member.inc.php");
                }
                else if(User::isCompany($id_user)) {
                    $account = User::getCompanyByID($id_user);
                    if($account->active) {
                        require(__DIR__."/../views/v-profile_company.inc.php");
                    }
                    else 
                        header("Location: index.php");
                }
                else {
                    $account = User::getAccountByID($id_user);
                    require(__DIR__."/../views/v-profile_member.inc.php");
                }
            }
            else {
                require(__DIR__."/../views/v-profile_member.inc.php");
            }
            break;

        case 'edit_profile':
            if($status != "not-connected" && isset($id_user) && ($id_account == $id_user || $is_admin)) {
                if(User::isMember($id_user)) $account = User::getMemberByID($id_user);
                else if(User::isCompany($id_user)) $account = User::getCompanyByID($id_user);
                else $account = User::getAccountByID($id_user);

                require(__DIR__."/../views/v-profile_edit.inc.php");
            }
            else if($is_admin) {
                header("Location: ?page=admin");
            } else {
                header("Location: index.php");
            }
            break;

        case 'save_profile':
            if($status != "not-connected" && isset($id_user) && ($id_account == $id_user || $is_admin)) {
                if(User::isMember($id_user)) {
                    $type = "member";
                    $account = User::getMemberByID($id_user);
                } 
                else if(User::isCompany($id_user)) {
                    $type = "company";
                    $account = User::getCompanyByID($id_user);
                } 
                else {
                    $type = "admin";
                    $account = User::getAccountByID($id_user);
                }

                $data = array(
                    'last_name' => htmlentities($_REQUEST['last_name'], ENT_COMPAT, "UTF-8"),
                    'first_name' => htmlentities($_REQUEST['first_name'], ENT_COMPAT, "UTF-8"),
                    'mail' => htmlentities($_REQUEST['mail'], ENT_COMPAT, "UTF-8"),
                    'phone' => htmlentities($_REQUEST['phone'], ENT_COMPAT, "UTF-8"),
                    'id' => $_REQUEST['id']
                );
                if($type == "company") {
                    $data['social_reason'] =  htmlentities($_REQUEST['social_reason'], ENT_COMPAT, "UTF-8");
                    $data['active'] = ($account->active) ? 'true' : 'false';
                }
                else if($type == "member") {
                    $data['birth_date'] =  htmlentities($_REQUEST['birth_date'], ENT_COMPAT, "UTF-8");
                    $data['degrees'] = htmlentities($_REQUEST['degrees'], ENT_COMPAT, "UTF-8");
                }

                try {
                    check_profile_infos($data);
                    if($type == "company") {
                        User::updateCompany($data);
                    }
                    else if($type == "member") {
                        User::updateMember($data);
                    }
                    else {
                        User::updateAccount($data);
                    }
                }
                catch (Exception $e) {
                    $error = "Error : ".$e->getMessage();
                    require(__DIR__."/../views/v-profile_edit.inc.php");
                    exit();
                }

                if($is_admin) {
                    header('Location: ?page=admin');
                } else {
                    header('Location: ?page=profile&id='.$id_user);
                }
                exit();
            }
        
            break;

        case 'change_password':
            if($status != "not-connected" && isset($id_user)) {        
                $old_password = $_REQUEST['old_password'];
                $password =  $_REQUEST['password'];
                $conf_password =  $_REQUEST['conf_password'];

                if(isset($old_password) && isset($password) && isset($conf_password)) {
                    $account = User::getAccountByID($id_account);
                    try {
                        if($account->password == hash('sha256', $old_password)) {
                            
                            check_password($password);
                            if($password == $conf_password) {
                                User::updatePasswordAccount($data);
                            }
                            else {
                                throw new Exception("Bad confirmation");
                            }
                        }
                        else {
                            throw new Exception("Incorrect old password");
                        }
                    }
                    catch (Exception $e) {
                        $error = "Error : ".$e->getMessage();
                    }
                }

                require(__DIR__."/../views/v-profile_password.inc.php");
            }
            break;

        case 'delete_profile':
            if($status != "not-connected" && isset($id_user)) {        
                $account = User::getAccountByID($id_user);
                $can_delete = $id_user == $id_account || $status == "admin";
                if($account && $can_delete) {
                    Article::deleteComment($id_user);
                    header('Location: index.php');
                    exit();
                }

                header('Location: ?page=profile&id='.$id_user);
                exit();
            }
            break;
        
        default:
            
            break;
    }

?>