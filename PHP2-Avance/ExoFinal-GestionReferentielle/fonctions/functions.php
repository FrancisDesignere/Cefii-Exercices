<?php
/**
* cette page regroupe les différents fonctions qui accèdent à la BDD 
*  - Des fonctions qui concernent le produit :  getAllItems , getItemByRef, getItemById , getItemSuppliers , 
*      SetItem, updateItemSuppliersLinks , DeleteItemSuppliersLinks et DeleteItem
*  - les fonctions similiaires concercant les fournisseurs
*/

if (file_exists('./connect.php')){
    include './connect.php';
} elseif (file_exists('./fonctions/connect.php')){
    include './fonctions/connect.php';
}else{ // si le fichier de connexion n'est pas présent
    $_SESSION['msg']="le fichier permettant la connexion à la base n'est pas présent";
}


/**
 * récupération d'une liste de tous les objets articles présents en base
 * 
 * les objets retournés correspondent, pour chaque article, à 
 *      tous les attributs de l'objet article
 *      complété d'un attribut renseignant sur 
 *      - son fournisseur (le nom) si monofournisseurs
 *      - ou bien le nombre de fournisseurs si plusieurs
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
 * getItemSuppliers récupération les fournisseurs avec précisions de ceux proposant le produit passé en paramètre
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

/**********************************************************************/
/*  fonction utilisée dans la gestion des produits ET des fournisseurs */
/**********************************************************************/
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
    if ($what == 'idproduits'){
        $strReq = 'DELETE FROM produit_fournisseurs where idproduits =:id';        
    }elseif ($what == 'idfournisseurs'){
        $strReq = 'DELETE FROM produit_fournisseurs where idfournisseurs =:id';            
    }else{        
        exit();
    }
    $ReqPrep = $connexion->prepare($strReq);
    $ReqPrep->bindParam(':id',$id,PDO::PARAM_INT);
    $ReqPrep->execute();
}
       

/**********************************************************************/
/* les fonctions équivalentes pour la gestions des fournisseurs */
/**********************************************************************/

/**
 * récupération d'une liste de tous les objets fournisseur présents en base
 * 
 * les objets retournés correspondent, pour chaque fournisseur, à 
 *      tous les attributs du fournisseur
 *      complété d'un attribut renseignant sur 
 *      - le produit qu'il propose si un seul produit
 *      - ou bien le nombre de produits qu'il propose si plusieurs
 * 
 * @global object $connexion
 * @return object[]
 */
function getAllSuppliers() {
    global $connexion;   
    $strReq = "SELECT ";
    $strReq .= "    frn.*, ";
    $strReq .= "    CASE ";
    $strReq .= "        WHEN count(pdtFrns.idproduits)=1 THEN pdts.nom ";
    $strReq .= "        ELSE CONCAT(count(pdtFrns.idproduits), ' produits') ";
    $strReq .= "    END as produit ";
    $strReq .= "FROM ";
    $strReq .= "    `fournisseurs` frn LEFT OUTER JOIN ";
    $strReq .= "    `produit_fournisseurs` pdtFrns on pdtFrns.idfournisseurs=frn.idfournisseurs LEFT OUTER JOIN ";
    $strReq .= "    `produits` pdts on pdts.idproduits = pdtFrns.idproduits ";
    $strReq .= "group by idfournisseurs ";
    $strReq .= "order by frn.societe";
    $prep = $connexion->prepare($strReq);
    $prep->execute();
    $lstObjFrn = $prep->fetchAll(PDO::FETCH_OBJ);
    return $lstObjFrn ;
}

/**
 * getSupplierBySoc : retourne l'objet fournisseur demandé par son nom de sociéte
 * 
 * @global object $connexion
 * @param string $societe
 * @return object
 *      retourne un object fournisseur
 */
function getSupplierBySoc($societe){
    global $connexion;
    $strReq = "SELECT * FROM fournisseurs where societe like :societe limit 0,1";
    $prep = $connexion->prepare($strReq);
    $prep->execute(array(':societe'=>$societe));
    $ObjPdt = $prep->fetch(PDO::FETCH_OBJ); 
    return $ObjPdt;
}

/**
 * getSupplierById récupère l'objet correspondant au fournisseur demandé par son id interne
 * 
 * @global object $connexion
 * @param int $idfournisseurs
 * @return objet
 *      objet fournisseur compléter par un 
 */
function getSupplierById($idfournisseurs){
    global $connexion;
    $strReq = "SELECT ";
    $strReq .= "    frn.*, ";
    $strReq .= "    CASE ";
    $strReq .= "        WHEN count(pdts.idproduits)=1 THEN frn.societe ";
    $strReq .= "        ELSE CONCAT(count(pdts.idproduits), ' produits') ";
    $strReq .= "    END as fournisseur ";
    $strReq .= "FROM ";
    $strReq .= "    `fournisseurs` frn LEFT OUTER JOIN ";
    $strReq .= "    `produit_fournisseurs` pdtFrns on pdtFrns.idfournisseurs=frn.idfournisseurs LEFT OUTER JOIN ";
    $strReq .= "    `produits` pdts on pdts.idproduits = pdtFrns.idproduits ";
    $strReq .= "where frn.idfournisseurs = :id "; 
    $strReq .= "group by pdts.idproduits";
    $prep = $connexion->prepare($strReq);
    $prep->execute(array(':id'=>$idfournisseurs));
    $ObjFrnFound = $prep->fetch(PDO::FETCH_OBJ); 
    return $ObjFrnFound;
}
/**
 * getSupplierItems permet de retourner tous les produits, avec précisions de ceux proposés par le fournisseur en question
 * 
 * cette fonction retourne tous les produits pour permettre le rattache d'un produit qui ne l'est pas encore
 * l'indication du null ou d'un id permet de faire le distingo pour l'affichage de ce qui est déjà rattaché
 * 
 * @global object $connexion
 * @param type $idfournisseurs
 * @return type
 */
function getSupplierItems($idfournisseurs=0){
    global $connexion;
    $strReq = "SELECT pdt.idproduits, pdt.nom, frnPdts.idfournisseurs ";
    $strReq .= "FROM ";
    $strReq .= "    `produits` pdt LEFT OUTER JOIN ";
    $strReq .= "    (select * from `produit_fournisseurs` where idfournisseurs = :id ) frnPdts on frnPdts.idproduits=pdt.idproduits ";
    $strReq .= "order BY frnPdts.idfournisseurs desc, nom asc";
    
    $prep = $connexion->prepare($strReq);
    $prep->execute(array(':id'=>$idfournisseurs));
    $ObjPdtFrn = $prep->fetchAll(PDO::FETCH_OBJ); 
    return $ObjPdtFrn;
}

/**
 * Set supplier permet la création ou mise à jour d'un fournisseur (suivant que le nom de la société envoyé existe déjà ou non )
 * 
 * @global object $connexion
 * @param string $societe
 * @param string $adresse
 * @param string $cp
 * @param string $ville
 * @param string $frn_commentaire
 * @return int
 *      retourne le nombre de ligne mise à jour (ou créée) (en l'ocurrence 0 ou 1)
 */
function SetSupplier($societe, $adresse, $cp, $ville, $frn_commentaire=""){
    global $connexion;
    //on recherche d'abord l'article par sa réf pour déterminer s'il s'agit d'une création ou  d'une mise à jour
    $frn = getSupplierBySoc($societe);
    // suivant le retour, on sait s'il faut créer l'article ou le modifier
    if($frn==false){ // cas d'une création d'articl
        $reqPrepIns = $connexion->prepare("INSERT INTO fournisseurs (`societe`, `adresse`, `cp`, `ville`, `frn_commentaire`) VALUES (:societe, :adresse, :cp, :ville, :comm)");
        $reqPrepIns->execute(array(':societe'=>$societe, ':adresse'=>$adresse, ':cp'=>$cp,':ville'=>$ville, ':comm'=>$frn_commentaire));
        return $reqPrepIns->rowCount();
    }elseif(count($frn)==1){// cas d'une mise à jour article
        $strReq="UPDATE fournisseurs SET `societe` = :societe, ";
        $strReq.="`adresse` = :adresse, ";
        $strReq.="`cp` = :cp, ";
        $strReq.="`ville` = :ville, ";
        $strReq.="`frn_commentaire` = :comm ";
        $strReq.="WHERE `idfournisseurs`= :id";      
        $prep = $connexion->prepare($strReq);
        $prep->execute(array(':societe'=>$societe, ':adresse'=>$adresse, ':cp'=>$cp, ':ville'=>$ville, ':comm'=>$frn_commentaire,':id'=>$frn->idfournisseurs));
        return $prep->rowCount();
    }else{
        $_SESSION['msg']= 'cas non prévu : doublon de societé ';
    }
}

/**
 * updateSupplierItemsLinks : permet de maj les produits qu'un fournisseur propose
 * 
 * cett fonction procède par delete / insert dans la table de liens
 * 
 * @global object $connexion
 * @param string $societe
 * @param string[] $LstItemsLinked
 * @return type
 */
function updateSupplierItemsLinks($societe, $LstItemsLinked) {
    $cpt=0;
    global $connexion;
    //on recherche d'abord l'id de l'article (qui vient éventuellement d'etre creer)
    $frn = getSupplierBySoc($societe);
    if($frn==true){ // en théorie, le fournisseur existe forcément (puisqu'on vient d'une selection)
        // comme seuls les liens souhaités nous sont transmis, on supprime tout d'abord tous les liens potentiels
        DeleteItemSuppliersLinks($frn->idfournisseurs,'idfournisseurs');
        // puis insert les liens souhaités
        foreach ($LstItemsLinked as $itemLinked) {
            $reqPrepIns = $connexion->prepare("INSERT INTO produit_fournisseurs (`idfournisseurs`, `idproduits`) VALUES (:idfournisseurs, :idproduits)");
            $reqPrepIns->execute(array(':idfournisseurs'=>$frn->idfournisseurs, ':idproduits'=>$itemLinked));
            $cpt+= $reqPrepIns->rowCount();
        }
    }
    return $cpt;
}

/**
 *  cette fonction perme de supprimer un fournisseur (après avoir supprimé ses rattachement aux produits)
 * 
 * @global object $connexion
 * @param int $idfournisseurs
 * @return int
 */
function DeleteSupplier($idfournisseurs){
    global $connexion;
    // n'ayant pas mis de contrainte ou trigger de suppression en cascade dans la BDD, je gère ici applicativement la suppression dans la table de jointure.
    DeleteItemSuppliersLinks($idfournisseurs,'idfournisseurs');
    // on peut maintenant supprimer de la table principale
    $strReq = 'DELETE FROM fournisseurs where idfournisseurs =:id';
    $ReqPrep = $connexion->prepare($strReq);
    $ReqPrep->bindParam(':id',$idfournisseurs,PDO::PARAM_INT);
    $ReqPrep->execute();
    return $ReqPrep->rowCount(); 
}


?>