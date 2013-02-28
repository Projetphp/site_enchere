<h2>My profile</h2>

<?php 	$infoUser=$_SESSION['infoUser'];
		if (isset($errors)): ?>
<div class="alert alert-error">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?= implode('<br />', $errors) ?>
</div>
<?php endif; ?>

<form class="form-horizontal" method="post" action="<?= url_for('/my_profile_action') ?>" enctype="multipart/form-data">
  <fieldset>
    <legend>user's Profil</legend>

    <div class="control-group">
      <label class="control-label" for="user-pseudo">pseudo *</label>
      <div class="controls">
        <input type="text" id="user-pseudo" placeholder=" <?php echo $infoUser['pseudoUser'] ?>" name="user[pseudo]" value="<?= isset($form['pseudo']) ? htmlspecialchars($form['pseudo']) : '' ?>" />
      </div>
    </div>
    
    
    <!--<div class="control-group">
      <label class="control-label" for="user-class_of">êtes vous majeur</label>
      	<div class="btn-group" data-toggle="buttons-checkbox">
		  <button type="button" class="btn btn-primary" name="age" value="plus">+18</button>
		  <button type="button" class="btn btn-primary" name="age" value="moins">-18</button>
		</div>
    </div>-->
 
    <hr />

    <div class="control-group">
      <label class="control-label" for="user-email">Email </label>
      <div class="controls">
        <input type="text" id="user-email" placeholder="<?php echo $infoUser['mailUser'] ?>" name="user[email]" value="<?= isset($form['email']) ? htmlspecialchars($form['email']) : '' ?>" />
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
  </fieldset>
  <fieldset>

    <legend>seller's profil**</legend>
    <div class="control-group">
      <label class="control-label" for="user-firstname">Firstname **</label>
      <div class="controls">
        <input type="text" id="user-firstname"
        name="user[firstname]"
        placeholder="<?php echo $infoUser['prenomUser'] ?>"
        value="<?= isset($form['firstname']) ? htmlspecialchars($form['firstname']) : '' ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="user-lastname">Lastname **</label>
      <div class="controls">
        <input type="text" id="user-lastname" placeholder=" <?php echo $infoUser['nomUser'] ?>" name="user[lastname]" value="<?= isset($form['lastname']) ? htmlspecialchars($form['lastname']) : '' ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="user-society">society **</label>
      <div class="controls">
        <input type="text" id="user-society" placeholder=" <?php echo $infoUser['societyUser'] ?>" name="user[society]" value="<?= isset($form['society']) ? htmlspecialchars($form['society']) : '' ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="user-adress">adress **</label>
      <div class="controls">
        <input type="text" id="user-adress" placeholder=" <?php echo $infoUser['adressUser'] ?>" name="user[adress]" value="<?= isset($form['adress']) ? htmlspecialchars($form['adress']) : '' ?>" />
      </div>
    </div>
    <div class="control-group">
      <p>* informations obligatoire pour acheter<br/>** informations obligatoires pour vendre</p>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">Submit</button>
      <button type="reset" class="btn">Cancel</button>
      <a class="btn btn-danger" href="<?= url_for('/signout') ?>">Sign out</a>
    </div>
  </fieldset>
</form>