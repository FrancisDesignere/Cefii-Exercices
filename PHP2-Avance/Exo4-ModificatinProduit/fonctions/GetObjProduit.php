<?php
session_start();
$_SESSION['Art']=NULL;
$cleanPost = filter_input_array(INPUT_POST);
$codeArt=$cleanPost['code'];
$msg='';
if($_SESSION['token']=== $cleanPost['token']){
    if(file_exists('connect.php')){
        include 'connect.php';
        $strReq = "SELECT * FROM produit where code like :code limit 0,1";
        $prep = $connexion->prepare($strReq);
        $prep->execute(array(':code'=>$codeArt));
        $ObjPdt = $prep->fetchAll(PDO::FETCH_OBJ);
        
//        // on passe l'article trouvé en session
        $_SESSION['Art']= $ObjPdt;

    }else{ // si le fichier de connexion n'est pas présent
        $msg="le fichier permettant la connexion à la base n'est pas présent";
    }
}else{ // cas d'appel non reconnu
    $msg='Tentative d\'attaque !! ';
}

echo $msg;
$_SESSION['msg']= $msg;
header('Location: ../index.php'); 
?>