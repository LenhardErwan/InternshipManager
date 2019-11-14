<?php
	session_start();
	require_once('./assets/script/ConfDB.inc.php');
	require_once('./assets/script/controllers/main.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Accueil</title>
	</head>
	<body>
		<?php require_once('./assets/script/views/nav.php'); ?>
		
		<main>
			<!--Charger la liste des offres-->
			<?php require_once('./assets/script/articleList.php'); ?>
		</main>
		<?php require_once('./assets/script/footer.php'); ?>
	</body>
</html>