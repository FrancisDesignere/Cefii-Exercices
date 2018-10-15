<?php
/**
* cette page regroupe les différents fonctions qui accèdent à la BDD 
*  - Des fonctions qui concernent le produit :  getAllItems , getItemByRef, getItemById , getItemSuppliers , 
*      SetItem, updateItemSuppliersLinks , DeleteItemSuppliersLinks et DeleteItem
*  - les fonctions similiaires concercant les fournisseurs
*/

if(file_exists('./fonctions/connect.php')){
    include './fonctions/connect.php';
} elseif (file_exists('./connect.php')){
    include './connect.php';
}else{ // si le fichier de connexion n'est pas présent
    $_SESSION['msg']="le fichier permettant la connexion à la base n'est pas présent";
}


/**
 * récupération d'une liste de tous les objets article présents en base
 * 
 * @global object $connexion
 * @return object[]
 */
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
/**
 * getItemByRef retourne l'objet produit correspondant à la référence (clé métier) passée en paramêtre
 * 
 * fonction notemment appeler par la création de produit pour assurer l'unicité de la référence
 * 
 * @global object $connexion
 * @param string $reference
 *      la référence du produit (clé métier)
 * @return objet
 *      le produit sous forme d'objet
 */
function getItemByRef($reference){
    global $connexion;
    $strReq = "SELECT * FROM produits where reference like :reference limit 0,1";
    $prep = $connexion->prepare($strReq);
    $prep->execute(array(':reference'=>$reference));
    $ObjPdt = $prep->fetch(PDO::FETCH_OBJ); 
    return $ObjPdt;
}

/**
 * récupération d'un objet article par son id (interne)
 *  
 * @global object $connexion
 * @param int $idproduits
 * @return object
 *      Un objet correspondant au produit (tous ses attributs)
 *      complété d'un attribut renseignant sur 
 *      - son fournisseur (le nom) si monofournisseurs
 *      - ou bien le nombre de fournisseurs si plusieurs
 */
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

/**
 * getItemSuppliers récupération des fournisseurs avec précisions de ceux proposant le produit passé en paramètre
 * 
 *  getItemSuppliers retourne TOUS les fournisseurs avec pour chacun 
 *      - soit l'id du produit si le fournisseur le propose
 *      - soit Null si le fournisseur ne le propose pas
 *  
 * @global object $connexion
 * @param int $idproduits
 * @return object[]
 *      retourne un tableau d'objets avec id du fournisseur, nom de la société et id produit (ou null)
 */
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


/**
 * SetItem met à jour un article, ou le créer si besoin
 * 
 * la fonction commence par vérifier l'existant du produit d'après sa référence
 * puis le créé ou le met à jour suivant qu'il existe ou non
 * 
 * @global object $connexion
 * @param string $reference
 * @param string $nom
 * @param string $pdt_commentaire
 * @param int $qte
 * @return int
 *      le retour donne le nombre d'article créé ou mis à jour (soit 0 ou 1 en l'occurence)
 */
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

/**
 * updateItemSuppliersLinks : mise à jour du lien produit/fournisseurs
 * 
 * @global object $connexion
 * @param string $reference
 * @param int[] $LstSuppliersLinks
 *      un tableau contenant les id des fournisseurs à rattacher au produit
 * @return int
 *      retourne le nombre de liens effectifs
 */
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
/**
 * DeleteItemSuppliersLinks : permet de supprimer les liens d'un produit, ou d'un fournisseurs
 * 
 * si l'id passé en paramètre est  un idproduit on supprime les rattachement du produit à tous ses fournisseurs
 * si l'id passé en paramètre est celui d'un fournisseur, on supprime les rattachement des tous les produits à ce fournisseurs
 * Cette fonction est appelée en préambule de mise à jour de liens (principe de delete / insert)
 * et en préambule de suppression d'article ou de fournisseur (pour couvrir l'absence de delete on cascade dans la BDD)
 * 
 * @global object $connexion
 * @param int $id
 *      l'id passé en parametre sera soit un id de produit, soit un id de fournisseurs
 * @param string $what
 */
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
       

/** 
 * suppression d'un article via son idproduits
 * 
 * @global object $connexion
 * @param int $idproduits
 * @return int
 *      le nombre d'article supprimé est retourné (normalement 1)
 */
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