<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Administration</title>
		<link rel="stylesheet" type="text/css" href="assets/style/admin.css">
		<script src="assets/script/modal.js"></script>
	</head>
	<body>
		<?php require('v-nav.inc.php'); ?>

		<main>
			<form action="" method="POST">
				<table>
					<tr>
						<th>Proprietaire Article</th>
						<th>Nom Article</th>
						<th>Description</th>
						<th>Modifier</th>
						<th>Supprimer</th>
					</tr>
					<?php foreach(getAdminArticles() as $article) { ?>
						<tr>
							<td><?= $article->social_reason; ?></td>
							<td><?= $article->title; ?></td>
							<td><?= $article->mission; ?></td>
							<td><button type="submit" name="admin_article_edit">Modifier</button></td>
							<td><button type="submit" name="admin_article_del">Supprimer</button></td>
						</tr>
					<?php } ?>
				</table>
				<table>
					<tr>
						<th>Nom entreprise</th>
						<th>Nom representant</th>
						<th>Prenom representant</th>
						<th>Compte valide</th>
					</tr>
					<?php foreach(getAdminCompanies() as $company) { ?>
						<tr>
							<td><?= $company->social_reason; ?></td>
						</tr>
					<?php } ?>
				</table>
				<table>
					<tr>
						<th>Nom</th>
						<th>Prenom</th>
					</tr>
				</table>
			</form>
		</main>

		<?php require('v-footer.inc.php'); ?>
	</body>
</html>