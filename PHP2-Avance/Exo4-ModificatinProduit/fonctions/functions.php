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
    $strReq = "SELECT * FROM produit";
    $prep = $connexion->prepare($strReq);
    $prep->execute();
    $lstObjPdt = $prep->fetchAll(PDO::FETCH_OBJ);
    return $lstObjPdt ;

}
/*récupération d'un objet article par son code (réf externe) (clé métier)*/
function getItemByCode($code){
    global $connexion;
    $strReq = "SELECT * FROM produit where code like :code limit 0,1";
    $prep = $connexion->prepare($strReq);
    $prep->execute(array(':code'=>$code));
    $ObjPdt = $prep->fetch(PDO::FETCH_OBJ); 
    return $ObjPdt;
}
/*récupération d'un objet article par son id (interne)*/
function getItemById($id){
    global $connexion;
    $strReq = "SELECT * FROM produit where id = :id";
    $prep = $connexion->prepare($strReq);
    $prep->execute(array(':id'=>$id));
    $ObjPdt = $prep->fetch(PDO::FETCH_OBJ); 
    return $ObjPdt;
}

/*mise à jour d'un article  */
function SetItem($code, $designation, $pu=0, $madeIn=""){
    global $connexion;
    $art = getItemByCode($code);
    if(count($art)==0){ // cas d'une création d'article
        $reqPrepIns = $connexion->prepare("INSERT INTO produit (`code`, `designation`) VALUES (:codeArt, :designation)");
        $reqPrepIns->execute(array(':codeArt'=>$code, ':designation'=>$designation));
        return $reqPrepIns->rowCount();
    }elseif(count($art)==1){// cas d'une mise à jour article
        $strReq="UPDATE produit SET `designation` = :designation, ";
        $strReq.="`prixUnitaire` = :pu, ";
        $strReq.="`madeIn` = :madeIn ";
        $strReq.="WHERE `id`= :id";
        $prep = $connexion->prepare($strReq);
        $prep->execute(array(':designation'=>$designation, ':pu'=>$pu, ':madeIn'=>$madeIn,':id'=>$art->id));        
        return $prep->rowCount();
    }else{
        $_SESSION['msg']= 'cas non prévu : doublon de code article';
    }
}
?>