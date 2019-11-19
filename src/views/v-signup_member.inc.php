<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Inscriptions membre</title>
		<script type="text/javascript" src="assets/script/modal.js"></script>
	</head>
	<body>
		<?php require('v-nav.inc.php'); ?>

		<?php if(!$errors['valid']) { ?>
		<form action="" method="POST">
			*Prenom : <input type="text" name="msup_first_name" value="<?php if(isset($_POST['msup_first_name']) && !isset($errors['first_name'])) { echo $_POST['msup_first_name']; } ?>" maxlength="15" required>
			<span><?php if(isset($errors['first_name'])) { echo $errors['first_name']; } ?></span>
			<br/>

			*Nom : <input type="text" name="msup_last_name" value="<?php if(isset($_POST['msup_last_name']) && !isset($errors['last_name'])) { echo $_POST['msup_last_name']; } ?>" maxlength="15" required>
			<span><?php if(isset($errors['last_name'])) { echo $errors['last_name']; } ?></span>
			<br/>

			*Mail : <input type="email" name="msup_mail" value="<?php if(isset($_POST['msup_mail']) && !isset($errors['mail'])) { echo $_POST['msup_mail']; } ?>" maxlength="80" required>
			<span><?php if(isset($errors['mail'])) { echo $errors['mail']; } ?></span>
			<br/>

			*Mot de passe : <input type="password" name="msup_password" value="" maxlength="64" required>
			<span><?php if(isset($errors['password'])) { echo $errors['password']; } ?></span>
			<br/>

			*Confirmation du mot de passe : <input type="password" name="msup_valid_password" value="" maxlength="64" required>
			<br/>

			Telephone : <input type="telephone" name="msup_phone" value="<?php if(isset($_POST['msup_phone']) && !isset($errors['phone'])) { echo $_POST['msup_phone']; } ?>" maxlength="13">
			<span><?php if(isset($errors['phone'])) { echo $errors['phone']; } ?></span>
			<br/>

			Date de naissance : <input type="date" name="msup_birth_date" value="<?php if(isset($_POST['msup_birth_date']) && !isset($errors['birth_date'])) { echo $_POST['msup_birth_date']; } ?>">
			<span><?php if(isset($errors['birth_date'])) { echo $errors['birth_date']; } ?></span>
			<br/>

			Diplomes : <textarea name="msup_degrees" maxlength="500"><?php if(isset($_POST['msup_degrees']) && !isset($errors['degrees'])) { echo $_POST['msup_degrees']; } ?></textarea>
			<span><?php if(isset($errors['degrees'])) { echo $errors['degrees']; } ?></span>
			<br/>

			<button type="submit" name="msup_submit">S'Inscrire</button>
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