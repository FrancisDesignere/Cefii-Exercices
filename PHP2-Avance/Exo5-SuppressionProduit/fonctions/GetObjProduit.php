<?php
session_start();
$_SESSION['Art']=NULL;
$_SESSION['idArtEnCours']=NULL;

$cleanPost = filter_input_array(INPUT_POST);
$msg='';

    include './functions.php';

    if($_SESSION['token']=== $cleanPost['token']){

        // on récupère l'objet article selectioné par la fonction 
        $ArtSelected = getItemByCode($cleanPost['code']);
        // on stock l'id de l'article trouvé en variable de session 
        $_SESSION['idArtEnCours']= $ArtSelected->id; 

    }else{ // cas d'appel non reconnu
        $msg='Tentative d\'attaque !! ';
    }
    
    $_SESSION['msg']= $msg;
    header('Location: ../index.php'); 
?>