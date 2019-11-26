<div class="vote" id="<?= $id_hash; ?>">
	<div>
		<?php if(($status != "not-connected") && ($status != "company")) { ?>
    	<button class="like" onclick="<?= $functions['like']; ?>" <?php if(isset($user_vote) && $user_vote->type) echo "check"; ?>>+</button>
    	<?php } ?>
    	<span><?= $votes['positive']; ?></span>
	</div>
    <div>
    	<?php if(($status != "not-connected") && ($status != "company")) { ?>
    	<button class="dislike" onclick="<?= $functions['dislike']; ?>" <?php if(isset($user_vote) && !$user_vote->type) echo "check"; ?>>-</button>
    	<?php } ?>
    	<span><?= $votes['negative']; ?></span>
	</div>
</div>
