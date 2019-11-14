<?php
    require_once(__DIR__."/../models/m-article.php");
    require_once(__DIR__."/../models/m-user.php");

    $action = (isset($_REQUEST['action']) ? $_REQUEST['action'] : 'get_article');
    $id_hash = (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) ? $_REQUEST['id'] : null;
    session_start();
    $id_account = (isset($_SESSION['id_user']) && !empty($_SESSION['id_user'])) ?$_SESSION['id_user'] : -1;

    switch ($action) {
        case 'get_article':
            if(isset($id_hash)) {        
                $article = Article::getArticle($id_hash);
                if($article) {
                    $company = User::getCompanyName($article->id_company);
                    $votes = Article::getNbVotes($article->id_article);
                    $functions = Article::getAJAXFunctionsVote($id_hash);
                    $is_creator = true; //($article->id_company == $id_account);
                }
                require(__DIR__."/../views/v-article.inc.php");
            }
            break;

        case 'edit_article':
            if(isset($id_hash)) {
                $article = Article::getArticle($id_hash);
                if(true /*$article->id_company == $id_account*/) {
                    require(__DIR__."/../views/v-article_edit.inc.php");
                }
            }
            break;

        case 'save_article':
            # code...
            break;

        case 'delete_article':
            # code...
            break;
        
        default:
            # code...
            break;
    }

?>