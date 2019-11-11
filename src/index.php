<?php
	session_start();
	require_once('./assets/script/ConfDB.inc.php');
	require_once('./assets/script/formHandler.php');
	require_once('./assets/script/validSignin.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Accueil</title>
		<script src="assets/script/nav.js"></script>
	</head>
	<body>
		<?php require_once('./assets/script/nav.php'); ?>
		<main>
			<!--Charger la liste des offres-->
			<?php require_once('./assets/script/articleList.php'); ?>
		</main>
		<?php require_once('./assets/script/footer.php'); ?>
	</body>
</html>