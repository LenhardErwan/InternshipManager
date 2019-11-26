<div id="article_comment">
    <p>Commentaire</p>
    <p><?= nl2br($comment->text) ?></p>
    <?php if($status == "admin") { ?>
    <form action="" method="POST">
        <button type="submit" class="article_comment_button" id="edit_comment" name="action" value="edit_comment">Editer</button>
    	<button type="button" class="open_modal article_comment_button" onClick="openModal('delete_comment')">Supprimer</button>
    </form>
    <?php } ?>
</div>