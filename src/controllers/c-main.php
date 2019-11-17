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
                require('c-member.php');
                require(__DIR__.'/../views/v-signup_member.inc.php');

            break;
        case 'signup_company':
                require('c-connect.php');
                require('c-company.php');
                require(__DIR__.'/../views/v-signup_company.inc.php');

            break;

        case 'article':
            require('c-article.php');
            
        break;

        case 'profil':
            //TODO

        break;

        default:
            break;
    }

    switch ($action) {
        case 'voteFor':
            $id_account = (isset($_SESSION['id_user']) && !empty($_SESSION['id_user'])) ? $_SESSION['id_user'] : null;
            $type = (isset($_REQUEST['type']) && !empty($_REQUEST['type'])) ? $_REQUEST['type'] : null;
            $id_hash = (isset($_REQUEST['id_hash']) && !empty($_REQUEST['id_hash'])) ? $_REQUEST['id_hash'] : null;

            if(!User::isCompany($id_account)) {  //Companies cannot vote
                if(!is_null($id_hash)) $article = Article::getArticle($id_hash);
            
                if(isset($article) && $article) {
                    $id_article = $article->id_article;
                }

                if(!is_null($id_account) && !is_null($article) && !is_null($type)) {
                    Article::voteFor($id_account, $id_article, $type);
                    $data = array('id_account' => $id_account, 'id_article' => $id_article);
                    $user_vote = Article::getVote($data);
                }
            }
            
            $votes = Article::getNbVotes($id_article);
            $functions = Article::getAJAXFunctionsVote($id_hash);
            
            require(__DIR__."/../views/v-vote.inc.php");
            break;
        
        default:
            # code...
            break;
    }

?>