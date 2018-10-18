<?php
	$requete  = "SELECT * FROM fournisseur";
	$resultat = $connexion->query($requete);
	
	if($resultat) {
		$liste = $resultat->fetchAll(PDO::FETCH_ASSOC);
		
		if (count($liste)>0) {
			$select_options = "";
			foreach($liste as $element) {
				$select_options .= "<option value='".$element["id"]."'>";
				$select_options .= $element["societe"]." ";
				$select_options .= "</option>";
			}	
		}
	}	
	else {
		echo "liste vide";
	}
	// var_dump($select_options);
?>

<form  class="form-horizontal" name="formulaire" action="index.php?page=ajoutBD&table=produit" method="POST">
	<div class="form-group">
		<label class="col-xs-2 control-label" for="reference">reference</label>
		<div class="col-xs-10">
			<input class="form-control" type="text" id="reference" name="reference" required />
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-xs-2 control-label" for="nom">nom</label>
		<div class="col-xs-10">
			<input class="form-control" type="text" id="nom" name="nom" required />
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-xs-2 control-label" for="quantite">Quantité</label>
		<div class="col-xs-10">
			<input class="form-control" type="number" id="quantite" name="quantite" />
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-xs-2 control-label" for="fournisseur">Fournisseur</label>
		<div class="col-xs-10">
			<select class="form-control" name="id_fournisseur" >
				<?php
					echo $select_options;
				?>
			</select>
		</div>
	</div>
	
	<div class="form-group">				
		<label class="col-xs-2 control-label" for="commentaire">Commentaire</label>
		<div class="col-xs-10">
			<textarea class="form-control" type="text" id="commentaire" name="commentaire" ></textarea>
		</div>
	</div>
	
	<div class="col-xs-10 col-xs-push-2">
		<input class="btn btn-primary" type="submit">
	</div>
</form>											