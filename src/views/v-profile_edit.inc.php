<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Edition - Profil</title>
        <script src="assets/script/modal.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/style/reset.css">
        <link rel="stylesheet" type="text/css" href="assets/style/nav.css">
        <link rel="stylesheet" type="text/css" href="assets/style/confirm.css">
        <link rel="stylesheet" type="text/css" href="assets/style/profile_edit.css">
        <link rel="stylesheet" type="text/css" href="assets/style/footer.css">
    </head>

    <body>
        <?php 
            $action_to_perform = "delete_account";
            $text = "Souhaitez-vous vraiment supprimer votre compte ?";
            require("v-confirm_delete.inc.php");
        ?>

        <?php require("v-nav.inc.php"); ?>

        <main id="profile_edit_main">
            <h1 id="profile_edit_title">Editions de profil</h1>
            <form id="profile_edit_form" action="" method="POST">
                <?php if(($account_type == "company") || $is_admin) { ?>
                    <div class="profile_edit_elmt">
                        <label for="social_reason">*Raison sociale : </label>
                        <input type="text" name="social_reason" id="social_reason" value="<?php if(isset($account->social_reason)) echo $account->social_reason ?>" maxlength="40" required />
                    </div>
                <?php } ?>

                <div class="profile_edit_elmt">
                    <label for="last_name">*Nom : </label>
                    <input type="text" name="last_name" id="last_name" value="<?php if(isset($account->last_name)) echo $account->last_name ?>" maxlength="15" required />
                </div>

                <div class="profile_edit_elmt">
                    <label for="first_name">*Prénom : </label>
                    <input type="text" name="first_name" id="first_name" value="<?php if(isset($account->first_name)) echo $account->first_name ?>" maxlength="15" required />
                </div>

                <div class="profile_edit_elmt">
                    <label for="mail">*E-Mail : </label>
                    <input type="email" name="mail" id="mail" value="<?php if(isset($account->mail)) echo $account->mail ?>" required />
                </div>

                <div class="profile_edit_elmt">
                    <label for="phone">Téléphone : </label>
                    <input type="tel" name="phone" id="phone" value="<?php if(isset($account->phone)) echo $account->phone ?>" />
                </div>

                <?php if(($account_type == "member") || $is_admin) { ?>
                    <div class="profile_edit_elmt">
                        <label for="birth_date">Date de naissance : </label>
                        <input type="date" name="birth_date" id="birth_date" value="<?php if(isset($account->birth_date)) echo $account->birth_date ?>" />
                    </div>

                    <div id="profile_edit_degrees">
                        <label for="degrees">Diplômes : </label>
                        <textarea name="degrees" id="degrees" maxlength="500"><?php if(isset($account->degrees)) echo $account->degrees ?></textarea><br/>
                    </div>
                <?php } ?>

                <div id="profile_edit_error"><?php if(isset($error) && !empty($error)) { echo $error; } ?></div>

                <div class="profile_edit_submit">
                    <button type="submit" id="profile_submit" name="action" value="save_profile">Enregistrer</button>
                    <a href="<?php if($is_admin) { echo "?page=admin"; } else { echo "?page=profile&action=get_profile&id="; if(isset($account->id_account) && !empty($account->id_account)) { echo $account->id_account; }} ?>" value="get_profile">Annuler</a>
                </div>
                <div class="profile_edit_submit">
                    <button type="reset" id="reset">Réinitialiser</button>
                    <button type="button" class="open_modal" onClick="openModal('delete_account')" >Supprimer</button>
                </div>
            </form>
        </main>

        <?php 
            require("v-footer.inc.php");
        ?>
    </body>
</html>
