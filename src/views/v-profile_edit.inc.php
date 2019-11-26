<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Edition - Profil</title>
        <script src="src/assets/script/modal.js"></script>
        <link rel="stylesheet" type="text/css" href="src/assets/style/reset.css">
        <link rel="stylesheet" type="text/css" href="src/assets/style/nav.css">
        <link rel="stylesheet" type="text/css" href="src/assets/style/confirm.css">
        <link rel="stylesheet" type="text/css" href="src/assets/style/form.css">
        <link rel="stylesheet" type="text/css" href="src/assets/style/footer.css">
    </head>

    <body>
        <?php 
            $action_to_perform = "delete_profile";
            $text = "Souhaitez-vous vraiment supprimer votre compte ?";
            require("v-confirm_delete.inc.php");
        ?>
        <?php if($id_user == $id_account) require("v-profile_password.inc.php") ?>
        <?php require("v-nav.inc.php"); ?>

        <main id="form_main">
            <h1 id="form_title">Editions de profil</h1>
            <form id="form_container" action="" method="POST">
                <?php if(($account_type == "company") || (($account_type == "company") && ($status == "admin"))) { ?>
                    <div class="form_elmt">
                        <label for="social_reason">*Raison sociale : </label>
                        <input type="text" name="social_reason" id="social_reason" value="<?= (isset($account->social_reason) ? $account->social_reason : ''); ?>" maxlength="40" required />
                    </div>
                    <div class="form_errors"><?= (isset($error['social_reason']) ? $error['social_reason'] : '');?></div>
                <?php } ?>

                <div class="form_elmt">
                    <label for="last_name">*Nom : </label>
                    <input type="text" name="last_name" id="last_name" value="<?= (isset($account->last_name) ? $account->last_name : ''); ?>" maxlength="15" required />
                </div>
                <div class="form_errors"><?= (isset($error['last_name']) ? $error['last_name'] : ''); ?></div>

                <div class="form_elmt">
                    <label for="first_name">*Prénom : </label>
                    <input type="text" name="first_name" id="first_name" value="<?= (isset($account->first_name) ? $account->first_name : ''); ?>" maxlength="15" required />
                </div>
                <div class="form_errors"><?= (isset($error['first_name']) ? $error['first_name'] : ''); ?></div>

                <div class="form_elmt">
                    <label for="mail">*E-Mail : </label>
                    <input type="email" name="mail" id="mail" value="<?= (isset($account->mail) ? $account->mail : ''); ?>" required />
                </div>
                <div class="form_errors"><?= (isset($error['mail']) ? $error['mail'] : ''); ?></div>

                <div class="form_elmt">
                    <label for="phone">Téléphone : </label>
                    <input type="tel" name="phone" id="phone" value="<?= (isset($account->phone) ? $account->phone : ''); ?>" />
                </div>
                <div class="form_errors"><?= (isset($error['phone']) ? $error['phone'] : ''); ?></div>

                <?php if(($account_type == "member") || (($account_type == "member") && ($status == "admin"))) { ?>
                    <div class="form_elmt">
                        <label for="birth_date">Date de naissance : </label>
                        <input type="date" name="birth_date" id="birth_date" value="<?= (isset($account->birth_date) ? $account->birth_date : ''); ?>" />
                    </div>
                    <div class="form_errors"><?= (isset($error['birth_date']) ? $error['birth_date'] : ''); ?></div>

                    <div class="form_elmt_text">
                        <label for="degrees">Diplômes : </label>
                        <textarea name="degrees" id="degrees" maxlength="500"><?= (isset($account->degrees) ? $account->degrees : ''); ?></textarea><br/>
                    </div>
                    <div class="form_errors"><?= (isset($error['degrees']) ? $error['degrees'] : ''); ?></div>
                <?php } ?>

                <div class="form_submit_container">
                    <button type="submit"  class="form_submit" name="action" value="save_profile">Enregistrer</button>
                    <button type="button" class="open_modal form_submit" onClick="openModal('form_modal')" >Modifier le mot de passe</button>
                </div>
                <div class="form_submit_container">
                    <button type="reset" class="form_submit">Réinitialiser</button>
                    <a class="form_submit" href="<?php if($status == "admin") { echo "?page=admin"; } else { echo "?page=profile&action=get_profile&id="; if(isset($account->id_account) && !empty($account->id_account)) { echo $account->id_account; }} ?>" value="get_profile">Annuler</a>
                    <button type="button" class="open_modal form_submit" onClick="openModal('delete_profile')" >Supprimer</button>
                </div>
            </form>
        </main>

        <?php 
            require("v-footer.inc.php");
        ?>
    </body>
</html>
