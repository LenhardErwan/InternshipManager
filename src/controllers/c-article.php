<?php
    function validDate($date, $format = 'Y-m-d H:i:s')
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
            if(!validDate($data['begin_date'], 'Y-m-d')) {
                throw new Exception('Wrong format for begin_date');
            }
        }

        if(empty($data['end_date'])) {
            throw new Exception('Empty end_date');
        }
        else {
            if(!validDate($data['end_date'], 'Y-m-d')) {
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

        if(!empty($data['attachment']['name'])) {
            if($data["attachment"]["error"] == 0) {
                $max_size = 2 * 1024 * 1024; //2Mo
                if($data['attachment']["size"] > $max_size)
                    throw new Exception('File is too large');
            }
            else
                throw new Exception("Transfert error");
        }
    }

    function saveFile($file, $path) {  //Delete all file present in directory and save the submited file
        if ( !file_exists($path) && !is_dir($path) ) {
            mkdir($path);       
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
        move_uploaded_file($file["tmp_name"], $path);
    }

    function getFile($path) {
        if ( file_exists($path) && is_dir($path) ) {
            $files = scandir($path, 1); // get all file names, there is only one file
            $str_explode = explode("/", $path);
            if (is_file($path."/".$files[0])) 
                return "./".$str_explode[sizeof($str_explode)-2]."/".$str_explode[sizeof($str_explode)-1]."/".$files[0];
            else
                return null;
            
        }
        else {
            return null;
        }
    }


    require_once(__DIR__."/../models/m-article.php");
    require_once(__DIR__."/../models/m-user.php");

    $action = (isset($_REQUEST['action']) ? $_REQUEST['action'] : 'get_article');
    $id_hash = (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) ? $_REQUEST['id'] : null;
    $id_account = (isset($_SESSION['id_account']) && !empty($_SESSION['id_account'])) ? $_SESSION['id_account'] : -1;
    $path = __DIR__."/../article-attachments/";

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
                        $attachment = getFile($path.$id_hash);
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
                        $attachment = getFile($path.$id_hash);
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

                        try {
                            check_article_data($data);

                            $path = $path.$id_hash;
                            saveFile($data['attachment'], $path);
                            $data['attachment'] = $path;

                            Article::updateArticle($data);
                        }
                        catch (Exception $e) {
                            $error = "Error : ".$e->getMessage();
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
                        $data['attachment'] = $_FILES['attachment']["tmp_name"];

                        Article::createArticle($data);
                        $article = Article::getLastArticleFromCompany($id_account);
                        
                        $path = $path.$id_hash;
                        saveFile($data['attachment'], $path);
                        $data['attachment'] = $path;

                        Article::updateArticleAttachment(array("attachment" => $path, "id_article" => $article->id_article));

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
            if(isset($id_hash) && $status != "not-connected" && $can_comment) {        
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