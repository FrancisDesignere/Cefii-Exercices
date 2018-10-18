<?php

        //$id = $_POST['id'];
	
	$requete  = "SELECT * FROM fournisseur WHERE id = $id";
	$resultat = $connexion->query($requete);
	
	$liste = array();
	if($resultat) {
		$liste    = $resultat->fetch(PDO::FETCH_ASSOC);
	}
	
?>

<form class="form-horizontal" name="formulaire" action="index.php?page=modifBD&table=fournisseur" method="POST">
	<div class="	hidden form-group">
		<label class="col-xs-2 control-label" for="id">id</label>
		<div class="col-xs-10">
			<input readonly type="hidden"  id="id" name="id" value='<?php echo $liste['id'];?>' required />
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-xs-2 control-label" for="societe">societe</label>
		<div class="col-xs-10">
			<input class="form-control" type="text" id="societe" name="societe" value='<?php echo $liste['societe'];?>' required />
		</div>
	</div>
	
	<div class="form-group">
	<label class="col-xs-2 control-label" for="adresse">Adresse</label>
	<div class="col-xs-10">
		<input class="form-control" type="text" id="adresse" name="adresse" value='<?php echo $liste['adresse'];?>' required />
	</div>
</div>

<div class="form-group">
	<label class="col-xs-2 control-label" for="code_postal">CP</label>
	<div class="col-xs-10">
		<input class="form-control" type="number" id="code_postal" name="code_postal" value='<?php echo $liste['code_postal'];?>' />
	</div>
</div>

<div class="form-group">
	<label class="col-xs-2 control-label" for="ville">Ville</label>
	<div class="col-xs-10">
		<input class="form-control" type="text" id="ville" name="ville" value='<?php echo $liste['ville'];?>' />
	</div>
</div>

<div class="form-group">
	<label class="col-xs-2 control-label" for="commentaire">Commentaire</label>
	<div class="col-xs-10">
		<input class="form-control" type="text" id="commentaire" name="commentaire" value='<?php echo $liste['commentaire'];?>' />
	</div>
</div>


<div class="col-xs-10 col-xs-push-2">
	<input class="btn btn-primary" type="submit">
</div>
</form>	
