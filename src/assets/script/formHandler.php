<?php
	/*
	 * $bornDate only on 'membre' signup
	 * $socialReason only on 'entreprise' signup
	 */
	function insert($firstName, $lastName, $mail, $bornDate, $password, $validPassword, $phone, $diplomes, $socialReason) {
		
		/*
		 * The first conditional statement are shared element between 'membre' and 'entreprise'
		 * We can't trust the user. We need to make a serie of multiple test
		 */
		if(preg_match('%@.*.\.%', $mail) === 1) {
			
			global $DB;
			$query = $DB->prepare("SELECT mail FROM account WHERE mail = ?");
			$query->execute(array($mail));
			$result = $query->fetch();

			if(!$result) {
				if($password === $validPassword) {
					if(true) { // Check for the phone number regular expression

						/*
						 * A 'membre' is creating an account
						 */
						if(isset($bornDate) && !empty($bornDate) && isset($diplomes) && !empty($diplomes)) {
							if(true) { // Check if the user is older than 18 years old
								return "membre : $firstName.$lastName.$mail.$bornDate.$password.$phone.$diplomes";
							}
						}

						/* 
						 * An 'entreprise' is creating an account
						 */
						else if(isset($socialReason) && !empty($socialReason)) {
							return "entreprise : $firstName.$lastName.$mail.$password.$phone.$socialReason";
						}

						/*
						 * Houston we have a problem
						 */
						else {
							return "Arguments error THIS SHOULD NOT HAPPEN";
						}
					} else {
						return "Telephone invalide";
					}
				} else {
					return "Les mot des passes ne correspondent pas";
				}
			} else {
				return "Adresse mail utilise";
			}
		} else {
			return "Adresse mail invalide";
		}
	}

	/*
	 * msup_ stands for membre_signup
	 * Triggered when trying to create a new 'membre' account
	 */
	if(isset($_POST['msup_submit'])) {
		if(isset($_POST['msup_firstname']) && !empty($_POST['msup_firstname']) && isset($_POST['msup_lastname']) && !empty($_POST['msup_lastname']) && isset($_POST['msup_mail']) && !empty($_POST['msup_mail']) && isset($_POST['msup_bornDate']) && !empty($_POST['msup_bornDate']) && isset($_POST['msup_password']) && !empty($_POST['msup_password']) && isset($_POST['msup_validPassword']) && !empty($_POST['msup_validPassword']) && isset($_POST['msup_phone']) && !empty($_POST['msup_phone']) && isset($_POST['msup_diplomes']) && !empty($_POST['msup_diplomes'])) {
			$error_msg = insert($_POST['msup_firstname'], $_POST['msup_lastname'], $_POST['msup_mail'], $_POST['msup_bornDate'], $_POST['msup_password'], $_POST['msup_validPassword'], $_POST['msup_phone'], $_POST['msup_diplomes'], NULL);
		} else {
			$error_msg = "Des champs de saisies sont vides";
		}
	}

	/*
	 * esup_ stands for entreprise_signup
	 * Triggered when trying to create a new 'entreprise' account
	 */
	if(isset($_POST['esup_submit'])) {
		if(isset($_POST['esup_firstname']) && !empty($_POST['esup_firstname']) && isset($_POST['esup_lastname']) && !empty($_POST['esup_lastname']) && isset($_POST['esup_mail']) && !empty($_POST['esup_mail']) && isset($_POST['esup_password']) && !empty($_POST['esup_password']) && isset($_POST['esup_validPassword']) && !empty($_POST['esup_validPassword']) && isset($_POST['esup_phone']) && !empty($_POST['esup_phone']) && isset($_POST['esup_socialReason']) && !empty($_POST['esup_socialReason'])) {
			$error_msg = insert($_POST['esup_firstname'], $_POST['esup_lastname'], $_POST['esup_mail'], NULL, $_POST['esup_password'], $_POST['esup_validPassword'], $_POST['esup_phone'], NULL, $_POST['esup_socialReason']);
		} else {
			$error_msg = "Des champs de saisies sont vides";
		}
	}

	if(isset($_POST['signin_form_submit'])) {
		if(isset($_POST['signin_form_mail']) && !empty($_POST['signin_form_mail']) && isset($_POST['signin_form_password']) && !empty($_POST['signin_form_password']) ) {
			$result = pg_prepare($db, 'list_membre', "SELECT id, password FROM ".DB_SCHEMA.".user WHERE name=$1");
			$result = pg_execute($db, 'list_membre', array($_POST['signin_form_mail']));
			$result = pg_fetch_row($result);

			if(!$result) {
				$error_msg = "Login ou mot de passe incorrecte";
			} else {
				if($result[1] == hash('sha256', $_POST['signin_form_password'])) {
					$_SESSION['id'] = $result[0];
				} else {
					$error_msg = "Login ou mot de passe incorrecte";
				}
			}
		} else {
			$error_msg = "Des champs de saisies sont vides";
		}
	}

	if(isset($_POST['signout_form_submit'])) {
		session_unset();
		session_destroy();
	}
?>
