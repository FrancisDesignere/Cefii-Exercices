<?php
session_start();
$cleanPost = filter_input_array(INPUT_POST);
$refArt = $cleanPost['reference'];
$nom = $cleanPost['nom'];
$msg = '';
    include './functions.php';
    
    if($_SESSION['token']===$cleanPost['token']){
        // appel de la fonction de création (setItem check si produit existe pour savoir si insert ou update))
        $newArt= SetItem($refArt, $nom, $cleanPost['pdt_commentaire'], $cleanPost['qte']);
        if ($newArt==1){
            $msg='Produit '.$nom .' bien créé';
        }else{
            $msg='un problème est survenu à la création de l\'article';
        }
        //ajout des liens dans la table de jointure
        $nbFrn=updateItemSuppliersLinks($cleanPost['reference'], $cleanPost['frnPdt']);
        $msg.='<br>il est lié à '.$nbFrn.'fournisseur(s)';        
    }else{ // cas d'appel non reconnu
        $msg='Tentative d\'attaque !! ';
    }


if ($msg==''){$msg='Cas non prévu, merci de nous contacter ;-) ';}

$_SESSION['msg']= $msg;
header('Location: ../index.php'); 
?>