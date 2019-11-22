<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Edition - Commentaire</title>
        <link rel="stylesheet" type="text/css" href="assets/style/reset.css">
        <link rel="stylesheet" type="text/css" href="assets/style/nav.css">
        <link rel="stylesheet" type="text/css" href="assets/style/index.css">
    </head>

    </body>
        <?php require("v-nav.inc.php") ?>
        <main>
			<div>
                <form action="" method="POST">
                    <fieldset>
                        <label for="text">*Text : </label>
                        <textarea name="text" id="text" required><?php if(isset($comment) && $comment) echo $comment->text ?></textarea>
                        <br/>
                        <button type="submit" id="comment_submit" name="action" value="save_comment">Enregistrer</button>
                        <button type="submit" id="cancel" name="action" value="get_article" formnovalidate >Annuler</button>
                        <button type="reset" id="reset">Réinitialisation</button>
                        <button type="button" class="open_modal" onClick="openModal('delete_comment')" >Supprimer</button>
                    </fieldset>
                </form>
			</div>
        </main>
        <?php 
            require("v-footer.inc.php");
            $action_to_perform = "delete_comment"; 
            $text = "Êtes vous sur de vouloir supprimer votre commentaire ?";
            require("v-confirm_delete.inc.php"); 
        ?>
    </body>
    <script src="assets/script/modal.js"></script>
</html>