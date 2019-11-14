<?php
	function valid_con_infos($mail, $password) {
		if(empty($mail)) {
			$error['mail'] = "Champ mail vide";
		} else {
			if(strlen($mail) > 80) {
				$error['mail'] = "Champ mail trop grand 80 caracteres";
			} else {
				if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
					$error['mail'] = "Champ mail invalide";
				} else {
					$data['mail'] = $mail;
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
					$data['password'] = $password;
				}
			}
		}

		if(empty($error)) {
			//check account exist
		} else {
			$error['valid'] = false;
			return $error;
		}
	}

	function connect($mail, $password) {
		$result = valid_con_infos($mail, $password);

		if($result['valid']) {
			//connect
		} else {
			return $result;
		}

	}
?>