<div class="modal" id="profile_change_password" style="display: <?php if(isset($error) && !empty($error)) { echo 'flex'; } else { echo 'none'; }?>;">
    <form id="profile_password_container" action="" method="POST">
        <div class="profile_elmt">
            <label for="old_password">*Ancien mot de passe : </label>
            <input type="password" name="old_password" id="old_password" maxlength="64" required />
        </div>

        <div class="profile_elmt">
            <label for="password">*Nouveau Mot de passe : </label>
            <input type="password" name="password" id="password" maxlength="64" required />
        </div>

        <div class="profile_elmt">
            <label for="conf_password">*Confirmer : </label>
            <input type="password" name="conf_password" id="conf_password" maxlength="64" required />
        </div>

        <div id="profile_error"><?php if(isset($error) && !empty($error)) { echo $error; } ?></div>

        <div id="profile_submit">
            <button type="submit" id="change_password" name="action" value="change_password">Enregistrer</button>
            <button class="close_modal">Annuler</button>
        </div>
    </form>
</div>