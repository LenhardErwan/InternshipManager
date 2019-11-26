<?php
    function validDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    function check_social_reason(string $social_reason) {
        if(empty($social_reason)) {
            throw new Exception("Champ nom de société vide");
        } else if(strlen($social_reason) > 40) {
            throw new Exception("Taille du nom de société trop grande (40 caractères)");
        } else if(!preg_match("/^[a-zA-Z0-9 ]{0,40}$/", $social_reason)) {
            throw new Exception("Champ nom de société invalide (a-zA-Z0-9 )");
        }
    }

    function check_first_name(string $first_name) {
        if(empty($first_name)) {
            throw new Exception("Champ prénom vide");
        } else if(strlen($first_name) > 15) {
            throw new Exception("Taille du prénom trop grande (15 caractères)");
        } else if(!preg_match("/^[a-zA-Z ]*$/", $first_name)) {
            throw new Exception("Champ prénom invalide (a-zA-Z )");
        }
    }

    function check_last_name(string $last_name) {
        if(empty($last_name)) {
            throw new Exception("Champ nom vide");
        } else if(strlen($last_name) > 15) {
            throw new Exception("Taille du nom trop grande (15 caractères)");
        } else if(!preg_match("/^[a-zA-Z ]*$/", $last_name)) {
            throw new Exception("Champ nom invalide (a-zA-Z )");
        }
    }

    function check_mail(string $mail) {
        if(empty($mail)) {
            throw new Exception("Champ mail vide");
        } else if(strlen($mail) > 80) {
            throw new Exception("Taille du mail trop grande (80 caractères)");
        } else if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Champ mail invalide (utilisateur@mail.example.com)");
        } else if(!empty(User::getAccount($mail))) {
            throw new Exception("Mail déjà utilisé");
        }
    }

    function check_passwords(string $password, string $valid_password) {
        if(empty($password)) {
            throw new Exception("Champ mot de passe vide");
        } else if(strlen($password) > 64 || strlen($password) < 8) {
            throw new Exception("Taille du mot de passe invalide (8 à 64 caractères)");
        } else if(!preg_match("/[a-zA-Z0-9 !@#$%^&*]{8,64}$/", $password)) {
            throw new Exception("Mot de passe invalide (a-zA-Z0-9 !@#$%^&*)");
        } else if($password != $valid_password) {
            throw new Exception("Les mot de passes ne sont pas identiques");
        }
    }

    function check_phone(string $phone) {
        if(!empty($phone)) {
            if(strlen($phone) > 13 || strlen($phone) < 8) {
                throw new Exception("Taille du champ téléphone invalide (8 à 13 caractères");
            } else if(!preg_match("/^\+[0-9]{8,13}/", $phone)) {
                throw new Exception("Champ téléphone invalide (+123456789)");
            }
        }
    }

    function check_birth_date(string $birth_date) {
        if(!empty($birth_date)) {
            if(!validDate($birth_date)) {
                throw new Exception("Champ date de naissance invalide");
            }
        }
    }

    function check_degrees(string $degrees) {
        if(!empty($degrees)) {
            if(strlen($degrees) > 500) {
                throw new Exception("Taille du champ diplômes trop grande (500 caractères)");
            } else if(!preg_match("/^[a-zA-Z0-9\n\r ]{0,500}$/", $degrees)) {
                throw new Exception("Champ diplômes invalide (a-zA-Z0-9\\n\\r )");
            }
        }
    }

    function valid_submit(array $submit) {
        if(isset($submit['social_reason'])) {
            try {
                check_social_reason($submit['social_reason']);
                $data['social_reason'] = $submit['social_reason'];
            } catch(Exception $e) {
                $error['social_reason'] = $e->getMessage();
            }
        }

        try {
            check_first_name($submit['first_name']);
            $data['first_name'] = $submit['first_name'];
        } catch(Exception $e) {
            $error['first_name'] = $e->getMessage();
        }

        try {
            check_last_name($submit['last_name']);
            $data['last_name'] = $submit['last_name'];
        } catch(Exception $e) {
            $error['last_name'] = $e->getMessage();
        }

        try {
            check_mail($submit['mail']);
            $data['mail'] = $submit['mail'];
        } catch(Exception $e) {
            $error['mail'] = $e->getMessage();
        }

        if(isset($submit['password']) || isset($submit['valid_password'])) {
            try {
                check_passwords($submit['password'], $submit['valid_password']);
                $data['password'] = hash("sha256", $submit['password']);
            } catch(Exception $e) {
                $error['password'] = $e->getMessage();
            }
        }

        if(isset($submit['phone']) && !empty($submit['phone'])) {
            try {
                check_phone($submit['phone']);
                $data['phone'] = $submit['phone'];
            } catch(Exception $e) {
                $error['phone'] = $e->getMessage();
            }
        } else {
            $data['phone'] = '';
        }

        if(isset($submit['birth_date']) && !empty($submit['birth_date'])) {
            try {
                check_birth_date($submit['birth_date']);
                $data['birth_date'] = $submit['birth_date'];
            } catch(Exception $e) {
                $error['birth_date'] = $e->getMessage();
            }
        } else if(isset($submit['birth_date']) && empty($submit['birth_date'])){
            $data['birth_date'] = '';
        }

        if(isset($submit['degrees']) && !empty($submit['degrees'])) {
            try {
                check_degrees($submit['degrees']);
                $data['degrees'] = $submit['degrees'];
            } catch(Exception $e) {
                $error['degrees'] = $e->getMessage();
            }
        } else if(isset($submit['degrees']) && empty($submit['degrees'])) {
            $data['degrees'] = '';
        }

        if(empty($error)) {
            $data['valid'] = true;
            return $data;
        } else {
            $error['valid'] = false;
            return $error;
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
                        $result = valid_submit($_POST);

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
                        $result = valid_submit($_POST);

                        if($result['valid']) {
                            User::createCompany(array('first_name' => $result['first_name'], 'last_name' => $result['last_name'], 'mail' => $result['mail'], 'password' => hash('sha256', $result['password']), 'phone' => $result['phone'], 'social_reason' => $result['social_reason']));
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
                    $data['birth_date'] = htmlentities($_REQUEST['birth_date'], ENT_COMPAT, "UTF-8");
                    $data['degrees'] = htmlentities($_REQUEST['degrees'], ENT_COMPAT, "UTF-8");
                }

                $result = valid_submit($data);

                if($result['valid']) {
                    if($account_type == "company") {
                        User::updateCompany($data);
                    } else if($account_type == "member") {
                        User::updateMember($data);
                    } else {
                        User::updateInfoAccount($data);
                    }

                    if($status == "admin") {
                        header('Location: ?page=admin');
                    } else {
                        header('Location: ?page=profile&id='.$id_user);
                    }
                } else {
                    $error = $result;
                    require(__DIR__."/../views/v-profile_edit.inc.php");
                }
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
                            check_passwords($password, $conf_password);
                            $password = hash('sha256', $password);
                            User::updatePasswordAccount(array('password' => $password, 'id_account' => $id_account));
                            $error = "Mot de passe modifié";
                        } else {
                            throw new Exception("Anciens mot de passe incorrect");
                        }
                    } catch (Exception $e) {
                        $error = $e->getMessage();
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
                        header('Location: ?page=disconnect');
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