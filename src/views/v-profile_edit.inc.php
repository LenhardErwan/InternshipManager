<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Edition - Profil</title>
        <link rel="stylesheet" type="text/css" href="assets/style/reset.css">
        <link rel="stylesheet" type="text/css" href="assets/style/nav.css">
        <link rel="stylesheet" type="text/css" href="assets/style/index.css">
    </head>

    <body>
        <?php require("v-nav.inc.php"); ?>
        <main>
			<div>
                <form action="" method="POST">
                    <fieldset>
                        <?php if($is_company || $is_admin) { ?>
                        <label for="social_reason">*Raison sociale : </label>
                        <input type="text" name="social_reason" id="social_reason" value="<?php if(isset($account->social_reason)) echo $account->social_reason ?>" maxlength="40" required />
                        <br/>
                        <?php } ?>
                        <label for="last_name">*Nom : </label>
                        <input type="text" name="last_name" id="last_name" value="<?php if(isset($account->last_name)) echo $account->last_name ?>" maxlength="15" required />
                        <br/>
                        <label for="first_name">*Prénom : </label>
                        <input type="text" name="first_name" id="first_name" value="<?php if(isset($account->first_name)) echo $account->first_name ?>" maxlength="15" required />
                        <br/>
                        <label for="mail">*E-Mail : </label>
                        <input type="email" name="mail" id="mail" value="<?php if(isset($account->mail)) echo $account->mail ?>" required />
                        <br/>
                        <label for="phone">Téléphone : </label>
                        <input type="tel" name="phone" id="phone" value="<?php if(isset($account->phone)) echo $account->phone ?>" />
                        <br/>
                        <?php if($is_member || $is_admin) { ?>
                        <label for="birth_date">Date de naissance : </label>
                        <input type="date" name="birth_date" id="birth_date" value="<?php if(isset($account->birth_date)) echo $account->birth_date ?>" />
                        <br/>
                        <label for="degrees">Diplômes : </label>
                        <textarea name="degrees" id="degrees" maxlength="500"><?php if(isset($account->degrees)) echo $account->degrees ?></textarea><br/>
                        <?php } ?>
                        <?php if(isset($error) && !empty($error)) { ?>
                        <br/>
                        <div id="error">
                            <?php echo $error ?>
                        </div>
                        <?php } ?>
                        <button type="submit" id="profile_submit" name="action" value="save_profile">Enregistrer</button>
                        <a href="<?php if($is_admin) { echo "?page=admin"; } else { echo "?page=profile&action=get_profile&id="; if(isset($account->id_account) && !empty($account->id_account)) { echo $account->id_account; }} ?>" value="get_profile">Annuler</a>
                        <button type="reset" id="reset">Réinitialisation</button>
                        <button type="button" class="open_modal" onClick="openModal('delete_article')" >Supprimer</button>
                    </fieldset>
                </form>
			</div>
        </main>
        <?php 
            require("v-footer.inc.php");
            $action_to_perform = "delete_account"; 
            require("v-confirm_delete.inc.php"); 
        ?>
    </body>
    <script src="assets/script/modal.js"></script>
</html>