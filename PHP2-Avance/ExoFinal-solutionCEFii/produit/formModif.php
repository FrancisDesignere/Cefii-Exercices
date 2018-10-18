<?php
	
	/**
		* Recherche du produit en cours à partir de l'id sélectionné
	*/ 
        //$id = $_POST['id']; //le post est récupéré dès l'index et passé en variable id
            //ce qui m'a permis par ailleur de passe l'id en Get à l'index et de mettre des conditions pour toujours nourrir $id
	
	$requete  = "SELECT * FROM produit WHERE id = $id";
	$resultat = $connexion->query($requete);
	
	$listeProduit = array();
	if($resultat) {
		$listeProduit = $resultat->fetch(PDO::FETCH_ASSOC);
	}
	
	/**
		* Recherche de la liste des fournisseurs
	*/ 
	$requete  = "SELECT * FROM fournisseur";
	$resultat = $connexion->query($requete);
	
	if($resultat) {
		$listeFournisseur = $resultat->fetchAll(PDO::FETCH_ASSOC);
		
		if (count($listeFournisseur)>0) {
			$select_options = "";
			foreach($listeFournisseur as $element) {
				$selected = "";
				if ($listeProduit['id_fournisseur']==$element['id']) {
					$selected = "selected='selected'";
				}
				$select_options .= "<option $selected value='".$element["id"]."'>";
				$select_options .= $element["societe"]." ";
				$select_options .= "</option>";
			}	
		}
	}	
	else {
		echo "liste vide";
	}
?>

<form  class="form-horizontal" name="formulaire" action="index.php?page=modifBD&table=produit" method="POST">
	<div class="hidden form-group">
		<label class="col-xs-2 control-label" for="reference">id</label>
		<div class="col-xs-10">
			<input class="form-control" type="text" id="id" name="id" value='<?php echo $listeProduit['id'];?>' required />
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-xs-2 control-label" for="reference">reference</label>
		<div class="col-xs-10">
			<input class="form-control" type="text" id="reference" name="reference" value='<?php echo $listeProduit['reference'];?>' required />
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-xs-2 control-label" for="nom">nom</label>
		<div class="col-xs-10">
			<input class="form-control" type="text" id="nom" name="nom" value='<?php echo $listeProduit['nom'];?>' required />
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-xs-2 control-label" for="quantite">Quantité</label>
		<div class="col-xs-10">
			<input class="form-control" type="number" id="quantite" name="quantite" value='<?php echo $listeProduit['quantite'];?>' />
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
			<textarea class="form-control" type="text" id="commentaire" name="commentaire" value='<?php echo $listeProduit['commentaire'];?>' ></textarea>
		</div>
	</div>
	
	<div class="col-xs-10 col-xs-push-2">
		<input class="btn btn-primary" type="submit">
	</div>
</form>					