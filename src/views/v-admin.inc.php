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
						<td><a href="?page=article&action=edit_article&id=<?= $article->id_hash; ?>">Modifier</a></td>
						<td><a href="?page=article&action=delete_article&id=<?= $article->id_hash; ?>">Supprimer</a></td>
					</tr>
				<?php } ?>
			</table>
			<table>
				<tr>
					<th>Nom entreprise</th>
					<th>Nom representant</th>
					<th>Prenom representant</th>
					<th>Mail</th>
					<th>Telephone</th>
					<th>Compte valide</th>
					<th>Modifier</th>
					<th>Supprimer</th>
				</tr>
				<?php foreach(getAdminCompanies() as $company) { ?>
					<tr>
						<td><?= $company->social_reason; ?></td>
						<td><?= $company->last_name; ?></td>
						<td><?= $company->first_name; ?></td>
						<td><?= $company->mail; ?></td>
						<td><?= $company->phone; ?></td>
						<td><a href=""><?php if($company->active) {echo "Rendre invalide";} else { echo "Rendre Valide";} ?></a></td>
						<td><a href="">Modifier</a></td>
						<td><a href="">Supprimer</a></td>
					</tr>
				<?php } ?>
			</table>
			<table>
				<tr>
					<th>Nom</th>
					<th>Prenom</th>
					<th>Mail</th>
					<th>Telephone</th>
					<th>Date de naissance</th>
					<th>Diplomes</th>
					<th>Modifier</th>
					<th>Supprimer</th>
				</tr>
				<?php foreach(getAdminMembers() as $member) { ?>
					<tr>
						<td><?= $member->last_name; ?></td>
						<td><?= $member->first_name; ?></td>
						<td><?= $member->mail; ?></td>
						<td><?= $member->phone; ?></td>
						<td><?= $member->birth_date; ?></td>
						<td><?= substr($member->degrees, 0, 20); ?></td>
						<td><a href="">Modifier</a></td>
						<td><a href="">Supprimer</a></td>
					</tr>
				<?php } ?>
			</table>
		</main>

		<?php require('v-footer.inc.php'); ?>
	</body>
</html>