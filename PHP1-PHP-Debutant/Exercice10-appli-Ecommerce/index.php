<?php //session_start(); ?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
    <title>Exercice 10 appli e-commerce</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
    <h2>&Agrave; ma zone</h2>
    <div id="listPdt">
        <h3>liste de produit</h3>
        <table id="tblListPdt">
            <tr><th>libellé article</th><th>prix</th><th>ajout au pannier</th></tr>
            <tr><td>Disque du 500 Go</td><td>100 €</td><td><a href="modifierPanier.php?idProduit=1" id="ajoutArt1">Ajouter</a></td></tr>
            <tr><td>Disque du 500 Go SSD</td><td>120 €</td><td><a href="modifierPanier.php?idProduit=2" id="ajoutArt2">Ajouter</a></td></tr>
            <tr><td>Disque du 1 To</td><td>150 €</td><td><a href="modifierPanier.php?idProduit=3" id="ajoutArt3">Ajouter</a></td></tr>
            <tr><td>Disque du 1 To SSD</td><td>180 €</td><td><a href="modifierPanier.php?idProduit=4" id="ajoutArt4">Ajouter</a></td></tr>
        </table>
    </div>
    <div id="panier">
        <h3>Panier</h3>
<?php
    include 'panier.php';
?>
    </div>
</body>
</html>
