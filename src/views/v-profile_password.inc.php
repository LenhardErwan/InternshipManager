<div class="modal" id="change_password" style="display: none;">
    <span>Changement du mot de passe : </span>
    <form action="" method="POST">
        <fieldset>
            <label for="old_password">*Ancien mot de passe : </label>
            <input type="password" name="old_password" id="old_password" maxlength="64" required />
            <br/>
            <label for="password">*Nouveau Mot de passe : </label>
            <input type="password" name="password" id="password" maxlength="64" required />
            <br/>
            <label for="conf_password">*Confirmer : </label>
            <input type="password" name="conf_password" id="conf_password" maxlength="64" required />
            <br/>
            <?php if(isset($error) && !empty($error)) { ?>
            <br/>
            <div id="error">
                <?php echo $error ?>
            </div>
            <?php } ?>
            <button type="submit" id="change_password" name="action" value="change_password">Enregistrer</button>
        </fieldset>
    </form>
    <button class="close_modal">Annuler</button>
</div>