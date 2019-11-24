<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Profil <?php if(isset($account) && $account) echo "- $account->last_name" ?></title>
        <script src="assets/script/modal.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/style/reset.css">
        <link rel="stylesheet" type="text/css" href="assets/style/nav.css">
        <link rel="stylesheet" type="text/css" href="assets/style/profile.css">
        <link rel="stylesheet" type="text/css" href="assets/style/footer.css">
    </head>

    <body>
        <?php if($id_user == $id_account) require("v-profile_password.inc.php") ?>
        <?php require("v-nav.inc.php"); ?>
        
        <main id="profile_main">
            <?php if(isset($account) && $account) { ?>
            <h1 id="profile_title">Profile - <?= $account->last_name; ?></h1>
			<div id="profile_content">
                <p>Nom : <?= $account->last_name ?></p>
                <p>Prénom : <?= $account->first_name ?></p>
                <p>E-Mail : <?= $account->mail ?></p>
                <p>Téléphone : <?php echo (empty($account->phone) ? "non renseigné" : $account->phone) ?></p>
                <?php if(isset($account->birth_date) && !empty($account->birth_date)) { ?>
                    <p>Date de naissance : <?= $account->phone ?></p>
                <?php } ?>
                <?php if(isset($account->degrees) && !empty($account->degrees)) { ?>
                    <p>Diplômes : <?= $account->degrees ?></p>
                <?php } ?>

                <?php if($id_user == $id_account) { ?>
                <form action="" method="POST">
                    <button type="submit" id="edit_profile" name="action" value="edit_profile">Editer</button>
                    <button type="button" class="open_modal" onClick="openModal('profile_change_password')" >Modifier le mot de passe</button>
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
