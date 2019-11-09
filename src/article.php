<?php
    if (!empty($_REQUEST['id'])) {
        $id = $_REQUEST['id'];
        include("./assets/script/ConfDB.inc.php");
        global $DB;
        try {
            $prepare = $DB->prepare("SELECT * FROM article WHERE id_hash=?;");
            $prepare->execute(array($id)); 
        }
        catch (Execption $e) {
            die("ERREUR : ".$e);
        }

        $row = $prepare->fetch(PDO::FETCH_OBJ);
        $id_article = $row->id_article;
        $publication_date = $row->publication_date;
        $title = $row->title;
        $begin_date = $row->begin_date;
        $end_date = $row->end_date;
        $mission = $row->mission;
        $contact = $row->contact;
        $attachment = $row->attachment;
        
        try {
            $prepare = $DB->prepare("SELECT social_reason FROM company WHERE id_company = ?;");
            $prepare->execute(array($row->id_company));   
        }
        catch (Execption $e) {
            die("ERREUR : ".$e);
        }
        
        $company = $prepare->fetch(PDO::FETCH_COLUMN);
    }
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Offre</title>
        <script src="assets/script/nav.js"></script>
    </head>

    </body>
        <?php require_once('./assets/script/nav.php'); ?>
        <main>
			<div>
                <?php
                    require_once('./assets/script/vote.php');
                    if(isset($title)) {
                        $result = "<h1>$title</h1>\n";
                        $result .= "<h3>$company</h3>\n";
                        $result .= "<h4>$begin_date , $end_date</h4>\n";
                        $result .= "<p>$mission</p>\n";
                        $result .= "<p>$contact</p>\n";
                        $result .= "<p>$attachment</p>\n";
                        $result .= getVote($id_article);
                    }
                    else {
                        $result = "<p>Offre introuvable !</p>\n";
                    }

                    echo $result;
                ?>
			</div>
		</main>
    </body>
</html>