<?php
	$articles = listArticles();
	foreach ($articles as $article) {
?>
	<a href="?page=article&id=<?= $article->id_hash; ?>">
		<article>
			<h1><?= $article->title; ?></h1>
			<h2><?= $article->social_reason; ?></h2>
			<h2><?= $article->begin_date; ?> / <?= $article->end_date; ?></h2>
			<p><?= $article->mission; ?></p>
			<!--Fonctionnalites de vote-->
		</article>
	</a>
<?php
	}
?>