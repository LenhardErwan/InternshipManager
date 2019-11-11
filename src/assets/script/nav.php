<?php if(isset($error_msg) && !empty($error_msg)) { ?>
	<p><?=$error_msg?></p>
<?php } ?>

<?php if(!validSignin()) { ?>
	<div id="membre_popup" style="display: <?php if(isset($_POST['msup_submit'])) { echo "block"; } else { echo "none"; } ?>;">
		<form method="POST" action="index.php">
			<fieldset>
				<label>Prénom : </label>
				<input type="text" name="msup_firstname" value="<?php if(isset($_POST['msup_firstname']) && !empty($_POST['msup_firstname'])) { echo $_POST['msup_firstname']; } ?>" required>
				<br/>

				<label>Nom : </label>
				<input type="text" name="msup_lastname" value="<?php if(isset($_POST['msup_lastname']) && !empty($_POST['msup_lastname'])) { echo $_POST['msup_lastname']; } ?>" required>
				<br/>

				<label>Mail : </label>
				<input type="email" name="msup_mail" value="<?php if(isset($_POST['msup_mail']) && !empty($_POST['msup_mail'])) { echo $_POST['msup_mail']; } ?>" required>
				<br/>

				<label>Date de naissance : </label>
				<input type="date" name="msup_bornDate" value="<?php if(isset($_POST['msup_bornDate']) && !empty($_POST['msup_bornDate'])) { echo $_POST['msup_bornDate']; } ?>" required>
				<br/>

				<label>Mot de passe : </label>
				<input type="password" name="msup_password" required>
				<br/>

				<label>Confirmation du mot de passe : </label>
				<input type="password" name="msup_validPassword" required>
				<br/>

				<label>Téléphone : </label>
				<input type="tel" name="msup_phone" value="<?php if(isset($_POST['msup_phone']) && !empty($_POST['msup_phone'])) { echo $_POST['msup_phone']; } ?>" required>
				<br/>

				<label>Diplômes : </label>
				<textarea name="msup_diplomes" required><?php if(isset($_POST['msup_diplomes']) && !empty($_POST['msup_diplomes'])) { echo $_POST['msup_diplomes']; } ?></textarea>
				<br/>

				<input type="submit" name="msup_submit" value="S'inscrire Membre">
			</fieldset>
		</form>
	</div>
	<div id="entreprise_popup" style="display: <?php if(isset($_POST['esup_submit'])) { echo "block"; } else { echo "none"; } ?>;">
		<form method="POST" action="index.php">
			<fieldset>
				<label>Prénom : </label>
				<input type="text" name="esup_firstname" value="<?php if(isset($_POST['esup_firstname']) && !empty($_POST['esup_firstname'])) { echo $_POST['esup_firstname']; } ?>" required>
				<br/>
				
				<label>Nom : </label>
				<input type="text" name="esup_lastname" value="<?php if(isset($_POST['esup_lastname']) && !empty($_POST['esup_lastname'])) { echo $_POST['esup_lastname']; } ?>" required>
				<br/>
				
				<label>Mail : </label>
				<input type="email" name="esup_mail" value="<?php if(isset($_POST['esup_mail']) && !empty($_POST['esup_mail'])) { echo $_POST['esup_mail']; } ?>" required>
				<br/>
				
				<label>Mot de passe : </label>
				<input type="password" name="esup_password" required>
				<br/>
				
				<label>Confirmation du mot de passe : </label>
				<input type="password" name="esup_validPassword" required>
				<br/>

				<label>Téléphone : </label>
				<input type="tel" name="esup_phone" value="<?php if(isset($_POST['esup_phone']) && !empty($_POST['esup_phone'])) { echo $_POST['esup_phone']; } ?>" required>
				<br/>

				<label>Raison sociale : </label>
				<textarea name="esup_socialReason" required><?php if(isset($_POST['esup_socialReason']) && !empty($_POST['esup_socialReason'])) { echo $_POST['esup_socialReason']; } ?></textarea>
				<br/>


				<input type="submit" name="esup_submit" value="S'inscrire Entreprise">
			</fieldset>
		</form>
	</div>
	<div id="connexion_popup" style="display: <?php if(isset($_POST['signin_submit'])) { echo "block"; } else { echo "none"; } ?>;">
		<form method="POST" action="index.php">
			<fieldset>
				<label>Mail : </label>
				<input type="email" name="signin_mail" value="<?php if(isset($_POST['signin_mail']) && !empty($_POST['signin_mail'])) { echo $_POST['signin_mail']; } ?>" required>
				<br/>

				<label>Mot de passe : </label>
				<input type="password" name="signin_password" required>
				<br/>

				<input type="submit" name="signin_submit" value="Se connecter">
			</fieldset>
		</form>
	</div>
<?php } ?>

<nav>
	<a href="accueil"></a>
	<form method="POST" action="index.php">
		<input type="text" name="search_content">
		<button type="submit" name="search_submit">Rechercher</button>
		<ul>
			<?php if(validSignin()) { ?>
				<button type="submit" name="signout_submit">Deconnexion</button>
				<button type="submit">Paramètres</button>
			<?php } else { ?>
				<li onclick="show_form('membre_popup'); hide_form('entreprise_popup'); hide_form('connexion_popup');">Insription Membre</li>
				<li onclick="show_form('entreprise_popup'); hide_form('membre_popup'); hide_form('connexion_popup');">Inscription Entreprise</li>
				<li onclick="show_form('connexion_popup'); hide_form('membre_popup'); hide_form('entreprise_popup');">Connexion</li>
			<?php } ?>
		</ul>
	</form>
</nav>