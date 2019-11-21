<div class="modal" id="<?= $action_to_perform ?>" style="display: none;">
    <span><?= $text ?></span>
    <form action="" method="POST">
        <button type="submit" id="<?= $action_to_perform ?>_button" name="action" value="<?= $action_to_perform ?>">Oui</button>
    </form>
    <button class="close_modal">Annuler</button>
</div>