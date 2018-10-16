<?php 
session_start();

$token= bin2hex(random_bytes(24));
$_SESSION['token']=(string)$token;
require './fonctions/functions.php';

// récupération et filtrage des données provenant des get et post
// (les appels en provenance du menu sont passés en get, ceux provenant des formulaires en post)
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
// de meme pour le fournisseur
if (isset($cleanPost['idfournisseurs'])){
    $idFrnEnCours=$cleanPost['idfournisseurs'];
    $_SESSION['idFrnEnCours']=$idFrnEnCours;
}

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
        if($page=='ListePdts'){ 
            /* correspond au menu "Produits", propose une liste des produits avec 
            leur réf et nom, accompagné de bouton pour modifier ou supprimer chaque article*/
            include('./frm/frmListProduits.php');
            
        }elseif($page=='AddPdt'){ 
            /* correspond au menu "Produits/Ajouter", propose 
             * une fiche produit vierge (sans montrer le champ id interne)
             *   (avec un liste des fournisseurs (ordre alpha) permettant le rattachement au fournisseur) */
            include('./frm/frmFicheProduit.php');
            
        }elseif($page=='UpdtPdt'){ 
            /* correspond au menu "Produits/Modifier", propose 
             * une liste déroulante pour selectionner l'article (et un bouton valider)
             * la fiche fiche produit affichant les infos actuelles de l'article (
             *   (la liste de fournisseur est alors classée avec en premier les fournisseurs rattachés aux produit) */
            include('./frm/frmSelectionProduit.php');
            include('./frm/frmFicheProduit.php');
            
        }elseif($page=='DelPdt'){
            /* correspond au menu "Produit/supprimer", propose 
             la liste déroulante de selection d'article (avec un boton supprimer) */
            include('./frm/frmSelectionProduit.php');
            
        }elseif($page=='ListFrns'){
            /* correspond au menu "Fournisseur", propose une liste des fournisseur avec 
            le nom de la société ainsi qu'une info sur leur produits rattachés.
            Liste accompagnée de bouton pour modifier ou supprimer chaque fournisseur*/            
            include('./frm/frmListFournisseurs.php');
            
        }elseif($page=='AddFrn'){
            /* correspond au menu "Fournisseur/Ajouter", propose 
             * une fiche fournisseur vierge (sans montrer le champ id interne)
             *   (avec un liste des produits (ordre alpha) permettant le rattachement au fournisseur) */            
            include('./frm/frmFicheFournisseur.php');
            
        }elseif($page=='UpdtFrn'){
            /* correspond au menu "Fournisseur/Modifier", propose 
             * une liste déroulante pour selectionner le fournisseur(et un bouton valider)
             * la fiche fiche produit affichant les infos actuelles de l'article (
             *   (la liste de fournisseur est alors classée avec en premier les fournisseurs rattachés aux produit) */            
            include('./frm/frmSelectionFrounisseur.php');
            include('./frm/frmFicheFournisseur.php');   
            
        }elseif($page=='DelFrn'){
            /* correspond au menu "Fournisseur/supprimer", propose 
             la liste déroulante de selection de fournisseur (avec un boton supprimer) */
            include('./frm/frmSelectionFrounisseur.php');
 
        }else{  // en théorie pas de raison de passer ici si le cas se produit, on affiche la liste de produit
            include './frm/frmFicheProduit.php';
        }

    // affichage du message passée en session par le traitement concerné
    if (isset($_SESSION['msg'])){
        echo '<p style="color:red">'.$_SESSION['msg'].'</p>';    
    }
    ?>

</body>
</html>