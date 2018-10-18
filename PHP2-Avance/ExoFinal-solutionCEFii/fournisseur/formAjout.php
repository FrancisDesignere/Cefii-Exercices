<form class="form-horizontal" name="formulaire" action="index.php?page=ajoutBD&table=fournisseur" method="POST">
	<div class="form-group">
		<label class="col-xs-2 control-label" for="societe">societe</label>
		<div class="col-xs-10">
			<input class="form-control"  type="text" id="societe" name="societe" required />
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-xs-2 control-label" for="adresse">Adresse</label>
		<div class="col-xs-10">
			<input class="form-control" type="text" id="adresse" name="adresse" required />
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-xs-2 control-label" for="code_postal">CP</label>
		<div class="col-xs-10">
			<input class="form-control" type="number" id="code_postal" name="code_postal" />
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-xs-2 control-label" for="ville">Ville</label>
		<div class="col-xs-10">
			<input class="form-control" type="text" id="ville" name="ville" />
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-xs-2 control-label" for="commentaire">Commentaire</label>
		<div class="col-xs-10">
			<input class="form-control" type="text" id="commentaire" name="commentaire" />
		</div>
	</div>	
	
	<div class="col-xs-10 col-xs-push-2">
		<input class="btn btn-primary" type="submit">
	</div>
</form>			