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
						$error['mail'] = "Mail ou mot de passe inconnu";
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
				if(!preg_match("/[a-zA-Z0-9 !@#$%^&*]{8,64}$/", $password)) {
					$error['password'] = "Champ mot de passe invalide au moins 8 caracteres (a-zA-Z0-9 !@#$%^&*)";
				} else {
					if(isset($user) && (hash('sha256', $password) === $user->password)) {
						$data['valid'] = true;
					} else {
						$error['mail'] = "Mail ou mot de passe inconnu";
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
			if(User::isCompany($user->id_account)) {
				$user_c = User::getCompany($_POST['con_mail']);
				if($user_c->active) {
					$_SESSION['id_account'] = $user_c->id_account;
					$_SESSION['mail'] = $user_c->mail;
					$_SESSION['password'] = $user_c->password;
					$_SESSION['is_company'] = true;
				} else {
					$errors['active'] = "Votre compte n'a pas encore été validé. Vous recevrez un mail votre compte sera validé";
				}
			} else {
				$_SESSION['id_account'] = $user->id_account;
				$_SESSION['mail'] = $user->mail;
				$_SESSION['password'] = $user->password;

				if(User::isAdmin($user->id_account)) {
					$_SESSION['is_admin'] = true;
				}
			}
		} else {
			$errors = $result;
		}
	}
?>