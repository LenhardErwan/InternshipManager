<div class="comment">
    <p>Commentaire : <?= nl2br($comment->text) ?></p>
    <?php if($status == "admin") { ?>
    <form action="" method="POST">
        <button type="submit" id="edit_comment" name="action" value="edit_comment">Editer</button>
    </form>
    <button type="button" class="open_modal" onClick="openModal('delete_comment')" >Supprimer</button>
    <?php } ?>
</div>