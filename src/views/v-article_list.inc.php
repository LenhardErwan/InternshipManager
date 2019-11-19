<?php
	$articles = listArticles();
	foreach ($articles as $article) {
?>
	<article>
		<h1><?= $article->title; ?></h1>
		<h2><a href="?page=profile&id=<?= $article->id_company; ?>"><?= $article->social_reason; ?></a></h2>
		<h2><?= $article->begin_date; ?> / <?= $article->end_date; ?></h2>
		<p><?= $article->mission; ?></p>
		<a href="?page=article&id=<?= $article->id_hash; ?>">Plus de details</a>
		<!--Fonctionnalites de vote-->
	</article>
<?php
	}
?>