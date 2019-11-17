<?php
    function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    function check_article_data($data) {
        if(empty($data['title'])) {
            throw new Exception('Empty title');
        }
        else {
            if(strlen($data['title']) > 30) {
                throw new Exception("Title too long");
            }
        }

        if(empty($data['begin_date'])) {
            throw new Exception('Empty begin_date');
        }
        else {
            if(!validateDate($data['begin_date'], 'Y-m-d')) {
                throw new Exception('Wrong format for begin_date');
            }
        }

        if(empty($data['end_date'])) {
            throw new Exception('Empty end_date');
        }
        else {
            if(!validateDate($data['end_date'], 'Y-m-d')) {
                throw new Exception('Wrong format for end_date');
            }
        }

        if(empty($data['mission'])) {
            throw new Exception('Empty mission');
        }
        else {
            //TODO verifier la taille ???
        }

        if(empty($data['contact'])) {
            throw new Exception('Empty contact');
        }
        else {
            //TODO verifier la taille ???
        }

        if(!empty($data['attachement'])) {
            //TODO verifier si le fichier existe déja
            //TODO verifier si le format du fichier est bon
            //TODO verifier la taille du fichier
        }
    }


    require_once(__DIR__."/../models/m-article.php");
    require_once(__DIR__."/../models/m-user.php");

    $action = (isset($_REQUEST['action']) ? $_REQUEST['action'] : 'get_article');
    $id_hash = (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) ? $_REQUEST['id'] : null;
    $id_account = (isset($_SESSION['id_user']) && !empty($_SESSION['id_user'])) ?$_SESSION['id_user'] : -1;

    $connected = $id_account > 0;
    if($connected) {
        $is_company = User::isCompany($id_account);
    }

    switch ($action) {
        case 'get_article':
            if(isset($id_hash)) {        
                $article = Article::getArticle($id_hash);
                if($article) {
                    $company = User::getCompanyName($article->id_company);
                    $votes = Article::getNbVotes($article->id_article);
                    $functions = Article::getAJAXFunctionsVote($id_hash);

                    if($connected) {
                        $can_edit = $article->id_company == $id_account;
                        $can_comment = User::isAdmin($id_account);

                        $data = array('id_account' => $id_account, 'id_article' => $article->id_article);
                        $user_vote = Article::getVote($data);
                    }
                    else {
                        $can_edit = $can_comment = false;
                    }
                }
            }
            require(__DIR__."/../views/v-article.inc.php");
            break;

        case 'edit_article':
            if($connected) {
                if(isset($id_hash)) {   //Edit aricle
                    $article = Article::getArticle($id_hash);
                }
    
                if($article->id_company == $id_account || $is_company ) {
                    require(__DIR__."/../views/v-article_edit.inc.php");
                }
            }

            break;

        case 'save_article':
            if($connected && User::isCompany($id_account)) {
                if(isset($id_hash)) {   //Update article
                    $article = Article::getArticle($id_hash);
                    if($article) {
                        $data = array(
                            'title' => $_REQUEST['title'],
                            'begin_date' => $_REQUEST['begin_date'],
                            'end_date' => $_REQUEST['end_date'],
                            'mission' => $_REQUEST['mission'],
                            'contact' => $_REQUEST['contact'],
                            'attachment' =>  (!empty($_REQUEST['attachment']) ? $_REQUEST['attachment'] : NULL),
                            'id_article' => $article->id_article
                        );

                        try {
                            check_article_data($data);
                            Article::updateArticle($data);
                            header('Location: ?page=article&id='.$id_hash);
                            exit();
                        }
                        catch (Exception $e) {
                            echo "Error : ".$e->getMessage();
                        }
                    }
                }
                else {  //Create article
                    $data = array(
                        'id_company' => 5/*$id_account*/,
                        'title' => $_REQUEST['title'],
                        'begin_date' => $_REQUEST['begin_date'],
                        'end_date' => $_REQUEST['end_date'],
                        'mission' => $_REQUEST['mission'],
                        'contact' => $_REQUEST['contact'],
                        'attachment' => (!empty($_REQUEST['attachment']) ? $_REQUEST['attachment'] : NULL)                
                    );

                    try {
                        check_article_data($data);
                        Article::createArticle($data);
                        $article = Article::getLastArticleFromCompany(5/*$id_account*/);
                        header('Location: ?page=article&id='.$article->id_hash);
                        exit();
                    }
                    catch (Exception $e) {
                        echo "Error : ".$e->getMessage();
                    }
                }
            }
        
            break;

        case 'delete_article':
            if(isset($id_hash) && $connected) {        
                $article = Article::getArticle($id_hash);
                if($article && $article->id_company == $id_account) {
                    try {
                        Article::deleteArticle($article->id_article);
                        header('Location: ?page=index');
                        exit();
                    }
                    catch (Exception $e) {
                        echo "Error : ".$e->getMessage();
                    }
                }
            }
            break;
        
        default:
            
            break;
    }

?>