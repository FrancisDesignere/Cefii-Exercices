<?php
	$id = $_GET['id'];
	
	//création de la requête    
    $requete = $connexion->prepare("DELETE FROM fournisseur WHERE id=:id");
	$requete->bindParam(':id',$id);
	
	//exécution de la requête
    $resultat = $requete->execute();
	
	//test du résultat
    if ($resultat) {
        echo "Nombre de fournisseur(s) supprimé(s): ".$resultat."<br>";
	} 
	else {
        echo "Erreur : fournisseur non supprimé !";
	}
	
echo "<a href='index.php'><button>Liste</button></a>";