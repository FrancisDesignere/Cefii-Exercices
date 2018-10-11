<?php 
session_start();
$_SESSION['nbArt']=0;
$token= bin2hex(random_bytes(24));
$_SESSION['token']=(string)$token;
require './fonctions/functions.php';
$cleanGet = filter_input_array(INPUT_GET);
// on récupère la page demandée, qu'elle provienne du get ou de la variable en session
if (isset($cleanGet['page'])){
    $page=$cleanGet['page'];
    $_SESSION['page']=$page;
}elseif (isset($_SESSION['page'])){
    $page=$_SESSION['page'];
}else{
    $page='ListePdts';
}
// on récupère la page demandée, qu'elle provienne du get ou de la variable en session
if (isset($cleanGet['id'])){
    $idItem=$cleanGet['id'];
    $_SESSION['idArtEnCours']=$idItem;
}
echo '<br>' .$page;/////
//var_dump($_GET);////
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

        // inclusion des pages correspondant à la page demandée en GET
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
            //// à voir (on pourrait mettre une petite présentation ////
            echo 'on passe dans le cas sans GET[page] ';
            // gestion du cas où il la table produits est vide (ou presque), pour proposer la création d'article
            if ($_SESSION['nbArt']<3){
                $_SESSION['msg']='la table produit est comme vide, crééz donc des premiers produits';
                // inclusion d'un formulaire de création s'il n'existe aucun n'article
                include './frm/frmFicheProduit.php';
            }
        }

    // affichage du message passée en session par le traitement concerné
    if (isset($_SESSION['msg'])){
        echo '<p style="color:red">'.$_SESSION['msg'].'</p>';    
    }
    ?>

</body>
</html>