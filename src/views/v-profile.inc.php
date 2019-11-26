<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Profil - <?php if($account_type == "company") { echo $account->social_reason; } else if (isset($account) && !empty($account)) { echo $account->last_name; } else { echo "Introuvable"; } ?></title>
        <script src="src/assets/script/modal.js"></script>
        <link rel="stylesheet" type="text/css" href="src/assets/style/reset.css">
        <link rel="stylesheet" type="text/css" href="src/assets/style/nav.css">
        <link rel="stylesheet" type="text/css" href="src/assets/style/profile.css">
        <link rel="stylesheet" type="text/css" href="src/assets/style/form.css">
        <link rel="stylesheet" type="text/css" href="src/assets/style/footer.css">
    </head>

    <body>
        <?php if($id_user == $id_account) require("v-profile_password.inc.php") ?>
        <?php require("v-nav.inc.php"); ?>
        
        <main id="profile_main">
            <?php if(isset($account) && $account) { ?>
            <h1 id="profile_title">Profil - <?php if($account_type == "company") { echo $account->social_reason; } else { echo $account->last_name; } ?></h1>
			<div id="profile_content">
				<?php if($account_type == "company") { ?>
					<div class="profile_elmt"><p>Raison sociale :</p><p><?= $account->social_reason; ?></p></div>
				<?php } ?>
                <div class="profile_elmt"><p>Nom :</p><p><?= $account->last_name; ?></p></div>
                <div class="profile_elmt"><p>Prénom :</p><p><?= $account->first_name; ?></p></div>
                <div class="profile_elmt"><p>E-Mail :</p><p><?= $account->mail; ?></p></div>
                <div class="profile_elmt"><p>Téléphone :</p><p><?php echo (empty($account->phone) ? "non renseigné" : $account->phone) ?></p></div>
                
                <?php if($account_type == "member") { ?>
                <?php if(isset($account->birth_date) && !empty($account->birth_date)) { ?>
                    <div class="profile_elmt"><p>Date de naissance :</p><p><?= $account->birth_date; ?></p></div>
                <?php } ?>
                <?php if(isset($account->degrees) && !empty($account->degrees)) { ?>
                    <div class="profile_elmt profile_elmt_text">
                        <p>Diplômes :</p>
                        <p><?= nl2br($account->degrees) ?></p>
                    </div>
                <?php } ?>
                <?php } ?>

                <?php if($status == "admin" && $account_type == "company") { if($account->active) { ?>
                	<p>Compte validé</p>
                <?php } else { ?>
                	<p>Compte non validé</p>
                <?php }} ?>

                <?php if($id_user == $id_account) { ?>
                <form action="" method="POST">
                    <button type="submit" id="edit_profile" name="action" value="edit_profile">Editer</button>
                    <button type="button" class="open_modal" onClick="openModal('form_modal')" >Modifier le mot de passe</button>
                </form>
                <?php } ?>
			</div>
            <?php } else { ?>
                <p>Utilisateur introuvable !</p>
            <?php } ?>
		</main>

        <?php require("v-footer.inc.php"); ?>
    </body>
</html>
