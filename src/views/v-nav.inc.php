<nav>	
	<form action="" method="POST">
		<button type="submit" name="membre_inscription">Inscription Membre</button>
		<button type="submit" name="entreprise_inscription">Inscription Entreprise</button>
		<button type="submit" name="connexion">Connexion</button>
	</form>
</nav>
<?php if(!isset($_SESSION['id_user']) && (isset($_POST['membre_inscription']) || isset($_POST['msup_submit']))) { ?>
	<div>
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
	</div>
<?php } 
	if(!isset($_SESSION['id_user']) && (isset($_POST['entreprise_inscription']) || isset($_POST['esup_submit']))) {
?>
	<div>
		<form action="" method="POST">
			*Nom de la societe : <input type="text" name="esup_social_reason" maxlength="40" value="<?php if(isset($_POST['esup_social_reason'])) { echo $_POST['esup_social_reason']; } ?>" required>
			<span><?php if(isset($errors['social_reason'])) { echo $errors['social_reason']; }?></span>
			<br/>

			*Prenom : <input type="text" name="esup_first_name" maxlength="15" value="<?php if(isset($_POST['esup_first_name'])) { echo $_POST['esup_first_name']; } ?>" required>
			<span><?php if(isset($errors['first_name'])) { echo $errors['first_name']; }?></span>
			<br/>

			*Nom : <input type="text" name="esup_last_name" maxlength="15" value="<?php if(isset($_POST['esup_last_name'])) { echo $_POST['esup_last_name']; } ?>" required>
			<span><?php if(isset($errors['last_name'])) { echo $errors['last_name']; }?></span>
			<br/>

			*Mail : <input type="email" name="esup_mail" maxlength="80" value="<?php if(isset($_POST['esup_mail'])) { echo $_POST['esup_mail']; } ?>" required>
			<span><?php if(isset($errors['mail'])) { echo $errors['mail']; }?></span>
			<br/>

			*Mot de passe : <input type="password" name="esup_password" maxlength="64" required>
			<span><?php if(isset($errors['password'])) { echo $errors['password']; }?></span>
			<br/>

			*Confirmation du mot de passe : <input type="password" maxlength="64" name="esup_valid_password" required>
			<br/>

			Telephone : <input type="telephone" name="esup_phone" value="<?php if(isset($_POST['esup_phone'])) { echo $_POST['esup_phone']; } ?>" maxlength="13">
			<span><?php if(isset($errors['phone'])) { echo $errors['phone']; }?></span>
			<br/>

			<button name="esup_submit">S'Inscrire</button>
		</form>
	</div>
<?php }
	if(!isset($_SESSION['id_user']) && (isset($_POST['connexion']) || isset($_POST['con_submit']))) {
?>
	<div>
		<form action="" method="POST">
			Mail : <input type="email" name="con_mail" maxlength="80" value="<?php if(isset($_POST['con_mail'])) { echo $_POST['con_mail']; } ?>" required>
			<span><?php if(isset($errors['mail'])) { echo $errors['mail']; } ?></span>
			<br/>

			Mot de passe : <input type="password" name="con_password" maxlength="64" required>
			<span><?php if(isset($errors['password'])) { echo $errors['password']; } ?></span>
			<br/>

			<button name="con_submit">Connexion</button>
		</form>
	</div>
<?php
 	}
?>