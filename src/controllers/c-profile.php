<?php
    require_once(__DIR__."/../models/m-article.php");
    require_once(__DIR__."/../models/m-user.php");

    $action = (isset($_REQUEST['action']) ? $_REQUEST['action'] : 'get_profile');
    $id_user = (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) ? $_REQUEST['id'] : null;
    $id_account = (isset($_SESSION['id_account']) && !empty($_SESSION['id_account'])) ? $_SESSION['id_account'] : -1;

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
                    require(__DIR__."/../views/v-profile_company.inc.php");
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
            if($status != "not-connected" && isset($id_user)) {

            }

            break;

        case 'save_profile':
            if($status != "not-connected") {
                
            }
        
            break;

        case 'delete_profile':
            if($status != "not-connected" && isset($id_user)) {        
                
            }
            break;
        
        default:
            
            break;
    }

?>