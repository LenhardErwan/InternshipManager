<div class="modal confirm_container" id="<?= $action_to_perform; ?>" style="display: none;">
	<div id="confirm_content">
    	<p><?= $text ?></p>
    	<form id="confirm_form" action="" method="POST">
    	    <button type="submit" id="<?= $action_to_perform; ?>_button" name="action" value="<?= $action_to_perform; ?>">Oui</button>
    		<span class="close_modal">Annuler</span>
    	</form>
    </div>
</div>