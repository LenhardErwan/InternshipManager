<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Edition - Article</title>
    </head>

    </body>
        <?php require("v-nav.inc.php"); ?>
        <main>
			<div>
                <form action="" method="POST">
                    <fieldset>
                        <label for="title">*Titre : </label>
                        <input type="text" name="title" id="title" value="<?php if(isset($title)) echo $title ?>" maxlength="30" required />
                        <br/>
                        <label for="begin_date">*Date de début : </label>
                        <input type="date" name="begin_date" id="begin_date" value="<?php if(isset($begin_date)) echo $begin_date ?>" required />
                        <br/>
                        <label for="end_date">*Date de fin : </label>
                        <input type="date" name="end_date" id="end_date" value="<?php if(isset($end_date)) echo $end_date ?>" required />
                        <br/>
                        <label for="mission">*Mission : </label>
                        <textarea name="mission" id="mission" value="<?php if(isset($mission)) echo $mission ?>" required></textarea>
                        <br/>
                        <label for="contact">*Contact : </label>
                        <input type="text" name="contact" id="contact" value="<?php if(isset($contact)) echo $contact ?>" required />
                        <br/>
                        <label for="attachment">Pièce Jointe : </label>
                        <input type="file" name="attachment" id="attachment" value="<?php if(isset($attachement)) echo $attachement ?>" />
                        <br/>
                        <button type="submit" id="article_submit" name="action" value="article_submit">Enregistrer</button>
                        <button type="submit" id="cancel" name="action" value="get_article" formnovalidate >Annuler</button>
                        <button type="reset" id="reset">Réinitialisation</button>
                        <button type="button" class="open_modal" onClick="openModal('delete_article')" >Supprimer</button>
                    </fieldset>
                </form>
			</div>
		</main>
        <?php require("v-article_delete.inc.php"); ?>
    </body>
    <script src="assets/script/nav.js"></script>
    <script src="assets/script/modal.js"></script>
</html>