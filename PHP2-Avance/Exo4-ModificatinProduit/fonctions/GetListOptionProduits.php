<?php
$msg = '';
//$lstOptPdt='';

if($_SESSION['token']=== $token){
    
    // on rempli $lstObjPdt par appel de la liste de tous les articles par la fonction getAllItems
    $lstObjPdt = getAllItems();
    
    $_SESSION['nbArt']= count($lstObjPdt);
    foreach($lstObjPdt as $objPdt){
        echo '<option value="'.$objPdt->code.'">'.$objPdt->code .' | ' .$objPdt->designation.'</option>' ;
    }
    
}else{ // cas d'appel non reconnu
    $msg='Tentative d\'attaque !! ';
}
$_SESSION['msg'].= $msg;
?>