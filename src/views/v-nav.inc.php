<?php
	if(!isset($_SESSION['id_user'])) {
?>
	<div class="modal" id="connect_form" style="display: <?php echo(isset($_POST['con_submit']) ? 'block' : 'none')?>;">
		<form action="" method="POST">
			Mail : <input type="email" name="con_mail" maxlength="80" value="<?php if(isset($_POST['con_mail'])) { echo $_POST['con_mail']; } ?>" required>
			<span><?php if(isset($errors['mail'])) { echo $errors['mail']; } ?></span>
			<br/>

			Mot de passe : <input type="password" name="con_password" maxlength="64" required>
			<span><?php if(isset($errors['password'])) { echo $errors['password']; } ?></span>
			<br/>

			<button name="con_submit">Connexion</button>
		</form>
    	<button class="close_modal">Annuler</button>
	</div>
<?php
 	}
?>
<nav>
	<a href="index.php/?page=index">Accueil</a>
	<form action="" method="POST">
		<input type="text" name="search_content">
		<button name="search_submit">Rechercher</button>		
	</form>
	<button onclick="openModal('connect_form')">Connexion</button>
</nav>