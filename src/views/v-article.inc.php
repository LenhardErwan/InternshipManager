<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Offre</title>
        <link rel="stylesheet" type="text/css" href="assets/style/reset.css">
        <link rel="stylesheet" type="text/css" href="assets/style/nav.css">
        <link rel="stylesheet" type="text/css" href="assets/style/index.css">
    </head>

    <body>
    <?php require("v-nav.inc.php"); ?>
        <main>
			<div>
                <?php if(isset($article) && $article) { ?>

                <h1><?= $article->title ?></h1>
                <h3><?= $company ?></h3>
                <h4><?= $article->begin_date ?> , <?= $article->end_date ?></h4>
                <p><?= nl2br($article->mission) ?></p>
                <p><?= nl2br($article->contact) ?></p>

                <?php if(isset($attachment) && !empty($attachment)) { ?>
                <a href="<?= $attachment ?>" download >Télécharger la pièce jointe</a>
                <?php } ?>
                
                <?php require("v-vote.inc.php"); ?>

                <?php if(isset($can_edit) && $can_edit) { ?>
                <form action="" method="POST">
                    <button type="submit" id="edit_article" name="action" value="edit_article">Editer</button>
                </form>
                <button type="button" class="open_modal" onClick="openModal('delete_article')" >Supprimer</button>
                <?php } ?>
                <?php 
                    if(isset($comment) && $comment) require("v-comment.inc.php"); 
                    else if (isset($can_comment) && $can_comment) {
                ?>
                <form action="" method="POST">
                    <button type="submit" id="create_comment" name="action" value="edit_comment">Ajouter Commentaire</button>
                </form>
                <?php } ?>
                
                <?php } else { ?>

                <p>Offre introuvable !</p>
                
                <?php } ?>

			</div>
		</main>
        <?php require("v-footer.inc.php"); ?>
        <?php if(isset($can_edit) && $can_edit) { 
            $action_to_perform = "delete_article";
            $text = "Êtes vous sur de vouloir supprimer l'article ?";
            require("v-confirm_delete.inc.php"); 
        } ?>
    </body>
    <script src="assets/script/vote.js"></script>
    <script src="assets/script/modal.js"></script>
</html>
