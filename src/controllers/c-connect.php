<?php
	function valid_connect_infos($mail, $password) {
		if(empty($mail)) {
			$error['mail'] = "Champ mail vide";
		} else {
			if(strlen($mail) > 80) {
				$error['mail'] = "Champ mail trop grand 80 caracteres";
			} else {
				if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
					$error['mail'] = "Champ mail invalide";
				} else {
					if(empty(User::getAccount($mail))) {
						$error['mail'] = "Mail ou mot de passe inconnue";
					} else {
						$user = User::getAccount($mail);
					}
				}
			}
		}

		if(empty($password)) {
			$error['password'] = "Champ mot de passe vide";
		} else {
			if(strlen($password) > 64) {
				$error['password'] = "Champ mot de passe trop grand 64 caracteres";
			} else {
				if(!preg_match("/^[a-zA-Z !@#$%^&*]{8,64}$/", $password)) {
					$error['password'] = "Champ mot de passe invalide au moins 8 caracteres (a-zA-Z0-9 !@#$%^&*)";
				} else {
					if(isset($user) && (hash('sha256', $password) === $user->password)) {
						$data['valid'] = true;
					} else {
						$error['mail'] = "Mail ou mot de passe inconnue";
					}
				}
			}
		}

		if(empty($error)) {
			$data['valid'] = true;
			return $data;
		} else {
			$error['valid'] = false;
			return $error;
		}
	}

	
	if(isset($_POST['con_submit'])) {
		$result = valid_connect_infos($_POST['con_mail'], $_POST['con_password']);

		if($result['valid']) {
			$user = User::getAccount($_POST['con_mail']);
			$_SESSION['id_user'] = $user->id_user;
			$_SESSION['mail'] = $user->mail;
			$_SESSION['password'] = $user->password;
		} else {
			$errors = $result;
		}
	}
?>