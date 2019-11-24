<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Profil <?php if(isset($account) && $account) echo "- $account->social_reason" ?></title>
        <link rel="stylesheet" type="text/css" href="assets/style/reset.css">
        <link rel="stylesheet" type="text/css" href="assets/style/nav.css">
        <link rel="stylesheet" type="text/css" href="assets/style/index.css">
    </head>

    </ody>
    <?php require("v-nav.inc.php"); ?>
        <main>
			<div>
                <?php if(isset($account) && $account) { ?>

                <h2>Raison sociale : <?= $account->social_reason ?></h1>
                <h3>Nom dépositaire : <?= $account->last_name ?></h1>
                <h3>Prénom dépositaire : <?= $account->first_name ?></h1>
                <h3>E-Mail : <?= $account->mail ?></h2>
                <h3>Téléphone : <?php echo (empty($account->phone) ? "non renseigné" : $account->phone) ?></h2>
                <?php if($status == "admin") { if($account->active) { ?>
                <h4>Comtpe validé</h4>
                <?php } else { ?>
                <h4>Comtpe non validé</h4>
                <?php } } ?>

                <?php if($id_user == $id_account) { ?>
                <form action="" method="POST">
                    <button type="submit" id="edit_profile" name="action" value="edit_profile">Editer</button>
                    <button type="button" class="open_modal" onClick="openModal('change_password')" >Modifier le mot de passe</button>
                </form>
                <?php } ?>
                
                <?php } else { ?>

                <p>Entreprise introuvable !</p>
                
                <?php } ?>

			</div>
		</main>
        <?php require("v-footer.inc.php"); ?>
        <?php if($id_user == $id_account) require("v-profile_password.inc.php") ?>
    </body>
    <script src="assets/script/modal.js"></script>
</html>
