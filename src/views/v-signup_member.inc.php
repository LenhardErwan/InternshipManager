<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Inscription membre</title>
		<script type="text/javascript" src="assets/script/modal.js"></script>
		<link rel="stylesheet" type="text/css" href="assets/style/reset.css">
		<link rel="stylesheet" type="text/css" href="assets/style/nav.css">
		<link rel="stylesheet" type="text/css" href="assets/style/signup.css">
		<link rel="stylesheet" type="text/css" href="assets/style/footer.css">
	</head>
	<body>
		<?php require('v-nav.inc.php'); ?>

		<main id="signup_main">
			<h1 id="signup_title">Inscription Membre</h1>
			<?php if(!isset($errors) || (isset($errors['valid']) && !$errors['valid'])) { ?>
			<form id="signup_form" action="" method="POST">
				<div class="signup_elmt">
					<label>*Prenom :</label>
					<input type="text" name="msup_first_name" value="<?php if(isset($_POST['msup_first_name']) && !isset($errors['first_name'])) { echo $_POST['msup_first_name']; } ?>" maxlength="15" required>
				</div>
				<div class="signup_errors"><?php if(isset($errors['first_name'])) { echo $errors['first_name']; } ?></div>

				<div class="signup_elmt">
					<label>*Nom :</label>
					<input type="text" name="msup_last_name" value="<?php if(isset($_POST['msup_last_name']) && !isset($errors['last_name'])) { echo $_POST['msup_last_name']; } ?>" maxlength="15" required>
				</div>
				<div class="signup_errors"><?php if(isset($errors['last_name'])) { echo $errors['last_name']; } ?></div>

				<div class="signup_elmt">
					<label>*Mail :</label>
					<input type="email" name="msup_mail" value="<?php if(isset($_POST['msup_mail']) && !isset($errors['mail'])) { echo $_POST['msup_mail']; } ?>" maxlength="80" required>
				</div>
				<div class="signup_errors"><?php if(isset($errors['mail'])) { echo $errors['mail']; } ?></div>

				<div class="signup_elmt">
					<label>*Mot de passe :</label>
					<input type="password" name="msup_password" value="" maxlength="64" required>
				</div>
				<div class="signup_errors"><?php if(isset($errors['password'])) { echo $errors['password']; } ?></div>

				<div class="signup_elmt signup_valid_password">
					<label>*Confirmation du mot de passe :</label>
					<input type="password" name="msup_valid_password" value="" maxlength="64" required>
				</div>

				<div class="signup_elmt">
					<label>Telephone :</label>
					<input type="telephone" name="msup_phone" value="<?php if(isset($_POST['msup_phone']) && !isset($errors['phone'])) { echo $_POST['msup_phone']; } ?>" maxlength="13">
				</div>
				<div class="signup_errors"><?php if(isset($errors['phone'])) { echo $errors['phone']; } ?></div>

				<div class="signup_elmt">
					<label>Date de naissance :</label>
					<input type="date" name="msup_birth_date" value="<?php if(isset($_POST['msup_birth_date']) && !isset($errors['birth_date'])) { echo $_POST['msup_birth_date']; } ?>">
				</div>
				<div class="signup_errors"><?php if(isset($errors['birth_date'])) { echo $errors['birth_date']; } ?></div>

				<div class="signup_degrees">
					<label>Diplomes :</label>
					<textarea name="msup_degrees" maxlength="500"><?php if(isset($_POST['msup_degrees']) && !isset($errors['degrees'])) { echo $_POST['msup_degrees']; } ?></textarea>
				</div>
				<div class="signup_errors"><?php if(isset($errors['degrees'])) { echo $errors['degrees']; } ?></div>

				<button id="signup_submit" type="submit" name="msup_submit">S'Inscrire</button>
			</form>
			<?php } else { ?>
				<div>
					Inscription reussi
					<h2>Vous n'avez plus qu'a vous connecter</h2>
					<a href="?page=index">Retour a la page d'accueil</a>
				</div>
			<?php } ?>
		</main>

		<?php require('v-footer.inc.php'); ?>
	</body>
</html>