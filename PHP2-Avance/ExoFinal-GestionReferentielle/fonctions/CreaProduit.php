<?php
session_start();
$cleanPost = filter_input_array(INPUT_POST);
$refArt = $cleanPost['reference'];
$pdt_commentaire = $cleanPost['pdt_commentaire'];
$msg = '';
include './functions.php';
    if($_SESSION['token']===$cleanPost['token']){
        // appel de la fonction de création (setItem check si produit existe pour savoir si insert ou update))
        $newArt= SetItem($refArt, $pdt_commentaire);
        if ($newArt==1){
            $msg='Produit '.$pdt_commentaire .' bien créé';
        }else{
            $msg='un problème est survenu à la création de l\'article';
        }
    }else{ // cas d'appel non reconnu
        $msg='Tentative d\'attaque !! ';
    }


if ($msg==''){$msg='Cas non prévu, merci de nous contacter ;-) ';}

$_SESSION['msg']= $msg;
header('Location: ../index.php'); 
?>