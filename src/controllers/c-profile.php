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

    function valid_member_submit($first_name, $last_name, $mail, $password, $valid_password, $phone, $birth_date, $degrees) {
        if(empty($first_name)) {
            $error['first_name'] = "Champ prenom vide";
        } else {
            if(strlen($first_name) > 15) {
                $error['first_name'] = "Champ prenom trop grand (15 caracteres)";
            } else {
                if(!preg_match("/^[a-zA-Z ]*$/", $first_name)) {
                    $error['first_name'] = "Champ prenom invalide (a-zA-Z )";
                } else {
                    $data['first_name'] = $first_name;
                }
            }
        }

        if(empty($last_name)) {
            $error['last_name'] = "Champ nom vide";
        } else {
            if(strlen($last_name) > 15) {
                $error['last_name'] = "Champ nom trop grand (15 caracteres)";
            } else {
                if(!preg_match("/^[a-zA-Z ]*$/", $last_name)) {
                    $error['last_name'] = "Champ nom invalide (a-zA-Z )";
                } else {
                    $data['last_name'] = $last_name;
                }
            }
        }

        if(empty($mail)) {
            $error['mail'] = "Champ mail vide";
        } else {
            if(strlen($mail) > 80) {
                $error['mail'] = "Champ mail trop grand (80 caracteres)";
            } else {
                if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                    $error['mail'] = "Champ mail invalide (utilisateur@mail.example.com)";
                } else {
                    if(!empty(User::getAccount($mail))) {
                        $error['mail'] = "Mail deja utilise";
                    } else {
                        $data['mail'] = $mail;
                    }
                }
            }
        }

        if(empty($password)) {
            $error['password'] = "Champ mot de passe vide";
        } else {
            if(strlen($password) > 64) {
                $error['password'] = "Champ mot de passe trop grand (64 caracteres)";
            } else {
                if(!preg_match("/[a-zA-Z0-9 !@#$%^&*]{8,64}$/", $password)) {
                    $error['password'] = "Champ mot de passe invalide au moins 8 caracteres (a-zA-Z0-9 !@#$%^&*)";
                } else if(!($password === $valid_password)) {
                    $error['password'] = "Les mots de passes ne correspondent pas";
                } else {
                    $data['password'] = hash('sha256', $password);
                }
            }
        }

        if(empty($phone)) {
            $data['phone'] = '';
        } else {
            if(!preg_match("/^\+[0-9]{8,13}/", $phone)) {
                $error['phone'] = "Champ telephone invalide (+01925784)";
            } else {
                $data['phone'] = $phone;
            }
        }

        if(empty($birth_date)) {
            $data['birth_date'] = '';
        } else {
            if(!validBirthDate($birth_date)) {
                $error['birth_date'] = "Champ date de naissance invalide";
            } else {
                $data['birth_date'] = $birth_date;
            }
        }

        if(empty($degrees)) {
            $data['degrees'] = '';
        } else {
            if(!preg_match("/^[a-zA-Z0-9 ]{0,500}$/", $degrees)) {
                $error['degrees'] = "Champ diplomes invalides (a-zA-Z0-9 ) 500 caracteres maximum";
            } else {
                $data['degrees'] = $degrees;
            }
        }

        if(!empty($error)) {
            $error['valid'] = false;
            return $error;
        } else {
            $data['valid'] = true;
            return $data;
        }
    }

    function valid_company_submit($first_name, $last_name, $mail, $password, $valid_password, $phone, $social_reason) {
        if(empty($social_reason)) {
            $error['social_reason'] = "Champ nom de societe vide";
        } else {
            if(!preg_match("/^[a-zA-Z0-9 ]{0,40}$/", $social_reason)) {
                $error['social_reason'] = "Champ nom de societes invalides (a-zA-Z0-9 ) 40 caracteres maximum";
            } else {
                $data['social_reason'] = $social_reason;
            }
        }

        if(empty($first_name)) {
            $error['first_name'] = "Champ prenom vide";
        } else {
            if(strlen($first_name) > 15) {
                $error['first_name'] = "Champ prenom trop grand (15 caracteres)";
            } else {
                if(!preg_match("/^[a-zA-Z ]*$/", $first_name)) {
                    $error['first_name'] = "Champ prenom invalide (a-zA-Z )";
                } else {
                    $data['first_name'] = $first_name;
                }
            }
        }

        if(empty($last_name)) {
            $error['last_name'] = "Champ nom vide";
        } else {
            if(strlen($last_name) > 15) {
                $error['last_name'] = "Champ nom trop grand (15 caracteres)";
            } else {
                if(!preg_match("/^[a-zA-Z ]*$/", $last_name)) {
                    $error['last_name'] = "Champ nom invalide (a-zA-Z )";
                } else {
                    $data['last_name'] = $last_name;
                }
            }
        }

        if(empty($mail)) {
            $error['mail'] = "Champ mail vide";
        } else {
            if(strlen($mail) > 80) {
                $error['mail'] = "Champ mail trop grand (80 caracteres)";
            } else {
                if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                    $error['mail'] = "Champ mail invalide (utilisateur@mail.example.com)";
                } else {
                    if(!empty(User::getAccount($mail))) {
                        $error['mail'] = "Mail deja utilise";
                    } else {
                        $data['mail'] = $mail;
                    }
                }
            }
        }

        if(empty($password)) {
            $error['password'] = "Champ mot de passe vide";
        } else {
            if(strlen($password) > 64) {
                $error['password'] = "Champ mot de passe trop grand (64 caracteres)";
            } else {
                if(!preg_match("/[a-zA-Z0-9 !@#$%^&*]{8,64}$/", $password)) {
                    $error['password'] = "Champ mot de passe invalide au moins 8 caracteres (a-zA-Z0-9 !@#$%^&*)";
                } else if(!($password === $valid_password)) {
                    $error['password'] = "Les mots de passes ne correspondent pas";
                } else {
                    $data['password'] = hash('sha256', $password);
                }
            }
        }

        if(empty($phone)) {
            $data['phone'] = '';
        } else {
            if(!preg_match("/^\+[0-9]{8,13}/", $phone)) {
                $error['phone'] = "Champ telephone invalide (+01925784)";
            } else {
                $data['phone'] = $phone;
            }
        }

        if(!empty($error)) {
            $error['valid'] = false;
            return $error;
        } else {
            $data['valid'] = true;
            return $data;
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

    function mailAdmin($userMail) {
        $admin = User::getAdmin();

        $to      = $admin->mail;
        $subject = 'Compte a valider';
        $message = 'Le compte portant l\'adresse mail : '.$userMail.' doit etre valide.';
        $headers = array(
            'From' => 'webmaster@example.com',
            'X-Mailer' => 'PHP/' . phpversion()
        );

        mail($to, $subject, $message, $headers);
    }

    require_once(__DIR__."/../models/m-article.php");
    require_once(__DIR__."/../models/m-user.php");

    $action = (isset($_REQUEST['action']) ? $_REQUEST['action'] : 'get_profile');
    $error = (isset($_REQUEST['error']) ? $_REQUEST['error'] : '');
    $id_user = (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) ? $_REQUEST['id'] : null;
    $id_account = (isset($_SESSION['id_account']) && !empty($_SESSION['id_account'])) ? $_SESSION['id_account'] : -1;

    if($id_account > 0) {
        if(User::isMember($id_account)) {
            $status = "member";
        }
        else {
            if(User::isCompany($id_account)) $status = "company";
            else $status = "admin";
        }
    }
    else {
        $status = "not-connected";
    }

    if($id_user) {
        if(User::isMember($id_user)) {
            $account_type = "member";
        }
        else {
            if(User::isCompany($id_user)) $account_type = "company";
            else $account_type = "admin";
        }
    }

    switch ($action) {
        case 'create_member':
                if($status != "not-connected") {
                    header('Location: ?page=index');
                } else {
                    if(isset($_POST['submit'])) {
                        $result = valid_member_submit($_POST['first_name'], $_POST['last_name'], $_POST['mail'], $_POST['password'], $_POST['valid_password'], $_POST['phone'], $_POST['birth_date'], $_POST['degrees']);

                        if($result['valid']) {
                            User::createMember(array('first_name' => $result['first_name'], 'last_name' => $result['last_name'], 'mail' => $result['mail'], 'password' => $result['password'], 'phone' => $result['phone'], 'birth_date' => $result['birth_date'], 'degrees' => $result['degrees']));
                            $errors['valid'] = $result['valid'];
                        } else {
                            $errors = $result;
                        }
                    }

                    $account_type = "member";
                    require(__DIR__."/../views/v-profile_create.inc.php");
                }
            break;
        case 'create_company':
                if($status != "not-connected") {
                    header('Location: ?page=index');
                } else {
                    if(isset($_POST['submit'])) {
                        $result = valid_company_submit($_POST['first_name'], $_POST['last_name'], $_POST['mail'], $_POST['password'], $_POST['valid_password'], $_POST['phone'], $_POST['social_reason']);

                        if($result['valid']) {
                            User::createCompany(array('first_name' => $result['first_name'], 'last_name' => $result['last_name'], 'mail' => $result['mail'], 'password' => $result['password'], 'phone' => $result['phone'], 'social_reason' => $result['social_reason']));
                            mailAdmin($result['mail']);
                            $errors['valid'] = $result['valid'];
                        } else {
                            $errors = $result;
                        }
                    }

                    $account_type = "company";
                    require(__DIR__."/../views/v-profile_create.inc.php");
                }
            break;
        case 'get_profile':
            if(isset($id_user)) {    
                if($account_type == "member") {
                    $account = User::getMemberByID($id_user);
                    require(__DIR__."/../views/v-profile.inc.php");
                }
                else if($account_type == "company") {
                    $account = User::getCompanyByID($id_user);
                    if($account->active) {
                        require(__DIR__."/../views/v-profile.inc.php");
                    }
                    else 
                        header("Location: index.php");
                }
                else {
                    $account = User::getAccountByID($id_user);
                    require(__DIR__."/../views/v-profile.inc.php");
                }
            }
            else {
                require(__DIR__."/../views/v-profile.inc.php");
            }
            break;

        case 'edit_profile':
            if($status != "not-connected" && isset($id_user) && ($id_account == $id_user || $status == "admin")) {
                if($account_type == "member") $account = User::getMemberByID($id_user);
                else if($account_type == "company") $account = User::getCompanyByID($id_user);
                else $account = User::getAccountByID($id_user);

                require(__DIR__."/../views/v-profile_edit.inc.php");
            }
            else if($status == "admin") {
                header("Location: ?page=admin");
            } else {
                header("Location: index.php");
            }
            break;

        case 'save_profile':
            if($status != "not-connected" && isset($id_user) && ($id_account == $id_user || $status == "admin")) {
                if($account_type == "member") {
                    $account = User::getMemberByID($id_user);
                } 
                else if($account_type == "company") {
                    $account = User::getCompanyByID($id_user);
                } 
                else {
                    $account = User::getAccountByID($id_user);
                }

                $data = array(
                    'last_name' => htmlentities($_REQUEST['last_name'], ENT_COMPAT, "UTF-8"),
                    'first_name' => htmlentities($_REQUEST['first_name'], ENT_COMPAT, "UTF-8"),
                    'mail' => htmlentities($_REQUEST['mail'], ENT_COMPAT, "UTF-8"),
                    'phone' => htmlentities($_REQUEST['phone'], ENT_COMPAT, "UTF-8"),
                    'id' => $_REQUEST['id']
                );
                if($account_type == "company") {
                    $data['social_reason'] =  htmlentities($_REQUEST['social_reason'], ENT_COMPAT, "UTF-8");
                    $data['active'] = ($account->active) ? 'true' : 'false';
                }
                else if($account_type == "member") {
                    $data['birth_date'] =  htmlentities($_REQUEST['birth_date'], ENT_COMPAT, "UTF-8");
                    $data['degrees'] = htmlentities($_REQUEST['degrees'], ENT_COMPAT, "UTF-8");
                }

                try {
                    check_profile_infos($data);
                    if($account_type == "company") {
                        User::updateCompany($data);
                    }
                    else if($account_type == "member") {
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

                if($status == "admin") {
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

                header('Location: ?page=profile&id='.$id_user.'&error='.$error);
            }
            break;

        case 'delete_profile':
            if($status != "not-connected" && isset($id_user)) {        
                $account = User::getAccountByID($id_user);
                $can_delete = $id_user == $id_account || $status == "admin";
                if($account && $can_delete) {
                    User::deleteAccount($id_user);
                    if($status == "admin") {
                        header('Location: ?page=admin');
                    } else {
                        header('Location: index.php');
                    }
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