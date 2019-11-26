<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Edition - Commentaire</title>
        <script src="src/assets/script/modal.js"></script>
        <link rel="stylesheet" type="text/css" href="src/assets/style/reset.css">
        <link rel="stylesheet" type="text/css" href="src/assets/style/nav.css">
        <link rel="stylesheet" type="text/css" href="src/assets/style/form.css">
        <link rel="stylesheet" type="text/css" href="src/assets/style/confirm.css">
        <link rel="stylesheet" type="text/css" href="src/assets/style/footer.css">
    </head>

    <body>
        <?php 
            $action_to_perform = "delete_comment"; 
            $text = "Êtes vous sur de vouloir supprimer votre commentaire ?";
            require("v-confirm_delete.inc.php");
        ?>

        <?php require("v-nav.inc.php") ?>
        <main id="form_main">
            <h1 id="form_title">Commentaire</h1>
            <form id="form_container" action="" method="POST">
                <div class="form_elmt_text">
                    <label for="text">*Text : </label>
                    <textarea name="text" id="text" required><?php if(isset($comment) && $comment) echo $comment->text ?></textarea>
                </div>
            
                <div class="form_submit_container">
                    <button type="submit" class="form_submit" name="action" value="save_comment">Enregistrer</button>
                    <button type="submit" class="form_submit" name="action" value="get_article" formnovalidate >Annuler</button>
                </div>
                <div class="form_submit_container">
                    <button type="reset" class="form_submit">Réinitialiser</button>
                    <button type="button" class="open_modal form_submit" onClick="openModal('delete_comment')" >Supprimer</button>
                </div>
            </form>
        </main>

        <?php require("v-footer.inc.php"); ?>
    </body>
</html>