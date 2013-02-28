<?php if (isset($errors)): ?>
<div class="alert alert-error">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?= implode('<br />', $errors) ?>
</div>
<?php endif; ?>

<form class="form-horizontal" method="post" action="<?= url_for('/signin_action') ?>">
  <fieldset>
    <legend>Sign in</legend>

    <div class="control-group">
      <label class="control-label" for="user-email">Email *</label>
      <div class="controls">
        <input type="text" id="user-email" name="user[email]" value="<?= isset($form['email']) ? $form['email'] : '' ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="user-password">Password *</label>
      <div class="controls">
        <input type="password" id="user-password" name="user[password]" />
      </div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">Submit</button>
      <button type="reset" class="btn">Cancel</button>
    </div>
  </fieldset>
</form>