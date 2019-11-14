<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Offre</title>
    </head>

    </body>
    <?php require("v-nav.inc.php"); ?>
        <main>
			<div>
                <?php if(isset($article) && $article) { ?>

                <h1><?= $article->title ?></h1>
                <h3><?= $company ?></h3>
                <h4><?= $article->begin_date ?> , <?= $article->end_date ?></h4>
                <p><?= $article->mission ?></p>
                <p><?= $article->contact ?></p>

                <?php if(isset($article->attachment)) { ?>
                <p><?= $article->attachment ?></p>
                <?php } ?>

                <?php require("v-vote.inc.php"); ?>

                <?php if($is_creator) { ?>
                <form action="" method="POST" id="modif" >
                    <button type="submit" id="edit_article" name="action" value="edit_article">Editer</button>
                </form>
                <button type="button" class="open_modal" onClick="openModal('delete_article')" >Supprimer</button>
                <?php } ?>
                
                <?php } else { ?>

                <p>Offre introuvable !</p>
                
                <?php } ?>
			</div>
		</main>
        <?php require("v-footer.inc.php"); ?>
        <?php if(isset($is_creator) && $is_creator) require("v-article_delete.inc.php"); ?>
    </body>
    <script src="assets/script/vote.js"></script>
    <script src="assets/script/modal.js"></script>
</html>