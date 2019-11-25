<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Profile <?php if(isset($account) && $account) echo "- $account->social_reason" ?></title>
        <script src="assets/script/modal.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/style/reset.css">
        <link rel="stylesheet" type="text/css" href="assets/style/nav.css">
        <link rel="stylesheet" type="text/css" href="assets/style/profile.css">
        <link rel="stylesheet" type="text/css" href="assets/style/footer.css">
    </head>

    <body>    <body>
        <?php if($id_user == $id_account) require("v-profile_password.inc.php") ?>
        <?php require("v-nav.inc.php"); ?>
        
        <main id="profile_main">
            <?php if(isset($account) && $account) { ?>
            <h1 id="profile_title">Profile - <?= $account->social_reason; ?></h1>
			<div id="profile_content">
                <p>Raison sociale : <?= $account->social_reason ?></p>
                <p>Nom dépositaire : <?= $account->last_name ?></p>
                <p>Prénom dépositaire : <?= $account->first_name ?></p>
                <p>E-Mail : <?= $account->mail ?></p>
                <p>Téléphone : <?php echo (empty($account->phone) ? "non renseigné" : $account->phone) ?></p>
                <?php if($status == "admin") { if($account->active) { ?>
                    <p>Comtpe validé</p>
                <?php } else { ?>
                    <p>Comtpe non validé</p>
                <?php } } ?>

                <?php if($id_user == $id_account) { ?>
                <form action="" method="POST">
                    <button type="submit" id="edit_profile" name="action" value="edit_profile">Editer</button>
                    <button type="button" class="open_modal" onClick="openModal('profile_change_password')" >Modifier le mot de passe</button>
                </form>
                <?php } ?>
			</div>
            <?php } else { ?>
                <p>Entreprise introuvable !</p>
            <?php } ?>
		</main>

        <?php require("v-footer.inc.php"); ?>
    </body>
</html>
