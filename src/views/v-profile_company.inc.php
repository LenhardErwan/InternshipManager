<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Profil <?php if(isset($account) && $account) echo "- $account->social_reason" ?></title>
    </head>

    </body>
    <?php require("v-nav.inc.php"); ?>
        <main>
			<div>
                <?php if(isset($account) && $account) { ?>

                <h2>Raison sociale : <?= $account->social_reason ?></h1>
                <h3>Nom dépositaire : <?= $account->last_name ?></h1>
                <h3>Prénom dépositaire : <?= $account->first_name ?></h1>
                <h3>E-Mail : <?= $account->mail ?></h2>
                <h3>Téléphone : <?= $account->phone ?></h2>
                <?php if($status == "admin") { if($account->active) { ?>
                <h4>Comtpe validé</h4>
                <?php } else { ?>
                <h4>Comtpe non validé</h4>
                <?php } } ?>
                
                <?php } else { ?>

                <p>Entreprise introuvable !</p>
                
                <?php } ?>

			</div>
		</main>
        <?php require("v-footer.inc.php"); ?>
    </body>
    <script src="assets/script/modal.js"></script>
</html>