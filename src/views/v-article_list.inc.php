<?php
	$articles = listArticles();
	foreach ($articles as $article) {
?>
	<article class="index_article">
		<div class="article_header">
			<h1 class="header_left"><a href="?page=article&id=<?= $article->id_hash; ?>"><?= $article->title; ?></a></h1>
			<h2 class="header_right"><?= $article->begin_date; ?> / <?= $article->end_date; ?></h2>
		</div>
		<h2 class="article_user"><a href="?page=profile&id=<?= $article->id_company; ?>"><?= $article->social_reason; ?></a></h2>
		<p class="article_desc"><?= $article->mission; ?></p>
		<a class="article_link" href="?page=article&id=<?= $article->id_hash; ?>">Plus de details</a>
	</article>
<?php
	}
?>