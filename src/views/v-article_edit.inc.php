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
                        <input type="text" name="title" id="title" value="<?php if(isset($article) && $article) echo $article->title ?>" maxlength="30" required />
                        <br/>
                        <label for="begin_date">*Date de début : </label>
                        <input type="date" name="begin_date" id="begin_date" value="<?php if(isset($article) && $article) echo $article->begin_date ?>" required />
                        <br/>
                        <label for="end_date">*Date de fin : </label>
                        <input type="date" name="end_date" id="end_date" value="<?php if(isset($article) && $article) echo $article->end_date ?>" required />
                        <br/>
                        <label for="mission">*Mission : </label>
                        <textarea name="mission" id="mission" required><?php if(isset($article) && $article) echo $article->mission ?></textarea>
                        <br/>
                        <label for="contact">*Contact : </label>
                        <textarea name="contact" id="contact" required><?php if(isset($article) && $article) echo $article->contact ?></textarea>
                        <br/>
                        <label for="attachment">Pièce Jointe : </label>
                        <input type="file" name="attachment" id="attachment" />
                        <?php if(isset($article) && $article && !empty($article->attachment)) { ?>
                        <div>Fichier actuel : <?= $article->attachment ?> </div>
                        <?php } ?>
                        <br/>
                        <?php if(isset($error) && !empty($error)) { ?>
                        <div id="error">
                            <?php echo $error ?>
                        </div>
                        <?php } ?>
                        <br/>
                        <button type="submit" id="article_submit" name="action" value="save_article">Enregistrer</button>
                        <a href="<?php if($is_company) {echo "?page=article&action=get_article&id=$article->id_hash"; } else if($is_admin) { echo "?page=admin";} ?>">Annuler</a>
                        <button type="reset" id="reset">Réinitialisation</button>
                        <button type="button" class="open_modal" onClick="openModal('delete_article')" >Supprimer</button>
                    </fieldset>
                </form>
			</div>
        </main>
        <?php 
            require("v-footer.inc.php");
            $action_to_perform = "delete_article"; 
            $text = "Êtes vous sur de vouloir supprimer l'article ?";
            require("v-confirm_delete.inc.php"); 
        ?>
    </body>
    <script src="assets/script/modal.js"></script>
</html>