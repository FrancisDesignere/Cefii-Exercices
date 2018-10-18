<?php
	
	// récupération des données issues du formulaire
	$id 			= $_POST['id'];
     $societe 		= $_POST['societe'];
    $adresse 		= $_POST['adresse'];
    $code_postal	= $_POST['code_postal'];
    $ville 			= $_POST['ville'];
    $commentaire 	= $_POST['commentaire'];
	
  
	//création de la requête    
    $requete = $connexion->prepare("UPDATE fournisseur
									SET societe=:societe, 
									adresse=:adresse, 
									code_postal=:code_postal, 
									ville=:ville,
									commentaire=:commentaire
									WHERE id = :id");
	
	$requete->bindParam(':societe',$societe);
	$requete->bindParam(':adresse',$adresse);
	$requete->bindParam(':code_postal',$code_postal);
	$requete->bindParam(':ville',$ville);
	$requete->bindParam(':commentaire',$commentaire);
	$requete->bindParam(':id',$id);
	
	//exécution de la requête
	try {
		$resultat = $requete->execute();
	} 
	catch (Exception $e) {
		echo 'Erreur : ' . $e->getMessage();
	}

	//test du résultat
	if ($resultat) {
		echo '<div class="alert alert-success fade in">';
		echo '<a href="#" class="close" data-dismiss="alert">×</a>';
		echo 'Nombre de fournisseur(s) modifié(s): ';
		echo '<span class="badge">'.$resultat.'</span>';
		echo '</div>';
	} 
	else {
		echo '<div class="alert alert-danger fade in">';
		echo '<a href="#" class="close" data-dismiss="alert">×</a>';
		echo 'Erreur : fournisseur non modifié !';
		echo '</div>';
	}
	
	echo "<a href='index.php?page=affiche&table=fournisseur'><button>Liste</button></a>";
?>