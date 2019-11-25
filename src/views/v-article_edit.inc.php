<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Edition - Article</title>
        <script src="assets/script/modal.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/style/reset.css">
        <link rel="stylesheet" type="text/css" href="assets/style/nav.css">
        <link rel="stylesheet" type="text/css" href="assets/style/confirm.css">
        <link rel="stylesheet" type="text/css" href="assets/style/article_edit.css">
        <link rel="stylesheet" type="text/css" href="assets/style/footer.css">
    </head>

    <body>
    	<?php
            $action_to_perform = "delete_article"; 
            $text = "Êtes-vous sur de vouloir supprimer l'article ?";
            require("v-confirm_delete.inc.php");
        ?>

        <?php require("v-nav.inc.php"); ?>

        <main id="article_edit_main">
            <h1 id="article_edit_title">Editions d'article</h1>
            <form id="article_edit_form" action="" method="POST" enctype="multipart/form-data">
                <div class="article_edit_elmt">
                    <label for="title">*Titre : </label>
                    <input type="text" name="title" id="title" value="<?= (isset($article) ? $article->title : ''); ?>" maxlength="30" required />
                </div>
                <div class="artice_edit_error"><?= (isset($error['title']) ? $error['title'] : ''); ?></div>

                <div class="article_edit_elmt">
                    <label for="begin_date">*Date de début : </label>
                    <input type="date" name="begin_date" id="begin_date" value="<?= (isset($article) ? $article->begin_date : ''); ?>" required />
                </div>
                <div class="artice_edit_error"><?= (isset($error['begin_date']) ? $error['begin_date'] : ''); ?></div>

                <div class="article_edit_elmt">
                    <label for="end_date">*Date de fin : </label>
                    <input type="date" name="end_date" id="end_date" value="<?= (isset($article) ? $article->end_date : ''); ?>" required />
                </div>
                <div class="artice_edit_error"><?= (isset($error['end_date']) ? $error['end_date'] : ''); ?></div>

                <div class="article_edit_textarea">
                    <label for="mission">*Mission : </label>
                    <textarea name="mission" id="mission" maxlength="1000" required><?= (isset($article) ? $article->mission : ''); ?></textarea>
                </div>
                <div class="artice_edit_error"><?= (isset($error['mission']) ? $error['mission'] : ''); ?></div>

                <div class="article_edit_textarea">
                    <label for="contact">*Contact : </label>
                    <textarea name="contact" id="contact" maxlength="1000" required><?= (isset($article) ? $article->contact : ''); ?></textarea>
                </div>
                <div class="artice_edit_error"><?= (isset($error['contact']) ? $error['contact'] : ''); ?></div>

                <div class="article_edit_elmt">
                    <label for="attachment">Pièce Jointe : </label>
                    <input type="file" name="attachment" id="attachment"/>
                </div>
                <div class="artice_edit_error"><?= (isset($error['attachment']) ? $error['attachment'] : ''); ?></div>

                <?php if(isset($article->attachment) && !empty($article->attachment)) { ?>
                    <a id="article_edit_info" href="<?= $article->attachment; ?>" download>Télécharger le fichier actuel</div>
                <?php } ?>
                
                <div class="article_edit_submit">
                    <button type="submit" id="article_submit" name="action" value="save_article">Enregistrer</button>
                    <a href="<?php if(isset($status) && ($status == "company") && isset($article) && !empty($article)) { echo "?page=article&action=get_article&id=$article->id_hash"; } else if(isset($status) && $status == "admin") { echo "?page=admin"; } else { echo "?page=index"; } ?>">Annuler</a>
                </div>
                <div class="article_edit_submit">
                    <button type="reset" id="reset">Réinitialisation</button>
                    <button type="button" class="open_modal" onClick="openModal('delete_article')" >Supprimer</button>
                </div>
            </form>
        </main>

        <?php require("v-footer.inc.php"); ?>
    </body>
</html>
