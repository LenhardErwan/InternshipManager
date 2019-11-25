<div class="vote" id="<?= $id_hash ?>">
    <span>Nombre de like : <?= $votes['positive'] ?></span><br/>
    <span>Nombre de dislike : <?= $votes['negative'] ?></span><br/>
    <span>Valeur des votes : <?= ($votes['positive'] - $votes['negative'] ) ?>, sur un total de <?= ($votes['positive'] + $votes['negative'] ) ?> votes</span><br/>
    <?php if($status != "company") { ?>
    <button class="like" onclick="<?= $functions['like']; ?>" <?php if(isset($user_vote) && $user_vote->type) echo "check"; ?>>like</button>
    <button class="dislike" onclick="<?= $functions['dislike']; ?>" <?php if(isset($user_vote) && !$user_vote->type) echo "check"; ?>>dislike</button>
    <?php } ?>
</div>
