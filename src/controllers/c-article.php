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
    $id_account = (isset($_SESSION['id_account']) && !empty($_SESSION['id_account'])) ? $_SESSION['id_account'] : -1;

    $connected = $id_account > 0;
    if($connected) {
        $is_company = User::isCompany($id_account);
        $can_comment = User::isAdmin($id_account);
    }

    switch ($action) {
        case 'get_article':
            if(isset($id_hash)) {        
                $article = Article::getArticle($id_hash);
                if($article) {
                    $company = User::getCompanyName($article->id_company);
                    $votes = Article::getNbVotes($article->id_article);
                    $functions = Article::getAJAXFunctionsVote($id_hash);
                    $comment = Article::getCommentFromArticle($article->id_article);

                    if($connected) {
                        $can_edit = $article->id_company == $id_account;

                        $data = array('id_account' => $id_account, 'id_article' => $article->id_article);
                        $user_vote = Article::getVote($data);
                    }
                }
            }
            require(__DIR__."/../views/v-article.inc.php");
            break;

        case 'edit_article':
            if($connected) {
                if(isset($id_hash)) {   //Edit aricle
                    $article = Article::getArticle($id_hash);
                    if($article && $article->id_company == $id_account) {
                        require(__DIR__."/../views/v-article_edit.inc.php");
                    }
                    else {  //Article not found or not the same company id
                        header('Location: ?page=article&id='.$id_hash);
                        exit();
                    }
                }
    
                else if($is_company) {   //Create article
                    require(__DIR__."/../views/v-article_edit.inc.php");
                }
            }

            break;

        case 'save_article':
            if($connected && User::isCompany($id_account)) {
                $data = array(
                    'title' => htmlentities($_REQUEST['title'], ENT_COMPAT, "UTF-8"),
                    'begin_date' =>  htmlentities($_REQUEST['begin_date'], ENT_COMPAT, "UTF-8"),
                    'end_date' =>  htmlentities($_REQUEST['end_date'], ENT_COMPAT, "UTF-8"),
                    'mission' =>  htmlentities($_REQUEST['mission'], ENT_COMPAT, "UTF-8"),
                    'contact' =>  htmlentities($_REQUEST['contact'], ENT_COMPAT, "UTF-8"),
                    'attachment' =>  (!empty($_REQUEST['attachment']) ?  htmlentities($_REQUEST['attachment'], ENT_COMPAT, "UTF-8") : NULL)
                );

                if(isset($id_hash)) {   //Update article
                    $article = Article::getArticle($id_hash);
                    if($article) {
                        $data['id_article'] = $article->id_article;

                        try {
                            check_article_data($data);
                            Article::updateArticle($data);
                        }
                        catch (Exception $e) {
                            echo "Error : ".$e->getMessage();
                        }
                    }

                    header('Location: ?page=article&id='.$id_hash);
                    exit();
                }
                else {  //Create article
                    $data['id_company'] = $id_account;

                    try {
                        check_article_data($data);
                        Article::createArticle($data);
                        $article = Article::getLastArticleFromCompany($id_account);
                        header('Location: ?page=article&id='.$article->id_hash);
                        exit();
                    }
                    catch (Exception $e) {
                        echo "Error : ".$e->getMessage();
                    }
                }
            }
            header('Location: ?page=index');
            exit();
        
            break;

        case 'delete_article':
            if(isset($id_hash) && $connected) {        
                $article = Article::getArticle($id_hash);
                if($article && $article->id_company == $id_account) {
                    Article::deleteArticle($article->id_article);
                    header('Location: ?page=index');
                    exit();
                }
            }
            break;

        case 'edit_comment':
            if(isset($id_hash) && $connected && $can_comment) {
                $article = Article::getArticle($id_hash);
                if($article) {
                    $data = array('id_admin' => $id_account, 'id_article' => $article->id_article);
                    $comment = Article::getComment($data);
                }

                require(__DIR__."/../views/v-comment_edit.inc.php");
            }

            break;

        case 'save_comment':
            if(isset($id_hash) && $connected && $can_comment) {        
                $article = Article::getArticle($id_hash);
                if($article) {
                    $data = array('id_admin' => $id_account, 'id_article' => $article->id_article);
                    $comment = Article::getComment($data);

                    $text = $_REQUEST['text'];
                    $data['text'] = $text;

                    if($comment) {  // There's already a comment
                        Article::updateComment($data);
                    }
                    else {
                        Article::createComment($data);
                    }

                    header('Location: ?page=article&id='.$id_hash);
                    exit();
                }
            }
            break;

        case 'delete_comment':
            if(isset($id_hash) && $connected && $can_comment) {        
                $article = Article::getArticle($id_hash);
                if($article) {
                    $data = array('id_admin' => $id_account, 'id_article' => $article->id_article);
                    Article::deleteComment($data);
                }

                header('Location: ?page=article&id='.$id_hash);
                exit();
            }
            break;
        
        default:
            
            break;
    }

?>