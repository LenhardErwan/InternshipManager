<div class="modal" id="form_modal" style="display: <?php if(isset($error['password']) && !empty($error['password'])) { echo 'flex'; } else { echo 'none'; }?>;">
    <form id="form_container" action="" method="POST">
        <div class="form_elmt form_elmt_noerror">
            <label for="old_password">*Ancien mot de passe : </label>
            <input type="password" name="old_password" id="old_password" maxlength="64" required />
        </div>

        <div class="form_elmt form_elmt_noerror">
            <label for="password">*Nouveau Mot de passe : </label>
            <input type="password" name="password" id="password" maxlength="64" required />
        </div>

        <div class="form_elmt">
            <label for="conf_password">*Confirmer : </label>
            <input type="password" name="conf_password" id="conf_password" maxlength="64" required />
        </div>

        <div class="form_errors"><?php if(isset($error['password']) && !empty($error['password'])) { echo $error['password']; } ?></div>

        <div class="form_submit_container">
            <button type="submit" class="form_submit" name="action" value="change_password">Enregistrer</button>
            <button class="close_modal form_submit">Annuler</button>
        </div>
    </form>
</div>