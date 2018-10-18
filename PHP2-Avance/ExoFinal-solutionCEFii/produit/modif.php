<?php
	
	// récupération des données issues du formulaire
	$id 			= $_POST['id'];
    $reference 		= $_POST['reference'];
    $nom 			= $_POST['nom'];
    $quantite		= $_POST['quantite'];
    $id_fournisseur	= $_POST['id_fournisseur'];
    $commentaire 	= $_POST['commentaire'];
   
	//création de la requête    
    $requete = $connexion->prepare("UPDATE produit
									SET reference=:reference, 
									nom=:nom, 
									quantite=:quantite, 
									id_fournisseur=:id_fournisseur,
									commentaire=:commentaire
									WHERE id = :id");
	
	$requete->bindParam(':reference',$reference);
	$requete->bindParam(':nom',$nom);
	$requete->bindParam(':quantite',$quantite);
	$requete->bindParam(':id_fournisseur',$id_fournisseur);
	$requete->bindParam(':commentaire',$commentaire);
	$requete->bindParam(':id',$id);
	
	//exécution de la requête
	try {
		$resultat = $requete->execute();
	} 
	catch (Exception $e) {
		echo 'Erreur : ' . $e->getMessage();
	}
	
	if ($resultat) {
		echo '<div class="alert alert-success fade in">';
		echo '<a href="#" class="close" data-dismiss="alert">×</a>';
		echo 'Nombre de produit(s) modifié(s)  : ';
		echo '<span class="badge">'.$resultat.'</span>';
		echo '</div>';
	} 
	else {
		echo '<div class="alert alert-danger fade in">';
		echo '<a href="#" class="close" data-dismiss="alert">×</a>';
		echo 'Erreur : produit non modifié  !';
		echo '</div>';
	}
	
	echo "<a href='index.php?page=affiche&table=produit'><button>Liste</button></a>";
?>