<?php if (isset($errors)): ?>
<div class="alert alert-error">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?= implode('<br />', $errors) ?>
</div>
<?php endif; ?>

<form class="form-horizontal" method="post" action="<?= url_for('/profile_action') ?>" enctype="multipart/form-data">
  <fieldset>
    <legend>Profile</legend>

    <div class="control-group">
      <label class="control-label" for="user-firstname">Firstname *</label>
      <div class="controls">
        <input type="text" id="user-firstname"
        name="user[firstname]"
        value="<?= isset($form['firstname']) ? htmlspecialchars($form['firstname']) : '' ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="user-lastname">Lastname *</label>
      <div class="controls">
        <input type="text" id="user-lastname" name="user[lastname]" value="<?= isset($form['lastname']) ? htmlspecialchars($form['lastname']) : '' ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="user-class_of">Class of</label>
      <div class="controls">
        <select id="user-class_of" name="user[class_of]">
          <?php foreach ($years as $year): ?>
          <option value="<?= $year ?>" <?= $year == $form['class_of'] ? 'selected="selected"' : '' ?>><?= $year ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="user-photo">Photo</label>
      <div class="controls">
        <?php if ($user['photo']): ?>
        <img src="<?= url_for('public/user', $user['photo']) ?>" alt="" class="img-polaroid" /><br />
        <label class="checkbox"><input type="checkbox" name="user[photo]" value="" /> Remove photo?</label>
        <?php endif; ?>
        <input type="file" id="user-photo" name="user[photo]" />
      </div>
    </div>

    <hr />

    <div class="control-group">
      <label class="control-label" for="user-email">Email *</label>
      <div class="controls">
        <input type="text" id="user-email" name="user[email]" value="<?= isset($form['email']) ? htmlspecialchars($form['email']) : '' ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="user-password">Password</label>
      <div class="controls">
        <input type="password" id="user-password" placeholder="Password" name="user[password]" />
        <span class="help-inline">Only fill if you want to change your password</span><br />
        <input type="password" id="user-password_confirmation" placeholder="Confirmation" name="user[password_confirmation]" />
      </div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">Submit</button>
      <button type="reset" class="btn">Cancel</button>
      <a class="btn btn-danger" href="<?= url_for('/signout') ?>">Sign out</a>
    </div>
  </fieldset>
</form>