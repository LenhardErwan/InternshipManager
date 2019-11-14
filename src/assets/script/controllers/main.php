<?php
	require_once('account.php');
	require_once('membre.php');
	require_once('entreprise.php');

	if(isset($_POST['msup_submit'])) {
		$result = create_membre($_POST['msup_first_name'], $_POST['msup_last_name'], $_POST['msup_mail'], $_POST['msup_password'], $_POST['msup_valid_password'], $_POST['msup_phone'], $_POST['msup_birth_date'], $_POST['msup_degrees']);

		if($result['valid']) {
			//connect
		} else {
			$errors = $result;
		}
	}

	if(isset($_POST['mupd_submit'])) {

	}

	if(isset($_POST['esup_submit'])) {
		$result = create_entreprise($_POST['esup_first_name'], $_POST['esup_last_name'], $_POST['esup_mail'], $_POST['esup_password'], $_POST['esup_valid_password'], $_POST['esup_phone'], $_POST['esup_social_reason']);

		if($result['valid']) {
			//connect
		} else {
			$errors = $result;
		}
	}

	if(isset($_POST['eupd_submit'])) {
		
	}

	if(isset($_POST['con_submit'])) {
		$result = connect($_POST['con_mail'], $_POST['con_password']);

		if($result['valid']) {
			//
			echo "connecter";
		} else {
			$errors = $result;
		}
	}
?>