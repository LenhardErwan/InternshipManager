<div class="vote" id="<?php echo $id_hash ?>">
	<div>
    	<button class="like" onclick="<?php echo $functions['like']; ?>" <?php if(isset($user_vote) && $user_vote) echo "check"; ?>>like</button>
    	<span><?php echo $votes['positive'] ?></span>
	</div>
    <div>
    	<button class="dislike" onclick="<?php echo $functions['dislike']; ?>" <?php if(isset($user_vote) && !$user_vote) echo "check"; ?>>dislike</button>
    	<span><?php echo $votes['negative'] ?></span>
	</div>
</div>
