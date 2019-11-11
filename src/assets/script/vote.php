<?php 
    include_once("ConfDB.inc.php");
    include_once("validSignin.php");

    function vote(int $id_account, string $id_hash, string $type) {
        global $DB;
        global $id_article;
        $type = $type == "like" ? '1' : '0';
        
        try {
            $prepare = $DB->prepare("SELECT * FROM article WHERE id_hash = ? ;");
            $prepare->execute(array($id_hash)); 
            $result = $prepare->fetch(PDO::FETCH_OBJ);
            
            if($result) {
                $id_article = $result->id_article;
                $prepare = $DB->prepare("SELECT positive FROM vote WHERE id_user = :id_account AND id_article = :id_article;"); //Check if user already vote for this article
                $prepare->execute(array('id_account' => $id_account, 'id_article' => $id_article));
                $result = $prepare->fetch(PDO::FETCH_OBJ);

                if($result) {   //User already vote for this article
                    if($result->positive == $type) {    //If the user has already voted the same thing
                        //Then delete user's vote
                        $prepare = $DB->prepare("DELETE FROM vote WHERE id_user = :id_account AND id_article = :id_article;");
                        $prepare->execute(array('id_account' => $id_account, 'id_article' => $id_article));    
                    }
                    else {  
                        //Else update user's vote
                        $prepare = $DB->prepare("UPDATE vote SET positive = :vote WHERE id_user = :id_account AND id_article = :id_article;");
                        $prepare->execute(array('id_account' => $id_account, 'id_article' => $id_article, 'vote' => $type));  
                    }
                }
                else {
                    //Else create user's vote
                    $prepare = $DB->prepare("INSERT INTO vote (id_user, id_article, positive) VALUES (:id_account, :id_article, :vote);");
                    $prepare->execute(array('id_account' => $id_account, 'id_article' => $id_article, 'vote' => $type));    
                }
            }
        }
        catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
    }

    function getVote(int $id_article) {
        global $DB;
        $nbPositive = 0;
        $nbNegative = 0;

        try {
            $prepare = $DB->prepare("SELECT positive FROM vote WHERE id_article = ? ;");
            $prepare->execute(array($id_article));
        }
        catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }

        while($line = $prepare->fetch(PDO::FETCH_OBJ)) {
            if($line->positive == 1) $nbPositive++;
            else $nbNegative++;
        }

        $result = array('positive' => $nbPositive, 'negative' => $nbNegative);

        return $result;
    }

    if(isset($_GET['id_hash']) && isset($_GET['id_user']) && isset($_GET['type'])) {
        vote($_GET['id_user'], $_GET['id_hash'], $_GET['type']);

        $likeFunction = "vote(this, ".$_GET['id_user'].", 'like')";
        $dislikeFunction = "vote(this, ".$_GET['id_user'].", 'dislike')";

        $votes = getVote($id_article);
        $id_hash = $_GET['id_hash'];
    }

    if(isset($_GET['id_article'])) {
        if(validSignin()) {

            $likeFunction = "vote(this, ".$_SESSION['id_user'].", 'like')";
            $dislikeFunction = "vote(this, ".$_SESSION['id_user'].", 'dislike')";
        }
        else {
            $likeFunction = "alert('Connectez-vous !')";
            $dislikeFunction = $likeFunction;
        }
        $id_hash = $_REQUEST['id'];
        $votes = getVote($_GET['id_article']);
    }
?>

<?php if(isset($votes)) { ?>
    <div class="vote" id="<?php echo $id_hash ?>">
        <button class="like" onclick="<?php echo $likeFunction ?>">like</button><span><?php echo $votes['positive'] ?></span>
        <button class="dislike" onclick="<?php echo $dislikeFunction ?>">dislike</button><span><?php echo $votes['negative'] ?></span>
    </div>
<?php } ?>