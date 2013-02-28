<?php if (isset($errors)): ?>
<div class="alert alert-error">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?= implode('<br />', $errors) ?>
</div>
<?php endif; ?>

<form class="form-horizontal" method="post" action="<?= url_for('/signup_action') ?>">
  <fieldset>
    <legend>Sign up</legend>

    
    <div class="control-group">
      <label class="control-label" for="user-lastname">Lastname *</label>
      <div class="controls">
        <input type="text" id="user-lastname" name="user[lastname]" value="<?= isset($form['lastname']) ? htmlspecialchars($form['lastname']) : '' ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="user-firstname">Firstname *</label>
      <div class="controls">
        <input type="text" id="user-firstname" name="user[firstname]" value="<?= isset($form['firstname']) ? htmlspecialchars($form['firstname']) : '' ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="user-email">Email *</label>
      <div class="controls">
        <input type="text" id="user-email" name="user[email]" value="<?= isset($form['email']) ? htmlspecialchars($form['email']) : '' ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="user-password">Password *</label>
      <div class="controls">
        <input type="password" id="user-password" placeholder="Password" name="user[password]" /><br />
        <input type="password" id="user-password_confirmation" placeholder="Confirmation" name="user[password_confirmation]" />
      </div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">Submit</button>
      <button type="reset" class="btn">Cancel</button>
    </div>
  </fieldset>
</form>