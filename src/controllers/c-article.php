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
            }
            require(__DIR__."/../views/v-article.inc.php");
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
            if(isset($id_hash)) {        
                $article = Article::getArticle($id_hash);
                if($article) {
                    $data = array(
                        'title' => $_REQUEST['title'],
                        'begin_date' => $_REQUEST['begin_date'],
                        'end_date' => $_REQUEST['end_date'],
                        'mission' => $_REQUEST['mission'],
                        'contact' => $_REQUEST['contact'],
                        'attachment' => $_REQUEST['attachment'],
                        'id_article' => $article->id_article
                    );

                    try {
                        check_article_data($data);
                        Article::updateArticle($data);
                        //TODO redirection vers la page de l'article
                    }
                    catch (Exception $e) {
                        echo "Error : ".$e->getMessage();
                    }
                }
            }
        
            break;

        case 'delete_article':
            # code...
            break;
        
        default:
            echo $action;
            break;
    }

?>