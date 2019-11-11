<?php
	/*
	 * $bornDate only on 'membre' signup
	 * $socialReason only on 'entreprise' signup
	 */
	function insert($firstName, $lastName, $mail, $bornDate, $password, $validPassword, $phone, $diplomes, $socialReason) {
		
		/*
		 * The first conditional statement are shared element between 'membre' and 'entreprise'
		 * We can't trust the user. We need to make a serie of multiple test
		 * Mail format :
		 *  - Starts with 1 number or letter followed by 0 or more numbers / letters / hyphens / point followed by 1 number or letter followed by a '@' followed by 1 numbers or letter followed by 0 or more numbers / letters / hyphens / point followed by '.' followed by a letter or number followed by 0 or more characters ending with 1 letter or number
		 */
		if(preg_match('%^[0-9a-zA-Z][0-9a-zA-Z\-\.]*[0-9a-zA-Z]@[0-9a-zA-Z][0-9a-zA-Z\-\.]*\.[0-9a-zA-Z][0-9a-zA-Z\-]*[0-9a-zA-Z]$%', $mail) === 1) {
			
			global $DB;
			$query = $DB->prepare("SELECT mail FROM account WHERE mail = ?");
			$query->execute(array($mail));
			$result = $query->fetch();

			if(!$result) {
				if($password === $validPassword) {
					/*
					 * Accepted phone format :
					 *  - Starts with a '+' followed by 8 to 13 numbers
					 *  - 8 to 13 numbers
					 */
					if((preg_match('%^\+[0-9]{8,13}%', $phone) === 1) || (preg_match('%[0-9]{8,13}%', $phone) === 1)) {

						/*
						 * A 'membre' is creating an account
						 */
						if(isset($bornDate) && !empty($bornDate) && isset($diplomes) && !empty($diplomes)) {
							if(true) { // Check if the user is older than 18 years old
								// Testing purpose // return "membre : $firstName.$lastName.$mail.$bornDate.$password.$phone.$diplomes";
								$_POST = array();
							}
						}

						/* 
						 * An 'entreprise' is creating an account
						 */
						else if(isset($socialReason) && !empty($socialReason)) {
							// Testing purpose // return "entreprise : $firstName.$lastName.$mail.$password.$phone.$socialReason";
							try {
								
							} catch(PDOException $e) {
								return "Erreur : ".$e;
							}
							$_POST = array();
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

	/*
	 * 
	 */
	if(isset($_POST['signin_submit'])) {
		if(isset($_POST['signin_mail']) && !empty($_POST['signin_mail']) && isset($_POST['signin_password']) && !empty($_POST['signin_password']) ) {
			$query = $DB->prepare("SELECT id_user, mail, password FROM account WHERE mail = ?");
			$query->execute(array($_POST['signin_mail']));
			$result = $query->fetch();

			if(!$result) {
				$error_msg = "Login ou mot de passe incorrecte";
			} else {
				if (hash('sha256', $_POST['signin_password']) == $result['password']) {
					$_SESSION['id_user'] = $result['id_user'];
					$_SESSION['mail'] = $_POST['signin_mail'];
					$_SESSION['password'] = hash('sha256', $_POST['signin_password']);
					$_POST = array();
				} else {
					$error_msg = "Login ou mot de passse incorrecte";
				}
			}
		} else {
			$error_msg = "Des champs de saisies sont vides";
		}
	}

	if(isset($_POST['signout_submit'])) {
		session_unset();
		session_destroy();
	}
?>
