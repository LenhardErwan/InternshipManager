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

        case 'signup_member':
                require('c-connect.php');
                if(isset($_SESSION['id_account'])) {
                    header('Location: ?page=index');
                }                
                require('c-member.php');
                require(__DIR__.'/../views/v-signup_member.inc.php');
            break;

        case 'signup_company':
                require('c-connect.php');
                if(isset($_SESSION['id_account'])) {
                    header('Location: ?page=index');
                }
                require('c-company.php');
                require(__DIR__.'/../views/v-signup_company.inc.php');
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

    switch ($action) {
        case 'voteFor':
            $id_account = (isset($_SESSION['id_account']) && !empty($_SESSION['id_account'])) ? $_SESSION['id_account'] : null;
            $type = (isset($_REQUEST['type']) && !empty($_REQUEST['type'])) ? $_REQUEST['type'] : null;
            $id_hash = (isset($_REQUEST['id_hash']) && !empty($_REQUEST['id_hash'])) ? $_REQUEST['id_hash'] : null;

            if(!is_null($id_hash)) $article = Article::getArticle($id_hash);
            
            if(isset($article) && $article) {
                $id_article = $article->id_article;

                if(!User::isCompany($id_account)) {  //Companies cannot vote
                    if(!is_null($id_account) && !is_null($article) && !is_null($type)) {
                        Article::voteFor($id_account, $id_article, $type);
                        $data = array('id_account' => $id_account, 'id_article' => $id_article);
                        $user_vote = Article::getVote($data);
                    }
                }
            
                $votes = Article::getNbVotes($id_article);
                $functions = Article::getAJAXFunctionsVote($id_hash);
                
                require(__DIR__."/../views/v-vote.inc.php");
            }
            break;
        
        default:
            # code...
            break;
    }

    function listArticles($text = null) {
        if(empty($text)) {
            $articles = Article::getAllArticles();
        } else {
            $articles = "pas de recherche pour le moment";
        }

        foreach ($articles as $article) {
            $article->social_reason = User::getCompanyName($article->id_company);
            $article->mission = substr($article->mission, 0, 300).'...';
        }

        return $articles;
    }
?>
