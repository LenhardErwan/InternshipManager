<?php
    require_once(__DIR__."/../models/m-article.php");
    require_once(__DIR__."/../models/m-user.php");
    $action = (isset($_REQUEST['action']) ? $_REQUEST['action'] : '');

    switch ($action) {
        case 'voteFor':
            session_start();
            $id_account = (isset($_SESSION['id_user']) && !empty($_SESSION['id_user'])) ?$_SESSION['id_user'] : null;
            $type = (isset($_REQUEST['type']) && !empty($_REQUEST['type'])) ? $_REQUEST['type'] : null;
            $id_hash = (isset($_REQUEST['id_hash']) && !empty($_REQUEST['id_hash'])) ? $_REQUEST['id_hash'] : null;
            if(!is_null($id_hash)) $article = Article::getArticle($id_hash);
            if(isset($article) && $article) {
                $id_article = $article->id_article;
            }
            if(!is_null($id_account) && !is_null($article) && !is_null($type)) {
                Article::voteFor($id_account, $id_article, $type);
            }
            $votes = Article::getNbVotes($id_article);
            $functions = Article::getAJAXFunctionsVote($id_hash);
            require(__DIR__."/../views/v-vote.inc.php");
            
            exit();

            break;
        
        default:
            # code...
            break;
    }

?>