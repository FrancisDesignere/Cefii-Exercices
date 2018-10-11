<?php
session_start();
$cleanPost = filter_input_array(INPUT_POST);
$msg = '';
if ($cleanPost['pu']==''){$cleanPost['pu']=0;}

include './functions.php';

if($_SESSION['token']===$cleanPost['token']){
    $nbMajPdt = SetItem($cleanPost['code'], $cleanPost['designation'], $cleanPost['pu'], $cleanPost['madeIn']);
    if ($nbMajPdt==1){
        $msg='Le produit "'.$cleanPost['designation'] .'" a bien été mis à jour';
    }else{
        $msg='Le produit n\'a pas été mis à jour (l\'avez vous modifié ?)';
    }
}else{ // cas d'appel non reconnu
    $msg='Tentative d\'attaque !! ';
}

if ($msg==''){$msg='Cas non prévu, merci de nous contacter ;-) ';}
$_SESSION['msg']= $msg;
header('Location: ../index.php');
?>
