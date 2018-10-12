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
    $strReq = "SELECT * FROM produits";
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
    $strReq = "SELECT * FROM produits where idproduits = :id";
    $prep = $connexion->prepare($strReq);
    $prep->execute(array(':id'=>$idproduits));
    $ObjPdt = $prep->fetch(PDO::FETCH_OBJ); 
    return $ObjPdt;
}

/*mise à jour d'un article  */
function SetItem($reference, $nom, $pdt_commentaire="", $qte=0){
    global $connexion;
    $art = getItemByRef($reference);
    if($art==false){ // cas d'une création d'article
        $reqPrepIns = $connexion->prepare("INSERT INTO produits (`reference`, `nom`) VALUES (:refArt, :nom)");
        $reqPrepIns->execute(array(':refArt'=>$reference, ':nom'=>$nom));
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

/*suppression d'un article via son idproduits*/
function DeleteItem($idproduits){
    global $connexion;
    $strReq = 'DELETE FROM produits where idproduits =:id';
    $ReqPrep = $connexion->prepare($strReq);
    $ReqPrep->bindParam(':id',$idproduits,PDO::PARAM_INT);
    $ReqPrep->execute();
    return $ReqPrep->rowCount(); 
}

?>