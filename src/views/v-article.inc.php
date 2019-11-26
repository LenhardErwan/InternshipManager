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

        <?php if($status == "admin") {
            $action_to_perform = "delete_comment"; 
            $text = "Êtes vous sur de vouloir supprimer votre commentaire ?";
            require("v-confirm_delete.inc.php");
        } ?>

        <?php require("v-nav.inc.php"); ?>

        <main id="article_main">
            <?php if(isset($article) && $article) { ?>
            <h1 id="article_title"><?= $article->title;?></h1>
			<div id="article_content">
                <a id="article_company" href="?page=profile&id=<?= $article->id_company; ?>"><?= $company; ?></a>
                <p><?= $article->begin_date ?> - <?= $article->end_date ?></p>
                <p>Mission : <?= nl2br($article->mission) ?></p>
                <p>Contact : <?= nl2br($article->contact) ?></p>

                <?php if(isset($article->attachment) && !empty($article->attachment)) { ?>
                <a href="<?= $article->attachment ?>" download >Télécharger la pièce jointe</a>
                <?php } ?>
                
                <?php 
                    if(isset($comment) && $comment) require("v-comment.inc.php"); 
                    else if ($status == "admin") {
                ?>
                <form id="article_form_create_comment" action="" method="POST">
                    <button type="submit" class="article_comment_button" id="create_comment" name="action" value="edit_comment">Ajouter un commentaire</button>
                </form>
                <?php } ?>

                <?php require("v-vote.inc.php"); ?>

                <?php if(isset($can_edit) && $can_edit) { ?>
                <form id="article_submit" action="" method="POST">
                    <button type="submit" id="edit_article" name="action" value="edit_article">Editer</button>
                    <span type="button" class="open_modal" onClick="openModal('delete_article')" >Supprimer</span>
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
