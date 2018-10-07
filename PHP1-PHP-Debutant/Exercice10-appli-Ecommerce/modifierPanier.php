<?php
session_start();
$cleanGet= filter_input_array(INPUT_GET);
if (!isset($_SESSION['nombreArticlePanier'])){
    $_SESSION['nombreArticlePanier'] = 1;
}else{
    ++$_SESSION['nombreArticlePanier'];
}
if ($cleanGet['vider']=='1'){
    initPanier();
}
if (isset($cleanGet['idProduit'])){
    switch ($cleanGet['idProduit']){
        case 1:
            $_SESSION['nbreArt1']++;
            break;
        case 2:
            $_SESSION['nbreArt2']++;
            break;
        case 3:
            $_SESSION['nbreArt3']++;
            break;
        case 4:
            $_SESSION['nbreArt4']++;
    }
}

function initPanier(){
    $_SESSION['nombreArticlePanier'] = 0;
    $_SESSION['nbreArt1'] = 0;
    $_SESSION['nbreArt2'] = 0;
    $_SESSION['nbreArt3'] = 0;
    $_SESSION['nbreArt4'] = 0;
}
//var_dump($cleanGet);
header('location:index.php');
 
?>