<?php
session_start();
$cleanPost = filter_input_array(INPUT_POST);
$codeArt = $cleanPost['code'];
$designation = $cleanPost['designation'];
$msg = '';
if(file_exists('connect.php')){
    include 'connect.php';
    if((sizeof($cleanPost)==3) && ($_SESSION['token']===$cleanPost['token'])){
        // controle de l'existance ou non du produit en question
        $reqSel = "SELECT code, designation FROM produit where code='$codeArt'";
        $result = $connexion->query($reqSel);
        $lstObjPdt = $result->fetchAll(PDO::FETCH_OBJ);
        if (count($lstObjPdt)==0){
            // ici, une version avec requete simple et exploitation du retour //
            /*
            $reqIns = "INSERT INTO produit (`code`, `designation`) VALUES ('$codeArt', '$designation')";
            $result=$connexion->exec($reqIns);
            if ($result > 0) {
                $msg= $result." produit(s) créé(s)";
            }else{
                $msg="l'insertion a échouée";
            }
             */
            
            // avec requete préparée : l'insertion fonctione bien mais je n'arrive pas à exploiter le retour //
            $reqPrepIns = $connexion->prepare("INSERT INTO produit (`code`, `designation`) VALUES (:codeArt, :designation)");
            $reqPrepIns->execute(array(':codeArt'=>$codeArt, ':designation'=>$designation));
            /*
            // essai de récupération avec fetch OBj
            $lignes = $reqPrepIns->fetch(PDO::FETCH_OBJ);
            var_dump($lignes); // retourne un booléun false
            // essai de récupération avec fetchAll et tableau assoc
            $result = $reqPrepIns->fetchAll(PDO::FETCH_ASSOC);
            var_dump($result); // retourne un array de size 0
             */
            $msg='Produit '.$designation .' bien créé';
            
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

/* version retour en echo dans page création 
//var_dump($_SESSION['token']);
//var_dump($cleanPost['token']);
echo $msg;*/
/* version retour en echo dans page index*/
header('Location: index.php?msg='.$msg); 
?>