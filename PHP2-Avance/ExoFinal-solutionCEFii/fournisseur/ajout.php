<?php
	
    $societe 		= $_POST['societe'];
    $adresse 		= $_POST['adresse'];
    $code_postal	= $_POST['code_postal'];
    $ville 			= $_POST['ville'];
    $commentaire 	= $_POST['commentaire'];
	
   	//création de la requête  
	
    //exécution de la requête
	try {
		$requete = $connexion->prepare("INSERT INTO fournisseur
		VALUES (NULL, :societe, :adresse, :code_postal, :ville, :commentaire)");
		
		$requete->bindParam(':societe',$societe);
		$requete->bindParam(':adresse',$adresse);
		$requete->bindParam(':code_postal',$code_postal);
		$requete->bindParam(':ville',$ville);
		$requete->bindParam(':commentaire',$commentaire);
		
		$resultat = $requete->execute();
	} 
	catch (PDOException $e) {
		echo 'Erreur : ' . $e->getMessage();
	}
	
	//test du résultat
	if ($resultat) {
		echo '<div class="alert alert-success fade in">';
		echo '<a href="#" class="close" data-dismiss="alert">×</a>';
		echo 'Nombre de nouveau(x) fournisseur(s) : ';
		echo '<span class="badge">'.$resultat.'</span>';
		echo '</div>';
	} 
	else {
		echo '<div class="alert alert-danger fade in">';
		echo '<a href="#" class="close" data-dismiss="alert">×</a>';
		echo 'Erreur : fournisseur non ajouté !';
		echo '</div>';
	}
	
?>