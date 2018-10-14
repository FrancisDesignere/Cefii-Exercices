<?php 
session_start();
$_SESSION['nbArt']=0;
$token= bin2hex(random_bytes(24));
$_SESSION['token']=(string)$token;
require './fonctions/functions.php';
$cleanGet = filter_input_array(INPUT_GET);
$cleanPost = filter_input_array(INPUT_POST);
// on récupère la page demandée, qui peut provenir 
// d'un post (un formulaire qui ramene vers l'index) 
// d'un Get (en provenance du menu)
// ou de la variable de session 
if (isset($cleanPost['page'])){
    $page=$cleanPost['page'];
    $_SESSION['page']=$page;    
}elseif (isset($cleanGet['page'])){
    $page=$cleanGet['page'];
    $_SESSION['page']=$page;
}elseif (isset($_SESSION['page'])){
    $page=$_SESSION['page'];
}else{
    $page='ListePdts';
}

// on récupère l'article demandé s'il est passé en Post, on le passe également en variable de session pour les retour via location href
if (isset($cleanPost['idproduits'])){
    $idArtEnCours=$cleanPost['idproduits'];
    $_SESSION['idArtEnCours']=$idArtEnCours;
}
echo '<br>' .$page;/////

?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>PHP2-Gestion Référentiel Produits</title>
    <link rel="stylesheet" href="css/styleFormulaire.css" />
    <link rel="stylesheet" href="css/styleMenu.css" />
</head>
<body>
    <h2>PHP2-Gestion Référentiel Produits</h2>
    
    <?php // inclusion du menu //
        include './menu.html'; 
        // chaque option du menu rappel la page d'index, avec une variable $page passé en post

        // inclusion des pages correspondant à la page demandée en POST
        if($page=='ListePdts'){include('./frm/frmListProduits.php');}
        elseif($page=='AddPdt'){include('./frm/frmFicheProduit.php');}
        elseif($page=='UpdtPdt'){
            include('./frm/frmSelectionProduit.php');
            include('./frm/frmFicheProduit.php');
        }
        elseif($page=='DelPdt'){include('./frm/frmSelectionProduit.php');}
/*        
        elseif($page==''){include('');}
        elseif($page==''){include('');}
        elseif($page==''){include('');}
        elseif($page==''){include('');}
        elseif($page==''){include('');}
 * 
 */
        else{  // en théorie pas de raison de passer ici 
            include './frm/frmFicheProduit.php';
        }

    // affichage du message passée en session par le traitement concerné
    if (isset($_SESSION['msg'])){
        echo '<p style="color:red">'.$_SESSION['msg'].'</p>';    
    }
    ?>

</body>
</html>