<?php
session_start();
$cleanPost = filter_input_array(INPUT_POST);
$msg = '';
if ($cleanPost['pu']==''){$cleanPost['pu']=0;}

if(file_exists('connect.php')){
    include 'connect.php';
    if($_SESSION['token']===$cleanPost['token']){
        // controle de l'existance ou non du produit en question
        $strReq = "SELECT code FROM produit where `id`=".$cleanPost['id'];
        $reqQry = $connexion->query($strReq);
        $lstObjPdt =  $reqQry->fetchAll(PDO::FETCH_OBJ);

        if (count($lstObjPdt)==0){
            $msg="Le produit a été supprimé entre temps ?!";
        }else{
            $strReq="UPDATE produit SET `designation` = :designation, ";
            $strReq.="`prixUnitaire` = :pu, ";
            $strReq.="`madeIn` = :madeIn ";
            $strReq.="WHERE `id`= :id";
            $prep = $connexion->prepare($strReq);
            
            $prep->execute(array(':designation'=>$cleanPost['designation'], ':pu'=>$cleanPost['pu'], ':madeIn'=>$cleanPost['madeIn'],':id'=>$cleanPost['id']));

            if ($prep->rowCount()>0){
                $msg='Le produit "'.$cleanPost['designation'] .'" a bien été mis à jour';
                
                // aussi doit on mettre à nouveau le produit en session (avec ses attributs mis à jour)
                // requete de tous les atributs de l'article
                $reqSel = 'SELECT * FROM produit where id = '.$cleanPost['id'];
                $result = $connexion->query($reqSel);
                $ObjPdt = $result->fetchAll(PDO::FETCH_OBJ);
                // on passe l'article trouvé en session
                $_SESSION['Art']= $ObjPdt;                
                
            }else{
                $msg='Le produit n\'a pas été mis à jour (l\'avez vous modifié ?)';
            }
        }
    }else{ // cas d'appel non reconnu
        $msg='Tentative d\'attaque !! ';
    }
}else{ // si le fichier de connexion n'est pas présent
    $msg="le fichier permettant la connexion à la base n'est pas présent";
}

if ($msg==''){$msg='Cas non prévu, merci de nous contacter ;-) ';}
echo $msg;
$_SESSION['msg']= $msg;
header('Location: ../index.php'); 
?>
