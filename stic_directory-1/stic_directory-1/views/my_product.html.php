
<?php 	
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
</div>
<div class="tab-content">
    <div class="tab-pane active" id="tab1">
    	<ul class="nav nav-pills">
    		<li> 
	  			<form action="<?= url_for('/my_product_action_filtre') ?>" id="filterform" method="post" enctype="multipart/form-data" class="form-horizontal label">
			  	 	<span class="label">Filtre :  </span>
			  	 	<div class="control-group">
			  	 		<label id="prix"><input type="radio" name="filtre[choix]" value="prix">prix</label>
			  	 		<label id="date"><input type="radio" name="filtre[choix]" value="date">date</label>
			  	 	</div> 
			  	 	<div class="control-group">
						<label class="radio">
						<input type="radio" name="filtre[genre]" id="optionsRadios1" value="genre1">
							genre1
						</label>
						<label class="radio">
						<input type="radio" name="filtre[genre]" id="optionsRadios2" value="genre2">
							genre2
						</label>
						<label class="radio">
						<input type="radio" name="filtre[genre]" id="optionsRadios3" value="genre3">
							genre3
						</label>
					</div>
				  	<!--<div class="btn-group" data-toggle="buttons-radio">
						<button type="button" class="btn btn-small btn-primary" name="filtre[prix]" value="prix">prix</button>
						<button type="button" class="btn btn-small btn-primary" name="filtre[date]" value="date">date</button>
					</div>
					<div class="btn-group" data-toggle="buttons-radio">
				  		<button type="button" class="btn btn-small btn-primary" name="filtre[genre1]" value="genre1">genre1</button>
				  		<button type="button" class="btn btn-small btn-primary" name="filtre[genre2]" value="genre2">genre2</button>
				  		<button type="button" class="btn btn-small btn-primary" name="filtre[genre3]" value="genre3">genre3</button>
					</div>-->
					<div class="btn-group">
			      		<button type="submit" class="btn btn-primary">Submit</button>
			    	</div>
				</form>
			</li>
		</ul> 
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
