<?php
/* cette page regroupe les différents fonctions qui accèdent à la BDD */
if(file_exists('./fonctions/connect.php')){
    include './fonctions/connect.php';
} elseif (file_exists('./connect.php')){
    include './connect.php';
}else{ // si le fichier de connexion n'est pas présent
    $_SESSION['msg']="le fichier permettant la connexion à la base n'est pas présent";
}

/*récupération d'une liste de tous les objets article présents en base*/
function getAllItems() {
    global $connexion;   
//  $strReq = "SELECT * FROM produits";
    $strReq = "SELECT ";
    $strReq .= "    pdts.*, ";
    $strReq .= "    CASE ";
    $strReq .= "        WHEN count(pdtFrns.idfournisseurs)=1 THEN frn.societe ";
    $strReq .= "        ELSE CONCAT(count(pdtFrns.idfournisseurs), ' fournisseurs') ";
    $strReq .= "    END as fournisseur ";
    $strReq .= "FROM ";
    $strReq .= "	`produits` pdts LEFT OUTER JOIN ";
    $strReq .= "    `produit_fournisseurs` pdtFrns on pdts.idproduits = pdtFrns.idproduits LEFT OUTER JOIN ";
    $strReq .= "    `fournisseurs` frn on pdtFrns.idfournisseurs=frn.idfournisseurs ";
    $strReq .= "group by idproduits ";
    $strReq .= "order by pdts.quantite";
    $prep = $connexion->prepare($strReq);
    $prep->execute();
    $lstObjPdt = $prep->fetchAll(PDO::FETCH_OBJ);
    return $lstObjPdt ;

}
/*récupération d'un objet article par sa référence (réf externe) (clé métier)*/
function getItemByRef($reference){
    global $connexion;
    $strReq = "SELECT * FROM produits where reference like :reference limit 0,1";
    $prep = $connexion->prepare($strReq);
    $prep->execute(array(':reference'=>$reference));
    $ObjPdt = $prep->fetch(PDO::FETCH_OBJ); 
    return $ObjPdt;
}
/*récupération d'un objet article par son id (interne)*/
function getItemById($idproduits){
    global $connexion;
//    $strReq = "SELECT * FROM produits where idproduits = :id";
    $strReq = "SELECT ";
    $strReq .= "    pdts.*, ";
    $strReq .= "    CASE ";
    $strReq .= "        WHEN count(pdtFrns.idfournisseurs)=1 THEN frn.societe ";
    $strReq .= "        ELSE CONCAT(count(pdtFrns.idfournisseurs), ' fournisseurs') ";
    $strReq .= "    END as fournisseur ";
    $strReq .= "FROM ";
    $strReq .= "    `produits` pdts LEFT OUTER JOIN ";
    $strReq .= "    `produit_fournisseurs` pdtFrns on pdts.idproduits = pdtFrns.idproduits LEFT OUTER JOIN ";
    $strReq .= "    `fournisseurs` frn on pdtFrns.idfournisseurs=frn.idfournisseurs ";
    $strReq .= "where pdts.idproduits = :id "; 
    $strReq .= "group by idproduits";
    $prep = $connexion->prepare($strReq);
    $prep->execute(array(':id'=>$idproduits));
    $ObjPdt = $prep->fetch(PDO::FETCH_OBJ); 
    return $ObjPdt;
}

/* récupération des fournisseurs d'un produit*/
function getItemSuppliers($idproduits=0){
    global $connexion;
    $strReq = "SELECT frn.idfournisseurs, frn.societe, pdtFrns.idproduits ";
    $strReq .= "FROM ";
    $strReq .= "    `fournisseurs` frn LEFT OUTER JOIN ";
    $strReq .= "    (select * from `produit_fournisseurs` where idproduits = :id ) pdtFrns on pdtFrns.idfournisseurs=frn.idfournisseurs ";
    $strReq .= "order BY pdtFrns.idproduits desc, societe asc";
    $prep = $connexion->prepare($strReq);
    $prep->execute(array(':id'=>$idproduits));
    $ObjFrnPdt = $prep->fetchAll(PDO::FETCH_OBJ); 
    return $ObjFrnPdt;
}

/*mise à jour d'un article  */
function SetItem($reference, $nom, $pdt_commentaire="", $qte=0){
    global $connexion;
    //on recherche d'abord l'article par sa réf pour déterminer s'il s'agit d'une création ou  d'une mise à jour
    $art = getItemByRef($reference);
    // suivant le retour, on sait s'il faut créer l'article ou le modifier
    if($art==false){ // cas d'une création d'article
        $reqPrepIns = $connexion->prepare("INSERT INTO produits (`reference`, `nom`, `pdt_commentaire`, `quantite`) VALUES (:refArt, :nom, :com, :qte)");
        $reqPrepIns->execute(array(':refArt'=>$reference, ':nom'=>$nom, 'com'=>$pdt_commentaire,'qte'=>$qte));
        return $reqPrepIns->rowCount();
    }elseif(count($art)==1){// cas d'une mise à jour article
        $strReq="UPDATE produits SET `pdt_commentaire` = :pdt_commentaire, ";
        $strReq.="`quantite` = :qte, ";
        $strReq.="`nom` = :nom ";
        $strReq.="WHERE `idproduits`= :id";
        $prep = $connexion->prepare($strReq);
        $prep->execute(array(':pdt_commentaire'=>$pdt_commentaire, ':qte'=>$qte, ':nom'=>$nom,':id'=>$art->idproduits));
        return $prep->rowCount();
    }else{
        $_SESSION['msg']= 'cas non prévu : doublon de référence article';
    }
}
/*mise à jour du lien produit/fournisseurs */
function updateItemSuppliersLinks($reference, $LstSuppliersLinks) {
    $cpt=0;
    global $connexion;
    //on recherche d'abord l'id de l'article (qui vient éventuellement d'etre creer)
    $art = getItemByRef($reference);
    if($art==true){ // en théorie, l'article existe forcément
        // comme seuls les liens souhaités nous sont transmis, on supprime tout d'abord tous les liens potentiels
        DeleteItemSuppliersLinks($art->idproduits,'idproduits');
        // puis insert les liens souhaités
        foreach ($LstSuppliersLinks as $supplierLinked) {
            $reqPrepIns = $connexion->prepare("INSERT INTO produit_fournisseurs (`idfournisseurs`, `idproduits`) VALUES (:idfournisseurs, :idproduits)");
            $reqPrepIns->execute(array(':idfournisseurs'=>$supplierLinked, ':idproduits'=>$art->idproduits));
            $cpt+= $reqPrepIns->rowCount();
        }
    }
    return $cpt;
}
function DeleteItemSuppliersLinks($id, $what = 'idproduits') {
    global $connexion;
    // suivant la variable $what, on précise la colonne dont correspondant à la clé fournie
    if ($what = 'idproduits'){
        $strReq = 'DELETE FROM produit_fournisseurs where idproduits =:id';        
    }elseif ($waht = 'idfournisseurs'){
        $strReq = 'DELETE FROM produit_fournisseurs where idfournisseurs =:id';            
    }else{        
        exit();
    }
    $ReqPrep = $connexion->prepare($strReq);
    $ReqPrep->bindParam(':id',$id,PDO::PARAM_INT);
    $ReqPrep->execute();
}
        

/*suppression d'un article via son idproduits*/
function DeleteItem($idproduits){
    global $connexion;
    // n'ayant pas mis de contrainte ou trigger de suppression en cascade dans la BDD, je gère ici applicativement la suppression dans la table de jointure.
    DeleteItemSuppliersLinks($idproduits,'idproduits');
    // on peut maintenant supprimer de la table principale
    $strReq = 'DELETE FROM produits where idproduits =:id';
    $ReqPrep = $connexion->prepare($strReq);
    $ReqPrep->bindParam(':id',$idproduits,PDO::PARAM_INT);
    $ReqPrep->execute();
    return $ReqPrep->rowCount(); 
}

?>