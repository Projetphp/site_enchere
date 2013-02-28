
<?php 	
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$targ_w = $targ_h = 150;
	$jpeg_quality = 90;

	$src = 'demo_files/pool.jpg';
	$img_r = imagecreatefromjpeg($src);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
	$targ_w,$targ_h,$_POST['w'],$_POST['h']);

	header('Content-type: image/jpeg');
	imagejpeg($dst_r,null,$jpeg_quality);
}
$_SESSION['user_id'];
		if (isset($errors)): ?>
<div class="alert alert-error">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?= implode('<br />', $errors) ?>
</div>
<?php endif; ?>
<h2>mes produits</h2>

<div class="tabbable"> <!-- Only required for left/right tabs -->
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">Produits mis en vente</a></li>
    <li><a href="#tab2" data-toggle="tab">Ajouter un produit</a></li>
    <li><a href="#tab3" data-toggle="tab">Messages</a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="tab1">
      <h3>I'm in Section 1.</h3>
      <ul class="thumbnails">
		  <li class="span4">
		    <div class="thumbnail">
		      <img data-src="holder.js/300x200" alt="">
		      <h4>Thumbnail label</h4>
		      <p>Thumbnail caption...</p>
		    </div>
		  </li>
		  
		</ul>
		
    </div>
    <div class="tab-pane" id="tab2">
      	<h3>Ajouter un produit</h3>
	    	<form class="form-horizontal" method="post" action="<?= url_for('/my_product_action_ajout') ?>" enctype="multipart/form-data">
			  	<fieldset>
			    	<legend>Nouveau produit</legend>

			    	<div class="control-group">
			      		<label class="control-label" for="produit-nom">Nom du produit *</label>
			      		<div class="controls">
			        		<input type="text" id="produit-nom" name="produit[nom_produit]" value="<?= isset($form['nom_produit']) ? htmlspecialchars($form['nom_produit']) : '' ?>" />
			      		</div>
			    	</div>
			    	<div class="control-group">
			      		<label class="control-label" for="produit-genre">genre du produit *</label>
			      		<div class="controls">
			                <select name="produit[genre_produit]" id="produit-genre">
			                    <option  value="1" >truc</option>
			                    <option  value="2" >machin</option>
			                    <option  value="3" >bidule</option>
			                </select>
			      		</div>
			    	</div>
			    	<div class="control-group">
			      		<label class="control-label" for="produit-description">description du produit *</label>
			      		<div class="controls">
			        		<textarea type="text" id="produit-description" name="produit[description_produit]" value="" > <?= isset($form['description_produit']) ? htmlspecialchars($form['description_produit']) : '' ?></textarea>
			      		</div>
			    	</div>
			    	<div class="control-group">
			      		<label class="control-label" for="produit-photo">Photo du produit *</label>
			      		<div class="controls">
			        		<?php if ($produit['photo']): ?>
						        <img src="<?= url_for('public/user', $produit['photo']) ?>" alt="" class="img-polaroid" /><br />
					        <?php endif; ?>
					        <input type="file" id="produit-photo" name="produit[photo]" />
			        	
			      		</div>
			    	</div>
			    	<div class="control-group">
			      		<label class="control-label" for="produit-prixDD">prix de départ *</label>
			      		<div class="controls">
			         		<input type="text" id="produit-prixDD" name="produit[prixDD_produit]" value="<?= isset($form['prixDD_produit']) ? htmlspecialchars($form['prixDD_produit']) : '' ?>" />
			      		</div>
			    	</div>
			    	<div class="form-actions">
			      		<button type="submit" class="btn btn-primary">Submit</button>
			      		<button type="reset" class="btn">Cancel</button>
			    	</div>
				</fieldset>
			</form>
	    </div>
    	<div class="tab-pane" id="tab3">
      		<div data-spy="affix" data-offset-top="200">
      			<p>message.</p>
      			<form class="form-horizontal" method="post" action="<?= url_for('/my_product_action_mail') ?>" enctype="multipart/form-data">
      				<fielsdset>
		      			<div class="control-group">
					    	<label class="control-label" for="mail-pseudo">destinataire *</label>
					    	<div class="controls">
					    	    <input type="text"  placeholder="pseudo du déstinataire" class="typeahead" data-provide="typeahead" id="mail-pseudo" name="mail[pseudo_mail]">
					    	</div>
						</div>
		      			<div class="control-group">
					    	<label class="control-label" for="mail-objet">objet *</label>
					    	<div class="controls">
					    	    <input type="text" id="mail-objet" placeholder="objet du mail" name="mail[objet_mail]" value="<?= isset($form['objet_mail']) ? htmlspecialchars($form['objet_mail']) : '' ?>" />
					    	</div>
						</div>
						<div class="control-group">
					      	<label class="control-label" for="mail-message">message *</label>
					      	<div class="controls">
					        	<textarea type="text" id="mail-message" name="mail[message_mail]" value="" > <?= isset($form['message_mail']) ? htmlspecialchars($form['message_mail']) : '' ?></textarea>
					      	</div>
					    </div>
						<div class="form-actions">
			      			<button type="submit" class="btn btn-primary">Submit</button>
			      			<button type="reset" class="btn">Cancel</button>
			    		</div>
					</fieldset>
				</form>
      		</div>
    	</div>
  	</div>
</div>
