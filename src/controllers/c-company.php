<?php
	function valid_company_infos($first_name, $last_name, $mail, $password, $valid_password, $phone, $social_reason) {
		if(empty($first_name)) {
			$error['first_name'] = "Champ prenom vide";
		} else {
			if(strlen($first_name) > 15) {
				$error['first_name'] = "Champ prenom trop grand (15 caracteres)";
			} else {
				if(!preg_match("/^[a-zA-Z ]*$/", $first_name)) {
					$error['first_name'] = "Champ prenom invalide (a-zA-Z )";
				} else {
					$data['first_name'] = $first_name;
				}
			}
		}

		if(empty($last_name)) {
			$error['last_name'] = "Champ nom vide";
		} else {
			if(strlen($last_name) > 15) {
				$error['last_name'] = "Champ nom trop grand (15 caracteres)";
			} else {
				if(!preg_match("/^[a-zA-Z ]*$/", $last_name)) {
					$error['last_name'] = "Champ nom invalide (a-zA-Z )";
				} else {
					$data['last_name'] = $last_name;
				}
			}
		}

		if(empty($mail)) {
			$error['mail'] = "Champ mail vide";
		} else {
			if(strlen($mail) > 80) {
				$error['mail'] = "Champ mail trop grand (80 caracteres)";
			} else {
				if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
					$error['mail'] = "Champ mail invalide (utilisateur@mail.example.com)";
				} else {
					$data['mail'] = $mail;
				}
			}
		}

		if(empty($password)) {
			$error['password'] = "Champ mot de passe vide";
		} else {
			if(strlen($password) > 64) {
				$error['password'] = "Champ mot de passe trop grand (64 caracteres)";
			} else {
				if(!preg_match("/^[a-zA-Z !@#$%^&*]{8,64}$/", $password)) {
					$error['password'] = "Champ mot de passe invalide au moins 8 caracteres (a-zA-Z0-9 !@#$%^&*)";
				} else if(!($password === $valid_password)) {
					$error['password'] = "Les mots de passes ne correspondent pas";
				} else {
					$data['password'] = $password;
				}
			}
		}

		if(empty($phone)) {
			$data['phone'] = null;
		} else {
			if(!preg_match("/^\+[0-9]{8,13}/", $phone)) {
				$error['phone'] = "Champ telephone invalide (+01925784)";
			} else {
				$data['phone'] = $phone;
			}
		}

		if(empty($social_reason)) {
			$data['social_reason'] = null;
		} else {
			if(!preg_match("/^[a-zA-Z0-9 ]{0,40}$/", $social_reason)) {
				$error['social_reason'] = "Champ nom de societes invalides (a-zA-Z0-9 ) 40 caracteres maximum";
			} else {
				$data['social_reason'] = $social_reason;
			}
		}

		if(!empty($error)) {
			$error['valid'] = false;
			return $error;
		} else {
			$data['valid'] = true;
			return $data;
		}
	}

	if(isset($_POST['csup_submit'])) {
		$result = valid_company_infos($_POST['csup_first_name'], $_POST['csup_last_name'], $_POST['csup_mail'], $_POST['csup_password'], $_POST['csup_valid_password'], $_POST['csup_phone'], $_POST['csup_social_reason']);

		if($result['valid']) {
			// Create company
		} else {
			$errors = $result;
		}
	}
?>