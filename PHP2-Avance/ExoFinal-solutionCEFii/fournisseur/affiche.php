<?php
	$requete  = "SELECT * FROM fournisseur";
	$resultat = $connexion->query($requete);
	
	if($resultat) {
		$liste    = $resultat->fetchAll(PDO::FETCH_ASSOC);
		
		if (count($liste)>0) {
			echo "<table id='tableau' class='table table-striped table-hover table-responsive' cellspacing='0' width='100%' role='grid' aria-describedby='tableEleves_info'>";
			echo "<thead>
						<tr role='row'>
							<th>Id</th>
							<th>Nom</th>
							<th>Adresse</th>
							<th>CP</th>
							<th>Ville</th>
							<th></th>
							<th></th>
						</tr>
					</thead><tbody>";
			foreach($liste as $element) {
				echo "<tr>";
				echo "<td>".$element["id"]."</td>";
				echo "<td>".$element["societe"]."</td>";
				echo "<td>".$element["adresse"]."</td>";
				echo "<td>".$element["code_postal"]."</td>";
				echo "<td>".$element["ville"]."</td>";
				echo "<td>"."<a href='index.php?page=formModif&table=fournisseur&id="
				.$element["id"]
				."'><span class='glyphicon glyphicon-edit'></span></a></td>";
				echo "<td>"."<a href='index.php?page=supp&table=fournisseur&id="
				.$element["id"]
				."'><span class='glyphicon glyphicon-trash'></span></a></td>";
				echo "</tr>";
			}	
			echo "</tbody></table>";
		}
	}	
	else {
		echo "liste vide";
	}	
