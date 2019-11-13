<div class="vote" id="<?php echo $id_hash ?>">
    <button class="like" onclick="<?php echo $functions['like'] ?>">like</button><span><?php echo $votes['positive'] ?></span>
    <button class="dislike" onclick="<?php echo $functions['dislike'] ?>">dislike</button><span><?php echo $votes['negative'] ?></span>
</div>