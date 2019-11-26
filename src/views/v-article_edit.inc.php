<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Edition - Article</title>
        <script src="assets/script/modal.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/style/reset.css">
        <link rel="stylesheet" type="text/css" href="assets/style/nav.css">
        <link rel="stylesheet" type="text/css" href="assets/style/confirm.css">
        <link rel="stylesheet" type="text/css" href="assets/style/form.css">
        <link rel="stylesheet" type="text/css" href="assets/style/footer.css">
    </head>

    <body>
    	<?php
            $action_to_perform = "delete_article"; 
            $text = "Êtes-vous sur de vouloir supprimer l'article ?";
            require("v-confirm_delete.inc.php");
        ?>

        <?php require("v-nav.inc.php"); ?>

        <main id="form_main">
            <h1 id="form_title">Editions d'article</h1>
            <form id="form_container" action="" method="POST" enctype="multipart/form-data">
                <div class="form_elmt">
                    <label for="title">*Titre : </label>
                    <input type="text" name="title" id="title" value="<?= (isset($article) ? $article->title : ''); ?>" maxlength="30" required />
                </div>
                <div class="form_errors"><?= (isset($error['title']) ? $error['title'] : ''); ?></div>

                <div class="form_elmt">
                    <label for="begin_date">*Date de début : </label>
                    <input type="date" name="begin_date" id="begin_date" value="<?= (isset($article) ? $article->begin_date : ''); ?>" required />
                </div>
                <div class="form_errors"><?= (isset($error['begin_date']) ? $error['begin_date'] : ''); ?></div>

                <div class="form_elmt">
                    <label for="end_date">*Date de fin : </label>
                    <input type="date" name="end_date" id="end_date" value="<?= (isset($article) ? $article->end_date : ''); ?>" required />
                </div>
                <div class="form_errors"><?= (isset($error['end_date']) ? $error['end_date'] : ''); ?></div>

                <div class="form_elmt_text">
                    <label for="mission">*Mission : </label>
                    <textarea name="mission" id="mission" maxlength="1000" required><?= (isset($article) ? $article->mission : ''); ?></textarea>
                </div>
                <div class="form_errors"><?= (isset($error['mission']) ? $error['mission'] : ''); ?></div>

                <div class="form_elmt_text">
                    <label for="contact">*Contact : </label>
                    <textarea name="contact" id="contact" maxlength="1000" required><?= (isset($article) ? $article->contact : ''); ?></textarea>
                </div>
                <div class="form_errors"><?= (isset($error['contact']) ? $error['contact'] : ''); ?></div>

                <div class="form_elmt">
                    <label for="attachment">Pièce Jointe : </label>
                    <input type="file" class="form_elmt_file" name="attachment" id="attachment"/>
                </div>
                <div class="form_errors"><?= (isset($error['attachment']) ? $error['attachment'] : ''); ?></div>

                <?php if(isset($article->attachment) && !empty($article->attachment)) { ?>
                    <a href="<?= $article->attachment; ?>" download>Télécharger le fichier actuel</div>
                <?php } ?>
                
                <div class="form_submit_container">
                    <button type="submit" class="form_submit" name="action" value="save_article">Enregistrer</button>
                    <a class="form_submit" href="<?php if(isset($status) && ($status == "company") && isset($article) && !empty($article)) { echo "?page=article&action=get_article&id=$article->id_hash"; } else if(isset($status) && $status == "admin") { echo "?page=admin"; } else { echo "?page=index"; } ?>">Annuler</a>
                </div>
                <div class="form_submit_container">
                    <button type="reset" class="form_submit">Réinitialisation</button>
                    <button type="button" class="open_modal form_submit" onClick="openModal('delete_article')" >Supprimer</button>
                </div>
            </form>
        </main>

        <?php require("v-footer.inc.php"); ?>
    </body>
</html>
