<?php
session_start();
$cleanPost = filter_input_array(INPUT_POST);
$codeArt = $cleanPost['code'];
$designation = $cleanPost['designation'];
$msg = '';
include './functions.php';
    if($_SESSION['token']===$cleanPost['token']){
        // appel de la fonction de création (setItem check si produit existe pour savoir si insert ou update))
        $newArt= SetItem($codeArt, $designation);
        if ($newArt==1){
            $msg='Produit '.$designation .' bien créé';
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