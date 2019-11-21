
<div class="comment">
    <p><?= nl2br($comment->text) ?></p>
    <?php if(isset($can_comment) && $can_comment) { ?>
    <form action="" method="POST">
        <button type="submit" id="edit_comment" name="action" value="edit_comment">Editer</button>
    </form>
    <button type="button" class="open_modal" onClick="openModal('delete_comment')" >Supprimer</button>
            
    <?php 
        $action_to_perform = "delete_comment"; 
        $text = "Êtes vous sur de vouloir supprimer votre commentaire ?";
        require("v-confirm_delete.inc.php");
    } 
    ?>
</div>