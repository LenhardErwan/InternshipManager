<?php
	$contents = listArticles();
	if(is_array($contents)) {
		foreach ($contents as $content) {
?>
	<article class="index_article">
		<div class="article_header">
			<h1 class="header_left"><a href="?page=article&id=<?= $content["article"]->id_hash; ?>"><u><?= $content["article"]->title; ?></u></a></h1>
			<h2 class="header_right"><?= $content["article"]->begin_date; ?> / <?= $content["article"]->end_date; ?></h2>
		</div>
		<h2 class="article_user"><a href="?page=profile&id=<?= $content["article"]->id_company; ?>"><u><?= $content["article"]->social_reason; ?></u></a></h2>
		<p class="article_desc"><?= $content["article"]->mission; ?></p>
		<p class="vote_article"><?= $content["value_vote"]; ?> (nombre de votes <?= $content["total_vote"]; ?>)</p>
		<a class="article_link" href="?page=article&id=<?= $content["article"]->id_hash; ?>"><u>Plus de details</u></a>
	</article>
<?php
		}
	}
	else {
?>
	<div><?= $contents ?></div>
<?php } ?>