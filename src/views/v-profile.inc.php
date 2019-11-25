<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Profil <?php if(isset($account) && $account) echo "- $account->last_name, $account->first_name" ?></title>
        <link rel="stylesheet" type="text/css" href="assets/style/reset.css">
        <link rel="stylesheet" type="text/css" href="assets/style/nav.css">
        <link rel="stylesheet" type="text/css" href="assets/style/index.css">
    </head>

    <body>
    <?php require("v-nav.inc.php"); ?>
        <main>
			<div>
                <?php if(isset($account) && $account) { ?>

                <?php if($account_type == "company") { ?>
                <h2>Raison sociale : <?= $account->social_reason ?></h1>
                <?php } ?>

                <h2>Nom : <?= $account->last_name ?></h1>
                <h2>Prénom : <?= $account->first_name ?></h1>
                <h3>E-Mail : <?= $account->mail ?></h2>
                <h3>Téléphone : <?php echo (empty($account->phone) ? "non renseigné" : $account->phone) ?></h2>
                <?php if($account_type == "member") { ?>
                <?php if(isset($account->birth_date) && !empty($account->birth_date)) { ?>
                <h4>Date de naissance : <?= $account->phone ?></h4>
                <?php } ?>
                <?php if(isset($account->degrees) && !empty($account->degrees)) { ?>
                <h4>Diplômes : <?= $account->degrees ?></h4>
                <?php } }?>
                <?php if($status == "admin") { if($account->active) { ?>
                <h4>Comtpe validé</h4>
                <?php } else { ?>
                <h4>Compte non validé</h4>
                <?php } } ?>

                <?php if($id_user == $id_account) { ?>
                <form action="" method="POST">
                    <button type="submit" id="edit_profile" name="action" value="edit_profile">Editer</button>
                    <button type="button" class="open_modal" onClick="openModal('change_password')" >Modifier le mot de passe</button>
                </form>
                <?php } ?>
                
                <?php } else { ?>
                
                <p>Compte introuvable !</p>
                
                <?php } ?>

			</div>
		</main>
        <?php require("v-footer.inc.php"); ?>
        <?php if($id_user == $id_account) require("v-profile_password.inc.php") ?>
    </body>
    <script src="assets/script/modal.js"></script>
</html>
