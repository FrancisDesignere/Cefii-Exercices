<?php
	$requete  = "SELECT p.id,`reference`,`nom`,`quantite`,f.societe as nom_fournisseur
						FROM `produit` as p
						JOIN fournisseur as f
						ON p.id_fournisseur = f.id";
	$resultat = $connexion->query($requete);
	
	if($resultat) {
		$liste    = $resultat->fetchAll(PDO::FETCH_ASSOC);
		
		if (count($liste)>0) {
			echo "<div class='container'>";
			echo "<table id='tableau' class='table table-striped table-hover table-responsive'>";
			echo "<thead>
						<tr role='row'>
							<th>Id</th>
							<th>Référence</th>
							<th>Description</th>
							<th>Quantité</th>
							<th>Fournisseur</th>
							<th></th>
							<th></th>
						</tr>
					</thead><tbody>";
			foreach($liste as $element) {
				echo "<tr>";
				echo "<td>".$element["id"]."</td>";
				echo "<td>".$element["reference"]."</td>";
				echo "<td>".$element["nom"]."</td>";
				echo "<td>".$element["quantite"]."</td>";
				echo "<td>".$element["nom_fournisseur"]."</td>";
				echo "<td>"."<a href='index.php?page=formModif&table=produit&id="
				.$element["id"]
				."'><span class='glyphicon glyphicon-edit'></span></a></td>";
				echo "<td>"."<a href='index.php?page=supp&table=produit&id="
				.$element["id"]
				."'><span class='glyphicon glyphicon-trash'></span></a></td>";
				echo "</tr>";
			}	
			echo "</tbody></table></div>";
		}
	}	
	else {
		echo "liste vide";
	}		