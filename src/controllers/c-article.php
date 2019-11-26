<?php
    function validDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    function check_title(string $title) {
        if(empty($title)) {
            throw new Exception("Champ titre vide");
        } else if(strlen($title) > 30) {
            throw new Exception("Taille du titre trop grande (30 caractères)");
        } else if(!preg_match("/[a-zA-Z0-9ÀàÂâÆæÇçÉéÈèÊêËëÎîÏïÔôŒœÙùÛûÜüŸÿ ]{0,30}/", $title)) {
            throw new Exception("Champ titre invalide (a-zA-Z0-9ÀàÂâÆæÇçÉéÈèÊêËëÎîÏïÔôŒœÙùÛûÜüŸÿ ,.)");
        }
    }

    function check_date(string $date) {
        if(empty($date)) {
            throw new Exception("Champ date vide");
        } else if(!validDate($date, 'Y-m-d')) {
            throw new Exception("Champ date invalide");
        }
    }

    function check_dates(string $begin_date, string $end_date) {
        $end_D = DateTime::createFromFormat('Y-m-d', $end_date);
        $begin_D = DateTime::createFromFormat('Y-m-d', $begin_date);
        
        if($begin_D > $end_D) {
            throw new Exception("Marty, tu voyage dans le temps");
        }
    }

    function check_mission(string $mission) {
        if(empty($mission)) {
            throw new Exception("Champ mission vide");
        } else if(strlen($mission) > 1000) {
            throw new Exception("Taille de la mission trop grande (1000 caractères)");
        } else if(!preg_match("/[a-zA-Z0-9ÀàÂâÆæÇçÉéÈèÊêËëÎîÏïÔôŒœÙùÛûÜüŸÿ\n\r ,.]{0,1000}/", $mission)) {
            throw new Exception("Champ mission invalide (a-zA-Z0-9ÀàÂâÆæÇçÉéÈèÊêËëÎîÏïÔôŒœÙùÛûÜüŸÿ ,.)");
        }
    }

    function check_contact(string $contact) {
        if(empty($contact)) {
            throw new Exception("Champ contact vide");
        } else if(strlen($contact) > 1000) {
            throw new Exception("Taille du champ contact trop grande (1000 caractères)");
        } else if(!preg_match("/[a-zA-Z0-9ÀàÂâÆæÇçÉéÈèÊêËëÎîÏïÔôŒœÙùÛûÜüŸÿ\n\r ,.+@]{0,1000}/", $contact)) {
            throw new Exception("Champ contact invalide (a-zA-Z0-9ÀàÂâÆæÇçÉéÈèÊêËëÎîÏïÔôŒœÙùÛûÜüŸÿ ,.+@)");
        }
    }

    function check_attachment(array $attachment) {
        if(!empty($attachment["name"])) {
            if($attachment["error"] == 0) {
                $max_size = 2 * 1024 * 1024; //2Mo
                
                if($attachment["size"] > $max_size) {
                    throw new Exception("Fichier trop volumineux (2 Mo)");
                }
            } else {
                throw new Exception("Erreur lors du transfert du fichier");
            }
        }
    }

    function check_article_data($submit) {
        try {
            check_title($submit['title']);
            $data['title'] = $submit['title'];
        } catch(Exception $e) {
            $error['title'] = $e->getMessage();
        }

        try {
            check_dates($submit['begin_date'], $submit['end_date']);
        } catch(Exception $e) {
            $error['begin_date'] = $e->getMessage();
        }

        try {
            check_date($submit['begin_date']);
            $data['begin_date'] = $submit['begin_date'];
        } catch(Exception $e) {
            $error['begin_date'] = $e->getMEssage();
        }

        try {
            check_date($submit['end_date']);
            $data['end_date'] = $submit['end_date'];
        } catch(Exception $e) {
            $error['end_date'] = $e->getMessage();
        }

        try {
            check_mission($submit['mission']);
            $data['mission'] = $submit['mission'];
        } catch(Exception $e) {
            $error['mission'] = $e->getMessage();
        }

        try {
            check_contact($submit['contact']);
            $data['contact'] = $submit['contact'];
        } catch(Exception $e) {
            $error['contact'] = $e->getMessage();
        }

        try {
            check_attachment($submit['attachment']);
            $data['attachment'] = $submit['attachment'];
        } catch(Exception $e) {
            $error['attachment'] = $e->getMessage();
        }

        if(empty($error)) {
            $data['valid'] = true;
            return $data;
        } else {
            $error['valid'] = false;
            return $error;
        }
    }

    function saveFile($file, $path) {  //Delete all file present in directory and save the submited file
        $path = __DIR__."/.".$path;
        if ( !file_exists($path) && !is_dir($path) ) {
            mkdir($path, 0777, true);    
        }
        else {
            $path = $path."/";
            $files = scandir($path); // get all file names
            foreach($files as $found_file){ // iterate files
                if(is_file($path.$found_file))
                    unlink($path.$found_file); // delete file
            }
        }
        $path = $path."/".$file["name"];
        return move_uploaded_file($file["tmp_name"], $path);
    }

    function deleteDirectory($path) {
        $path = __DIR__."/.".$path."/";
        $files = scandir($path); // get all file names
        foreach($files as $found_file){ // iterate files
            if(is_file($path.$found_file))
                unlink($path.$found_file); // delete file
        }
        rmdir($path);
    }


    require_once(__DIR__."/../models/m-article.php");
    require_once(__DIR__."/../models/m-user.php");

    $action = (isset($_REQUEST['action']) ? $_REQUEST['action'] : 'get_article');
    $id_hash = (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) ? $_REQUEST['id'] : null;
    $id_account = (isset($_SESSION['id_account']) && !empty($_SESSION['id_account'])) ? $_SESSION['id_account'] : -1;
    $path = "./src/article-attachments/";

    if($id_account > 0) {
        if(User::isMember($id_account)) {
            $status = "member";
        }
        else {
            if(User::isCompany($id_account)) $status = "company";
            else $status = "admin";
        }
    }
    else {
        $status = "not-connected";
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

                    if($status != "not-connected") {
                        $can_edit = $article->id_company == $id_account || $status == "admin";

                        $data = array('id_account' => $id_account, 'id_article' => $article->id_article);
                        $user_vote = Article::getVote($data);
                        if(!$user_vote) unset($user_vote);  //If the return value is false (user doesn't vote)
                    }
                }
            }
            require(__DIR__."/../views/v-article.inc.php");
            break;

        case 'edit_article':
            if($status != "not-connected") {
                if(isset($id_hash)) {   //Edit article
                    $article = Article::getArticle($id_hash);
                    if($article && ($article->id_company == $id_account || $status == "admin")) {
                        require(__DIR__."/../views/v-article_edit.inc.php");
                    }
                    else {  //Article not found or user cannot edit
                        header('Location: ?page=article&id='.$id_hash);
                        exit();
                    }
                }
    
                else if($status == "company") {   //Create article
                    require(__DIR__."/../views/v-article_edit.inc.php");
                }
                else {
                    header('Location: ?page=index');
                }
            } else {
                header('Location: ?page=index');
            }

            break;

        case 'save_article':
            if($status != "not-connected" && ($status == "company" || $status == "admin")) {
                $data = array(
                    'title' => htmlentities($_REQUEST['title'], ENT_COMPAT, "UTF-8"),
                    'begin_date' =>  htmlentities($_REQUEST['begin_date'], ENT_COMPAT, "UTF-8"),
                    'end_date' =>  htmlentities($_REQUEST['end_date'], ENT_COMPAT, "UTF-8"),
                    'mission' =>  htmlentities($_REQUEST['mission'], ENT_COMPAT, "UTF-8"),
                    'contact' =>  htmlentities($_REQUEST['contact'], ENT_COMPAT, "UTF-8"),
                    'attachment' => $_FILES['attachment']
                );

                if(isset($id_hash)) {   //Update article
                    $article = Article::getArticle($id_hash);
                    if($article) {
                        $data['id_article'] = $article->id_article;
                            
                        $result = check_article_data($data);

                        if($result['valid']) {
                            $path = $path.$id_hash;
                            if(isset($_REQUEST['keep_attachment']) &&  $_REQUEST['keep_attachment'] == "keep") {
                                $data['attachment'] = $article->attachment;
                            }
                            else if(empty($data['attachment'])) {
                                $data['attachment'] = null;
                            }
                            else {
                                $saved = saveFile($data['attachment'], $path);
                                $data['attachment'] = $path."/".$data['attachment']["name"];
                            }

                            Article::updateArticle($data);
                        } else {
                            $error = $result;
                            require(__DIR__."/../views/v-article_edit.inc.php");
                            exit();
                        }
                    }

                    if($status == "company") {
                        header('Location: ?page=article&id='.$id_hash);
                    }
                    else if ($status == "admin") {
                        header('Location: ?page=admin');
                    }
                    exit();
                }
                else {  //Create article
                    $data['id_company'] = $id_account;

                    try {
                        check_article_data($data);

                        if(empty($data['attachment'])) {
                            $saved = false;
                        }
                        else {
                            $saved = saveFile($data['attachment'], $path);
                        }
                        $data['attachment'] = ($saved) ? $path."/".$data['attachment']["name"] : null;

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
            if(isset($id_hash) && $status != "not-connected") {        
                $article = Article::getArticle($id_hash);
                if($article && ($article->id_company == $id_account || $status == "admin")) {
                    Article::deleteArticle($article->id_article);
                    deleteDirectory($path.$id_hash);

                    if($status == "company") {
                        header('Location: ?page=index');
                    }
                    else if($status == "admin") {
                        header('Location: ?page=admin');
                    }
                    exit();
                }
            }
            break;

        case 'edit_comment':
            if(isset($id_hash) && $status == "admin") {
                $article = Article::getArticle($id_hash);
                if($article) {
                    $data = array('id_admin' => $id_account, 'id_article' => $article->id_article);
                    $comment = Article::getComment($data);
                }

                require(__DIR__."/../views/v-comment_edit.inc.php");
            }

            break;

        case 'save_comment':
            if(isset($id_hash) && $status == "admin") {        
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
            if(isset($id_hash) && $status == "admin") {        
                $article = Article::getArticle($id_hash);
                if($article) {
                    $data = array('id_admin' => $id_account, 'id_article' => $article->id_article);
                    Article::deleteComment($data);
                }

                header('Location: ?page=article&id='.$id_hash);
                exit();
            }
            break;

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
                        if(!$user_vote) unset($user_vote);  //If the return value is false (user doesn't vote)
                    }
                }
            
                $votes = Article::getNbVotes($id_article);
                $functions = Article::getAJAXFunctionsVote($id_hash);
                
                require(__DIR__."/../views/v-vote.inc.php");
            }
            break;
        
        default:
            
            break;
        
    }

?>