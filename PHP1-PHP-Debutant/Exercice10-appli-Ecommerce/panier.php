<?php
session_start();
if (empty($_SESSION)){
    header('location:modifierPanier.php?vider=1');
}

$article1 = array('Disque dur 500 Go',$_SESSION['nbreArt1']);
$article2 = array('Disque dur 500 Go SSD',$_SESSION['nbreArt2']);
$article3 = array('Disque dur 1 To',$_SESSION['nbreArt3']);
$article4 = array('Disque dur 1 To SSD',$_SESSION['nbreArt4']);
echo'<hr>';
/*
if($_SESSION['nbreArt1']>0){echo 'Disque dur 500 Go quantité = '.$_SESSION['nbreArt1'].'<br>';}
if($_SESSION['nbreArt2']>0){echo 'Disque dur 500 Go SSD quantité = '.$_SESSION['nbreArt2'].'<br>';}
 */


if($article1[1]>0){echo $article1[0].' quantité = '.$article1[1].'<br>';}
if($article2[1]>0){echo $article2[0].' quantité = '.$article2[1].'<br>';}
if($article3[1]>0){echo $article3[0].' quantité = '.$article3[1].'<br>';}
if($article4[1]>0){echo $article4[0].' quantité = '.$article4[1].'<br>';}
echo '<hr>';
echo 'Nombre d\'article total dans le panier : '.$_SESSION['nombreArticlePanier'].'<br>';
if ($_SESSION['nombreArticlePanier'] > 0){
    echo '<a href="modifierPanier.php?vider=1" id="initPanier">vider le panier</a>';
}
?>
