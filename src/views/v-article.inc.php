<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Offre</title>
    </head>

    </body>
        <?php //TODO - Inclure le nav ?>
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

                <?php require_once("v-vote.inc.php"); ?>
                
                <?php } else { ?>

                <p>Offre introuvable !</p>
                
                <?php } ?>
			</div>
		</main>
    </body>
    <script src="assets/script/nav.js"></script>
    <script src="assets/script/vote.js"></script>
</html>