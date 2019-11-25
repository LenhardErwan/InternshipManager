<nav id="nav">
	<a href="?page=index" class="nav_button">Accueil</a>
  	<?php if(isset($_SESSION['is_company']) && $_SESSION['is_company']) { ?>
		<a href="?page=article&action=edit_article" class="nav_button">Créer une offre</a>
  	<?php } ?>
	<?php if(!isset($_SESSION['id_account'])) { ?>
		<a href="#" onclick="openModal('connect_form')" class="nav_button">Connexion</button>
		<a href="?page=profile&action=create_member" class="nav_button">Inscription Membre</a>
		<a href="?page=profile&action=create_company" class="nav_button">Inscription Entreprise</a>
	<?php } else { ?>
		<?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']) { ?>
			<a href="?page=admin" class="nav_button">Administration</a>
		<?php } ?>
		<a href="?page=profile&id=<?= $_SESSION['id_account']; ?>" class="nav_button">Mon profil</a>
		<a href="?page=profile&action=edit_profile&id=<?= $_SESSION['id_account']; ?>" class="nav_button">Parametres</a>
		<a href="?page=disconnect" class="nav_button">Deconnexion</a>
	<?php } ?>
</nav>
<?php
	if(!isset($_SESSION['id_account'])) {
?>
	<div class="modal" id="connect_form" style="display: <?php echo(isset($_POST['con_submit']) ? 'flex' : 'none')?>;">
		<form id="connect_container" action="" method="POST">
			<div class="connect_elmt">
				<label>Mail : </label>
				<input type="email" name="con_mail" maxlength="80" value="<?php if(isset($_POST['con_mail'])) { echo $_POST['con_mail']; } ?>" required>
			</div>
			<div class="connect_errors"><?php if(isset($errors['mail'])) { echo $errors['mail']; } ?></div>

			<div class="connect_elmt">
				<label>Mot de passe : </label>
				<input type="password" name="con_password" maxlength="64" required>
			</div>
			<div class="connect_errors"><?php if(isset($errors['password'])) { echo $errors['password']; } ?></div>

			<div class="connect_errors"><?php if(isset($errors['active'])) { echo $errors['active']; } ?></div>
			<div id="connect_submit">
				<button name="con_submit">Connexion</button>
    			<button class="close_modal">Annuler</button>
    		</div>
		</form>
	</div>
<?php
 	}
?>