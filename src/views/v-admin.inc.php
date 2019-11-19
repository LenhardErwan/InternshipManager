<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Administration</title>
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
					<?php foreach (getAdminArticles() as $article) { ?>
						<tr>
							<td><?= $article->social_reason; ?></td>
							<td><?= $article->title; ?></td>
							<td><?= $article->mission; ?></td>
							<td><button type="submit" name="admin_edit">Modifier</button></td>
							<td><button type="submit" name="admin_del">Supprimer</button></td>
						</tr>
					<?php } ?>
				</table>
			</form>
		</main>

		<?php require('v-footer.inc.php'); ?>
	</body>
</html>