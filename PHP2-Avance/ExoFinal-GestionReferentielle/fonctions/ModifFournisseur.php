<?php
session_start();
$cleanPost = filter_input_array(INPUT_POST);

$msg = '';
include './functions.php';
if($_SESSION['token']===$cleanPost['token']){
    $nbMajFrn = SetSupplier($cleanPost['societe'], $cleanPost['adresse'], $cleanPost['cp'], $cleanPost['ville'], $cleanPost['frn_commentaire']);
    if ($nbMajFrn==1){
        $msg='Le fournisseur :"'.$cleanPost['societe'] .'" a bien été mis à jour';
    }else{
        $msg='Le fournisseur n\'a pas été mis à jour (l\'avez vous modifié ?)';
    }
    $nbFrn=updateSupplierItemsLinks($cleanPost['societe'], $cleanPost['pdtFrn']);
    $msg.='<br>il propose '.$nbFrn.' produit(s)';
}else{ // cas d'appel non reconnu
    $msg='Tentative d\'attaque !! ';
}

if ($msg==''){$msg='Cas non prévu, merci de nous contacter ;-) ';}
$_SESSION['msg']= $msg;
header('Location: ../index.php');
?>
