<?php
/* j'aimerai faire passé l'objet article trouvé dans une variable public (accessible à toute la session) 
 * mais ne sait pas comment faire
 * du coup je passe son id dans une variable en session (il m'a été déconseille de passé tout l'objet en variable de session
 *  ... mais ça m'obligera à rappeler la base pour avoir  l'objet) 
 */
session_start();
$_SESSION['Art']=NULL; //// à enlever ?
$_SESSION['idArtEnCours']=NULL;

$cleanPost = filter_input_array(INPUT_POST);
$msg='';

    include './functions.php';

    if($_SESSION['token']=== $cleanPost['token']){

        // on récupère l'objet article selectioné par la fonction 
        $ArtSelected = getItemById($cleanPost['idproduits']);
        // on stock l'id de l'article trouvé en variable de session 
        $_SESSION['idArtEnCours']= $ArtSelected->idproduits; 

    }else{ // cas d'appel non reconnu
        $msg='Tentative d\'attaque !! ';
    }
    
    $_SESSION['msg']= $msg;
//// echo $page; // la variable en question n'est pas accessible d'ici (mais on en a pas tellement besoin)     
header('Location: ../index.php'); 
?>
