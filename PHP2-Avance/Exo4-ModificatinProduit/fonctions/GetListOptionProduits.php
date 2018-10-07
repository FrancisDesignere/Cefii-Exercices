<?php
$msg = '';
//$lstOptPdt='';

if($_SESSION['token']=== $token){
    if(file_exists('fonctions/connect.php')){
        include 'fonctions/connect.php';
        // controle de l'existance ou non du produit en question
        $strReq = "SELECT code, designation FROM produit";
        $prep = $connexion->prepare($strReq);
        $prep->execute();
        
        //$result = $connexion->query($reqSel);
        $lstObjPdt = $prep->fetchAll(PDO::FETCH_OBJ);
            
        $_SESSION['nbArt']= count($lstObjPdt);
        if (count($lstObjPdt)==0){
            $msg='la table produit est vide, crééz donc les premiers produits';
        }else{
            // écriture des options du select html, suivant le modèle                         
            // <option value="parcour1" >Réserver un parcour1</option>
            foreach($lstObjPdt as $objPdt){
                echo '<option value="'.$objPdt->code.'">'.$objPdt->code .' | ' .$objPdt->designation.'</option>' ;
            }
        }
    }else{ // si le fichier de connexion n'est pas présent
        $msg="le fichier permettant la connexion à la base n'est pas présent";
    }
}else{ // cas d'appel non reconnu
    $msg='Tentative d\'attaque !! ';
}
$_SESSION['msg'].= $msg;

?>