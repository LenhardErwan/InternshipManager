<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Inscription <?php if($account_type == "company") { echo "entreprise"; } else if($account_type == "member") { echo "membre"; } ?></title>
		<script type="text/javascript" src="src/assets/script/modal.js"></script>
		<link rel="stylesheet" type="text/css" href="src/assets/style/reset.css">
		<link rel="stylesheet" type="text/css" href="src/assets/style/nav.css">
		<link rel="stylesheet" type="text/css" href="src/assets/style/form.css">
		<link rel="stylesheet" type="text/css" href="src/assets/style/footer.css">
	</head>
	<body>
		<?php require('v-nav.inc.php'); ?>
		
		<main id="form_main">
			<h1 id="form_title">Inscription <?php if($account_type == "company") { echo "Entreprise";} else if($account_type == "member") { echo "Membre";} ?></h1>
			<?php if(!isset($errors) || (isset($errors['valid']) && !$errors['valid'])) { ?>
			<form id="form_container" action="" method="POST">
				<?php if($account_type == "company") { ?>
				<div class="form_elmt">
					<label>*Nom de la societe :</label>
					<input type="text" name="social_reason" maxlength="40" value="<?= (isset($_POST['social_reason']) ? $_POST['social_reason'] : ''); ?>" required>
				</div>
				<div class="form_errors"><?= (isset($errors['social_reason']) ? $errors['social_reason'] : ''); ?></div>
			<?php } ?>

				<div class="form_elmt">
					<label>*Prenom :</label>
					<input type="text" name="first_name" maxlength="15" value="<?= (isset($_POST['first_name']) ? $_POST['first_name'] : ''); ?>" required>
				</div>
				<div class="form_errors"><?= (isset($errors['first_name']) ? $errors['first_name'] : ''); ?></div>

				<div class="form_elmt">
					<label>*Nom :</label>
					<input type="text" name="last_name" maxlength="15" value="<?= (isset($_POST['last_name']) ? $_POST['last_name'] : ''); ?>" required>
				</div>
				<div class="form_errors"><?= (isset($errors['last_name']) ? $errors['last_name'] : ''); ?></div>

				<div class="form_elmt">
					<label>*Mail :</label>
					<input type="email" name="mail" maxlength="80" value="<?= (isset($_POST['mail']) ? $_POST['mail'] : ''); ?>" required>
				</div>
				<div class="form_errors"><?= (isset($errors['mail']) ? $errors['mail'] : ''); ?></div>

				<div class="form_elmt">
					<label>*Mot de passe :</label>
					<input type="password" name="password" maxlength="64" required>
				</div>
				<div class="form_errors"><?= (isset($errors['password']) ? $errors['password'] : ''); ?></div>

				<div class="form_elmt form_elmt_noerror">
					<label>*Confirmation du mot de passe :</label>
					<input type="password" maxlength="64" name="valid_password" required>
				</div>

				<div class="form_elmt">
					<label>Telephone :</label>
					<input type="telephone" name="phone" value="<?= (isset($_POST['phone']) ? $_POST['phone'] : ''); ?>" maxlength="13">
				</div>
				<div class="form_errors"><?= (isset($errors['phone']) ? $errors['phone'] : '');?></div>

				<?php if($account_type == "member") { ?>
					<div class="form_elmt">
						<label>Date de naissance :</label>
						<input type="date" name="birth_date" value="<?= (isset($_POST['birth_date']) ? $_POST['birth_date'] : ''); ?>">
					</div>
					<div class="form_errors"><?= (isset($errors['birth_date']) ? $errors['birth_date'] : ''); ?></div>

					<div class="form_elmt_text">
						<label>Diplomes :</label>
						<textarea name="degrees" maxlength="500"><?= (isset($_POST['degrees']) ? $_POST['degrees'] : ''); ?></textarea>
					</div>
					<div class="form_errors"><?= (isset($errors['degrees']) ? $errors['degrees'] : ''); ?></div>
				<?php } ?>

				<button class="form_submit" type="submit" name="submit">S'Inscrire</button>
			</form>
			<?php } else if(isset($errors['valid']) && $errors['valid']) { ?>
				<?php if($account_type == "company") { ?>
					<p><strong>Vous n'avez plus qu'a attendre que votre compte soit validé par notre administrateur pour vous connecter !</strong></p>
				<?php } else if($account_type == "member") { ?>
					<p><strong>Vous pouvez maintenant vous connecter !</strong></p>
				<?php } ?>
				<a href="?page=index">Retour a la page d'accueil</a>
			<?php } ?>
		</main>

		<?php require('v-footer.inc.php'); ?>
	</body>
</html>