<?php 
	
	$query = $DB->prepare("SELECT social_reason, title, begin_date, end_date, mission FROM article a INNER JOIN company c ON a.id_company = c.id_company");
	$query->execute(array());
	$result = $query->fetchAll();

	foreach ($result as $row) { ?>
		<article>
			<h2><?=$row['title']?> | <?=$row['social_reason']?></h2>
			<h2>Du <?=$row['begin_date']?> au <?=$row['end_date']?></h2>
			<p><?=$row['mission']?></p>
			<a href="liker">liker</a>
			<a href="desliker">disliker</a>
		</article>
<?php } ?>