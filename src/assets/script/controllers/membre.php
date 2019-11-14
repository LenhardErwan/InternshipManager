<?php
	//require_once('./');

	function validBirthDate($date, $format = 'Y-m-d') {
	    $d = DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) === $date;
	}

	function valid_membre_create_infos($first_name, $last_name, $mail, $password, $valid_password, $phone, $birth_date, $degrees) {
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

		if(empty($birth_date)) {
			$data['birth_date'] = null;
		} else {
			if(!validBirthDate($birth_date)) {
				$error['birth_date'] = "Champ date de naissance invalide";
			} else {
				$data['birth_date'] = $birth_date;
			}
		}

		if(empty($degrees)) {
			$data['degrees'] = null;
		} else {
			if(!preg_match("/^[a-zA-Z0-9 ]{0,500}$/", $degrees)) {
				$error['degrees'] = "Champ diplomes invalides (a-zA-Z0-9 ) 500 caracteres maximum";
			} else {
				$data['degrees'] = $degrees;
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

	function create_membre($first_name, $last_name, $mail, $password, $valid_password, $phone, $birth_date, $degrees) {
		$result = valid_membre_infos($first_name, $last_name, $mail, $password, $valid_password, $phone, $birth_date, $degrees);

		if($result['valid']) {
			//create membre;
		} else {
			return $result;
		}
	}

	function update_membre($first_name, $last_name, $mail, $password, $valid_password, $phone, $birth_date, $degrees) {
		$result = valid_membre_infos($first_name, $last_name, $mail, $password, $valid_password, $phone, $birth_date, $degrees);

		if($result['valid']) {
			//update membre;
		} else {
			return $result;
		}
	}
?>