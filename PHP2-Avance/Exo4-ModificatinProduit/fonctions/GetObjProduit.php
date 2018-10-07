<?php
session_start();
$_SESSION['Art']=NULL;
$cleanPost = filter_input_array(INPUT_POST);
$codeArt=$cleanPost['code'];

if($_SESSION['token']=== $cleanPost['token']){
    if(file_exists('connect.php')){
        include 'connect.php';
        // requete de tous les atributs de l'article
        $reqSel = 'SELECT * FROM produit where code like "'.$codeArt.'" limit 0,1';
        $result = $connexion->query($reqSel);
        $ObjPdt = $result->fetchAll(PDO::FETCH_OBJ);
        
        // on passe l'article trouvé en session
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