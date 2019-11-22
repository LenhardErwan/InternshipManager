<?php
	$articles = listArticles();
	foreach ($articles as $article) {
?>
	<article class="index_article">
		<div class="article_header">
			<h1><a href="?page=article&id=<?= $article->id_hash; ?>"><?= $article->title; ?></a></h1>
			<h2><a href="?page=profile&id=<?= $article->id_company; ?>"><?= $article->social_reason; ?></a></h2>
			<h2><?= $article->begin_date; ?> / <?= $article->end_date; ?></h2>
		</div>
		<p class="article_desc"><?= $article->mission; ?></p>
		<a href="?page=article&id=<?= $article->id_hash; ?>">Plus de details</a>
		<!--Fonctionnalites de vote-->
	</article>
<?php
	}
?>