<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Offre</title>
        <script src="assets/script/vote.js"></script>
        <script src="assets/script/modal.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/style/reset.css">
        <link rel="stylesheet" type="text/css" href="assets/style/nav.css">
        <link rel="stylesheet" type="text/css" href="assets/style/confirm.css">
        <link rel="stylesheet" type="text/css" href="assets/style/article.css">
        <link rel="stylesheet" type="text/css" href="assets/style/vote.css">
        <link rel="stylesheet" type="text/css" href="assets/style/footer.css">
    </head>

    <body>
        <?php if(isset($can_edit) && $can_edit) { 
            $action_to_perform = "delete_article";
            $text = "Êtes vous sur de vouloir supprimer l'article ?";
            require("v-confirm_delete.inc.php");
        } ?>

        <?php require("v-nav.inc.php"); ?>

        <main id="article_main">
            <?php if(isset($article) && $article) { ?>
            <h1 id="article_title">Article</h1>
			<div id="article_content">
                <p><?= $article->title ?></p>
                <p><?= $company ?></p>
                <p><?= $article->begin_date ?> , <?= $article->end_date ?></p>
                <p><?= nl2br($article->mission) ?></p>
                <p><?= nl2br($article->contact) ?></p>

                <?php if(isset($attachment) && !empty($attachment)) { ?>
                <a href="<?= $attachment ?>" download >Télécharger la pièce jointe</a>
                <?php } ?>
                
                <?php require("v-vote.inc.php"); ?>

                <?php if(isset($can_edit) && $can_edit) { ?>
                <form id="article_submit" action="" method="POST">
                    <button type="submit" id="edit_article" name="action" value="edit_article">Editer</button>
                    <span type="button" class="open_modal" onClick="openModal('delete_article')" >Supprimer</span>
                </form>
                <?php } ?>
                <?php 
                    if(isset($comment) && $comment) require("v-comment.inc.php"); 
                    else if (isset($can_comment) && $can_comment) {
                ?>
                <form action="" method="POST">
                    <button type="submit" id="create_comment" name="action" value="edit_comment">Ajouter Commentaire</button>
                </form>
                <?php } ?>
			</div>
            <?php } else { ?>
                <p>Offre introuvable !</p>
            <?php } ?>
		</main>

        <?php require("v-footer.inc.php"); ?>
    </body>
</html>
