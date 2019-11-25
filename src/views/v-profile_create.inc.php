<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Inscription entreprise</title>
		<script type="text/javascript" src="assets/script/modal.js"></script>
		<link rel="stylesheet" type="text/css" href="assets/style/reset.css">
		<link rel="stylesheet" type="text/css" href="assets/style/nav.css">
		<link rel="stylesheet" type="text/css" href="assets/style/signup.css">
		<link rel="stylesheet" type="text/css" href="assets/style/footer.css">
	</head>
	<body>
		<?php require('v-nav.inc.php'); ?>
		
		<main id="signup_main">
			<h1 id="signup_title">Inscription Entreprise</h1>
			<?php if(!isset($errors) || (isset($errors['valid']) && !$errors['valid'])) { ?>
			<form id="signup_form" action="" method="POST">
				<div class="signup_elmt">
					<label>*Nom de la societe :</label>
					<input type="text" name="social_reason" maxlength="40" value="<?php if(isset($_POST['social_reason'])) { echo $_POST['social_reason']; } ?>" required>
				</div>
				<div class="signup_errors"><?php if(isset($errors['social_reason'])) { echo $errors['social_reason']; }?></div>

				<div class="signup_elmt">
					<label>*Prenom :</label>
					<input type="text" name="first_name" maxlength="15" value="<?php if(isset($_POST['first_name'])) { echo $_POST['first_name']; } ?>" required>
				</div>
				<div class="signup_errors"><?php if(isset($errors['first_name'])) { echo $errors['first_name']; }?></div>

				<div class="signup_elmt">
					<label>*Nom :</label>
					<input type="text" name="last_name" maxlength="15" value="<?php if(isset($_POST['last_name'])) { echo $_POST['last_name']; } ?>" required>
				</div>
				<div class="signup_errors"><?php if(isset($errors['last_name'])) { echo $errors['last_name']; }?></div>

				<div class="signup_elmt">
					<label>*Mail :</label>
					<input type="email" name="mail" maxlength="80" value="<?php if(isset($_POST['mail'])) { echo $_POST['mail']; } ?>" required>
				</div>
				<div class="signup_errors"><?php if(isset($errors['mail'])) { echo $errors['mail']; }?></div>

				<div class="signup_elmt">
					<label>*Mot de passe :</label>
					<input type="password" name="password" maxlength="64" required>
				</div>
				<div class="signup_errors"><?php if(isset($errors['password'])) { echo $errors['password']; }?></div>

				<div class="signup_elmt signup_valid_password">
					<label>*Confirmation du mot de passe :</label>
					<input type="password" maxlength="64" name="valid_password" required>
				</div>

				<div class="signup_elmt">
					<label>Telephone :</label>
					<input type="telephone" name="phone" value="<?php if(isset($_POST['phone'])) { echo $_POST['phone']; } ?>" maxlength="13">
				</div>
				<div class="signup_errors"><?php if(isset($errors['phone'])) { echo $errors['phone']; }?></div>

				<button id="signup_submit" type="submit" name="submit">S'Inscrire</button>
			</form>
			<?php } else if(isset($errors['valid']) && $errors['valid']) { ?>
				<div>
					Inscription reussi
					<h2>Vous n'avez plus qu'a attendre que votre compte soit valider par notre administrateur pour vous connecter!!</h2>
					<a href="?page=index">Retour a la page d'accueil</a>
				</div>
			<?php } ?>
		</main>

		<?php require('v-footer.inc.php'); ?>
	</body>
</html>