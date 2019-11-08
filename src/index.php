<?php
	session_start();
	require_once('./assets/script/ConfDB.inc.php');
	require_once('./assets/script/formHandler.php');
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
			<article>
				<h2>Article 1 | Entreprise 1</h2>
				<h2>Date debut, duree</h2>
				<p>Affichage de la descritpion mais uniquement un certain nombre de caractere</p>
				<a href="liker">liker</a>
				<a href="desliker">disliker</a>
			</article>
		</main>
		<footer>
			<!--Credit-->
			<p>CASTEL Jeremy | LENHARD Erwan</p>
		</footer>
	</body>
</html>