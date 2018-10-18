<?php
	$requete  = "SELECT * FROM produit";
	$resultat = $connexion->query($requete);
	
	if($resultat) {
		$liste = $resultat->fetchAll(PDO::FETCH_ASSOC);
		
		if (count($liste)>0) {
			$select_options = "";
			foreach($liste as $element) {
				$select_options .= "<option value='".$element["id"]."'>";
				$select_options .= $element["nom"]." ";
				$select_options .= "</option>";
			}	
		}
	}	
	else {
		echo "liste vide";
	}
	// var_dump($select_options);
?>

<form class="form-horizontal" name="formulaire" action="index.php?page=formModif&table=produit" method="POST">
	<div class="form-group">
		<label class="col-xs-2 control-label" for="nom">nom</label>
		<div class="col-xs-8">
			<select class="form-control" name="id" >
				<?php
					echo $select_options;
				?>
			</select>
		</div>
		
		<div class="col-xs-2">
			<input class="btn btn-primary" type="submit">
		</div>
	</div>
</form>		