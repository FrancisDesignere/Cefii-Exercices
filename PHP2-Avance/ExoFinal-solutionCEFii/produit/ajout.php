<?php
	
    $reference 		= $_POST['reference'];
    $nom 			= $_POST['nom'];
    $quantite		= $_POST['quantite'];
    $id_fournisseur = $_POST['id_fournisseur'];
    $commentaire 	= $_POST['commentaire'];
	
   	//création de la requête  
	$requete = $connexion->prepare("INSERT INTO produit
	VALUES (NULL, :reference, :nom, :quantite, :commentaire, :id_fournisseur)");
	
	$requete->bindParam(':reference',$reference);
	$requete->bindParam(':nom',$nom);
	$requete->bindParam(':quantite',$quantite);
	$requete->bindParam(':id_fournisseur',$id_fournisseur);
	$requete->bindParam(':commentaire',$commentaire);
	
	try {		
		//exécution de la requête
		$resultat = $requete->execute();
	} 
	catch (PDOException $e) {
		echo 'Erreur : ' . $e->getMessage();
	}
	
	//test du résultat
	if ($resultat) {
		echo '<div class="alert alert-success fade in">';
		echo '<a href="#" class="close" data-dismiss="alert">×</a>';
		echo 'Nombre de nouveau(x) produit(s) : ';
		echo '<span class="badge">'.$resultat.'</span>';
		echo '</div>';
	} 
	else {
		echo '<div class="alert alert-danger fade in">';
		echo '<a href="#" class="close" data-dismiss="alert">×</a>';
		echo 'Erreur : produit non ajouté !';
		echo '</div>';
	}
	
?>