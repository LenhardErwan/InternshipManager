<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Profil <?php if(isset($account) && $account) echo "- $account->last_name, $account->first_name" ?></title>
    </head>

    </body>
    <?php require("v-nav.inc.php"); ?>
        <main>
			<div>
                <?php if(isset($account) && $account) { ?>

                <h2>Nom : <?= $account->last_name ?></h1>
                <h2>Prénom : <?= $account->first_name ?></h1>
                <h3>E-Mail : <?= $account->mail ?></h2>
                <h3>Téléphone : <?php echo (empty($account->phone) ? "non renseigné" : $account->phone) ?></h2>
                <?php if(isset($account->birth_date) && !empty($account->birth_date)) { ?>
                <h4>Date de naissance : <?= $account->phone ?></h4>
                <?php } ?>
                <?php if(isset($account->degrees) && !empty($account->degrees)) { ?>
                <h4>Diplômes : <?= $account->degrees ?></h4>
                <?php } ?>
                
                <?php } else { ?>

                <p>Utilisateur introuvable !</p>
                
                <?php } ?>

			</div>
		</main>
        <?php require("v-footer.inc.php"); ?>
    </body>
    <script src="assets/script/modal.js"></script>
</html>
