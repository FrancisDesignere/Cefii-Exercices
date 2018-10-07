<?php
/* exo2 cefii connection et récupération des données dant tbl mysql  */

if(file_exists('connect.php')){
    include 'connect.php';
    
    // requete select des codes et désignation de la table produit
    $req = "SELECT code, designation FROM produit";
    $result = $connexion->query($req);

    // récupération des enregs dans un tab numérique et affichage
    $lstIdxPdt = $result->fetchAll(PDO::FETCH_NUM);
    echo "<hr>";
    echo "Affichage des objets récupérés dans Tableau Indice <br>";
    foreach ($lstIdxPdt as $Pdt) {
        echo "Code article : " . $Pdt[0] . " | Désignation : " . $Pdt[1]."<br>";
    }    
    
    // ??? le $result n'etait plus exploitable après le premier fetchAll, je ne comprend pas pourquoi
    $result = $connexion->query($req); //c'est pourquoi je relance donc la requete
    // récupération des enregs dans un tab associatif et affichage
    $lstTabAssocPdt = $result->fetchAll(PDO::FETCH_ASSOC);
    echo "<hr>";
    echo "Affichage des produits récupérés dans Tableau Associatif <br>";
    foreach ($lstTabAssocPdt as $Pdt) {
        echo "Code article : " . $Pdt['code'] . " | Désignation : " . $Pdt['designation']."<br>";
    }

    $result = $connexion->query($req);
    // récupération des enregs dans un tab d'objet et affichage
    $lstObjPdt = $result->fetchAll(PDO::FETCH_OBJ);
    echo "<hr>";
    echo "Affichage des produits récupérés en objets <br>";
    foreach ($lstObjPdt as $Pdt) {
        echo "Code article : " . $Pdt->code . " | Désignation : " . $Pdt->designation ."<br>";  
    }


}else{ // si le fichier de connexion n'est pas présent
    echo "le fichier permettant la connexion à la base n'est pas présent";
}
        
?>
