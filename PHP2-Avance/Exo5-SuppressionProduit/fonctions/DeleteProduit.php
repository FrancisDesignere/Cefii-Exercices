<?php
session_start();
$_SESSION['Art']=NULL;
$cleanPost = filter_input_array(INPUT_POST);

if($_SESSION['token']=== $cleanPost['token']){
    if(file_exists('connect.php')){
        include 'connect.php';
        // requete de tous les atributs de l'article
        $strReq = 'DELETE FROM produit where id =:id';
        $ReqPrep = $connexion->prepare($strReq);
        $ReqPrep->bindParam(':id',$cleanPost['id'],PDO::PARAM_INT);
        $ReqPrep->execute();
        if ($ReqPrep->rowCount()>0){
            $msg="article supprimé";
        }else{
            $msg="Problème lors de la suppression";
        }   
    }else{ // si le fichier de connexion n'est pas présent
        $msg="le fichier permettant la connexion à la base n'est pas présent";
    }
}else{ // cas d'appel non reconnu
    $msg='Tentative d\'attaque !! ';
}

$_SESSION['msg']= $msg;
header('Location: ../index.php'); 
?>