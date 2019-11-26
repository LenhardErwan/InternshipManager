<?php
    require_once(__DIR__."/../models/m-article.php");
    require_once(__DIR__."/../models/m-user.php");

    session_start();
    $action = (isset($_REQUEST['action']) ? $_REQUEST['action'] : '');
    $page = (isset($_REQUEST['page']) ? $_REQUEST['page'] : 'index');

    switch($page) {
        case 'index':
                require('c-connect.php');
                require(__DIR__.'/../views/v-index.inc.php');
            break;

        case 'disconnect':
                session_unset();
                session_destroy();
                header('Location: ?page=index');
            break;

        case 'article':
                require('c-connect.php');
                require('c-article.php');
            break;
        
        case 'profile':
            	require('c-connect.php');
            	require('c-profile.php');
        	break;

        case 'admin':
                if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
                    require('c-connect.php');
                    require('c-admin.php');
                    require(__DIR__.'/../views/v-admin.inc.php');
                } else {
                    header('Location: ?page=index');
                }
            break;

        default:
                require(__DIR__.'/../views/v-error_404.inc.php');
            break;
    }

    function listArticles($text = null) {
        if(empty($text)) {
            $contents = array();
            $articles = Article::getAllArticles();

            if(!empty($articles)) {
                foreach ($articles as $article) {
                    $article->social_reason = User::getCompanyName($article->id_company);
                    
                    if(strlen($article->mission) > 300) {
                        $article->mission = substr($article->mission, 0, 300).'...';
                    }
                    
                    $votes = Article::getNbVotes($article->id_article);
                    $total_vote = $votes["total"];
                    $value_vote = $votes["positive"] - $votes["negative"];
        
                    $contents[] = array("article" => $article, "total_vote" => $total_vote, "value_vote" => $value_vote);
                }
            }
            else {
                $contents = "Il n'y a aucune offres pour le moment";
            }
        } 
        else {
            $contents = "Il n'y pas de filtre de recherche pour l'instant";
        }

        return $contents;
    }
?>
