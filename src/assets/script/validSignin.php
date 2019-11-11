<?php
	function validSignin() {
		if(isset($_SESSION['mail']) && !empty($_SESSION['mail']) && isset($_SESSION['password']) && !empty(['password'])) {
			global $DB;
			$query = $DB->prepare("SELECT mail, password FROM account WHERE mail = ?");
			$query->execute(array($_SESSION['mail']));
			$result = $query->fetch();

			if(!$result) {
				return FALSE;
			} else {
				if($result['password'] == $_SESSION['password']) {
					return TRUE;
				} else {
					return FALSE;
				}
			}
		} else {
			return FALSE;
		}
	}
?>