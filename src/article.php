<?php
    if (!empty($_REQUEST['id'])) {
        $id = $_REQUEST['id'];
        include_once("./assets/script/ConfDB.inc.php");
        try {
            $prepare = $DB->prepare("SELECT * FROM article WHERE id_hash= ? ;");
            $prepare->execute(array($id)); 
        }
        catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
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
        catch (Exception $e) {
            die("ERREUR : ".$e->getMessage());
        }
        
        $company = $prepare->fetch(PDO::FETCH_COLUMN);
    }

    session_start();
    include_once("./assets/script/validSignin.php");
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Offre</title>
    </head>

    </body>
        <?php require_once('./assets/script/nav.php'); ?>
        <main>
			<div>
                <?php if(isset($title)) { ?>

                <h1><?php echo $title ?></h1>
                <h3><?php echo $company ?></h3>
                <h4><?php echo $begin_date ?> , <?php echo $end_date ?></h4>
                <p><?php echo $mission ?></p>
                <p><?php echo $contact ?></p>

                <?php if(isset($attachment)) { ?>
                <p><?php echo $attachment ?></p>
                <?php } ?>

                <?php $_GET['id_article'] = $id_article; require_once('./assets/script/vote.php'); ?>
                
                <?php } else { ?>

                <p>Offre introuvable !</p>
                
                <?php } ?>
			</div>
		</main>
    </body>
    <script src="assets/script/nav.js"></script>
    <script src="assets/script/vote.js"></script>
</html>