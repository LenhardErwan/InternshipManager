<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<title>Accueil</title>
		<script src="assets/script/modal.js"></script>
		<link rel="stylesheet" type="text/css" href="assets/style/reset.css">
		<link rel="stylesheet" type="text/css" href="assets/style/nav.css">
		<link rel="stylesheet" type="text/css" href="assets/style/index.css">
	</head>
	<body>
		<?php require('v-nav.inc.php'); ?>

		<main id="index_main">
			<h1 id="index_title">Internship Management</h1>
			<?php require('v-article_list.inc.php'); ?>
		</main>

		<?php require('v-footer.inc.php'); ?>
	</body>
</html>