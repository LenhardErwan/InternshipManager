<?php
    require_once(__DIR__."/../models/m-article.php");
    require_once(__DIR__."/../models/m-user.php");

    if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
        $id_hash = $_REQUEST['id'];

        $article = Article::getArticle($id_hash);
        if($article) {
            $company = User::getCompanyName($article->id_company);
            $title = $article->title;
            $begin_date = $article->begin_date;
            $end_date = $article->end_date;
            $mission = $article->mission;
            $contact = $article->contact;
            $attachment = $article->attachment;

            $votes = Article::getNbVotes($article->id_article);
            $functions = Article::getAJAXFunctionsVote($id_hash);
        }
        
    }

    require(__DIR__."/../views/v-article.inc.php");

?>