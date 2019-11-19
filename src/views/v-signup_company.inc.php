<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Inscriptions entreprise</title>
		<script type="text/javascript" src="assets/script/modal.js"></script>
	</head>
	<body>
		<?php require('v-nav.inc.php'); ?>
		
		<?php if(!$errors['valid']) { ?>
		<form action="" method="POST">
			*Nom de la societe : <input type="text" name="csup_social_reason" maxlength="40" value="<?php if(isset($_POST['csup_social_reason'])) { echo $_POST['csup_social_reason']; } ?>" required>
			<span><?php if(isset($errors['social_reason'])) { echo $errors['social_reason']; }?></span>
			<br/>

			*Prenom : <input type="text" name="csup_first_name" maxlength="15" value="<?php if(isset($_POST['csup_first_name'])) { echo $_POST['csup_first_name']; } ?>" required>
			<span><?php if(isset($errors['first_name'])) { echo $errors['first_name']; }?></span>
			<br/>

			*Nom : <input type="text" name="csup_last_name" maxlength="15" value="<?php if(isset($_POST['csup_last_name'])) { echo $_POST['csup_last_name']; } ?>" required>
			<span><?php if(isset($errors['last_name'])) { echo $errors['last_name']; }?></span>
			<br/>

			*Mail : <input type="email" name="csup_mail" maxlength="80" value="<?php if(isset($_POST['csup_mail'])) { echo $_POST['csup_mail']; } ?>" required>
			<span><?php if(isset($errors['mail'])) { echo $errors['mail']; }?></span>
			<br/>

			*Mot de passe : <input type="password" name="csup_password" maxlength="64" required>
			<span><?php if(isset($errors['password'])) { echo $errors['password']; }?></span>
			<br/>

			*Confirmation du mot de passe : <input type="password" maxlength="64" name="csup_valid_password" required>
			<br/>

			Telephone : <input type="telephone" name="csup_phone" value="<?php if(isset($_POST['csup_phone'])) { echo $_POST['csup_phone']; } ?>" maxlength="13">
			<span><?php if(isset($errors['phone'])) { echo $errors['phone']; }?></span>
			<br/>

			<button name="csup_submit">S'Inscrire</button>
		</form>
		<?php } else { ?>
			<div>
				Inscription reussi
				<h2>Vous n'avez plus qu'a vous connecter</h2>
				<a href="?page=index">Retour a la page d'accueil</a>
			</div>
		<?php } ?>

		<?php require('v-footer.inc.php'); ?>
	</body>
</html>