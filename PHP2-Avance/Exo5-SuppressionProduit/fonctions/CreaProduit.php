<?php
session_start();
$cleanPost = filter_input_array(INPUT_POST);
$codeArt = $cleanPost['code'];
$designation = $cleanPost['designation'];
$msg = '';
if(file_exists('connect.php')){
    include 'connect.php';
    if($_SESSION['token']===$cleanPost['token']){
        // controle de l'existance ou non du produit en question
        $reqSel = "SELECT code, designation FROM produit where code='$codeArt'";
        $result = $connexion->query($reqSel);
        $lstObjPdt = $result->fetchAll(PDO::FETCH_OBJ);
        if (count($lstObjPdt)==0){
            // avec requete préparée : l'insertion fonctione bien mais je n'arrive pas à exploiter le retour //
            $reqPrepIns = $connexion->prepare("INSERT INTO produit (`code`, `designation`) VALUES (:codeArt, :designation)");
            $reqPrepIns->execute(array(':codeArt'=>$codeArt, ':designation'=>$designation));
            if ($reqPrepIns->rowCount()>0){
                $msg='Produit '.$designation .' bien créé';
            }else{
                $msg='un problème est survenu à la création de l\'article';
            }
        }else{
            $msg="un produit existait déjà avec cette meme référence, essayer avec une référence (code) différent";
        }
    }else{ // cas d'appel non reconnu
        $msg='Tentative d\'attaque !! ';
    }
}else{ // si le fichier de connexion n'est pas présent
    $msg="le fichier permettant la connexion à la base n'est pas présent";
}

if ($msg==''){$msg='Cas non prévu, merci de nous contacter ;-) ';}

$_SESSION['msg']= $msg;
header('Location: ../index.php'); 
?>