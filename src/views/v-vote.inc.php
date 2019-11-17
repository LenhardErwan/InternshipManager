<div class="vote" id="<?php echo $id_hash ?>">
    <button class="like" onclick="<?php echo $functions['like']; ?>" <?php if(isset($user_vote) && $user_vote) echo "check"; ?>>like</button><span><?php echo $votes['positive'] ?></span>
    <button class="dislike" onclick="<?php echo $functions['dislike']; ?>" <?php if(isset($user_vote) && !$user_vote) echo "check"; ?>>dislike</button><span><?php echo $votes['negative'] ?></span>
</div>
