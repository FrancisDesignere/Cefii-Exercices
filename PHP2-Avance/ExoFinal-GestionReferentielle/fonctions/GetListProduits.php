<?php
// page appelée par include, pour construire l'html de chaque produit
// suivant le cas, il s'agit de :
// - construire des balise <option> (pour remplir un <select>
// - construire des formulaires avec bouton de delete
// les cas sont distingué par la variable $paramList 
//    qui prend les valeur 'option' ou 'frmsDelete'
$msg = '';

if($_SESSION['token']=== $token){
   
    // on rempli $lstObjPdt par appel de la liste de tous les articles par la fonction getAllItems
    $lstObjPdt = getAllItems();
    $_SESSION['nbArt']= count($lstObjPdt);
    
    foreach($lstObjPdt as $objPdt){
        $codePad = str_pad($objPdt->code,5).' | '; // cette variable acceuil une versio paddée du code sur 5 digit (pour l'alignement)
        
        if ($paramList=='option'){
            // écriture des options du select html, suivant le modèle                         
            // <option value="parcour1" >Réserver un parcour1</option>
                echo '<option value="'.$objPdt->id.'">'.$codePad .$objPdt->designation.'</option>' ;

        }elseif ($paramList=='frmsDelete') {
            // écriture de fomulaires avec description et bouton poubelle pourr chaque articles
            //         <form id="formChoixArt" action="fonctions/GetObjProduit.php" method="POST">
            echo '<div id="Item'.$objPdt->id.'" class="divItem">';
                // un form uniquement pour le bouton modification
                echo '<form class="frmUpdt" id="frmUpdt'.$objPdt->id.'" action="index.php" method="GET">';
                    echo '<input type="hidden" name="id" value="'.$objPdt->id.'">';
                    echo '<input type="hidden" name="page" value="UpdtPdt">';
                    echo '<input type="hidden" name="token" value="'.$token.'">';
                    echo '<input class="btnUpdt" id="validModifArt" type="submit" value="" title="modifier" >';
                echo '</form>';
                // un form pour le libellé et l'action suppression
                echo '<form class="frmdel" id="frmDel'.$objPdt->id.'" action="fonctions/DeleteProduit.php" method="POST">';
                    echo '<input id="imputDel'.$objPdt->id.'" class="bloque" name="code" type="text" disabled value="'.$codePad.$objPdt->designation.'"> ';
                    echo '<input type="hidden" name="id" value="'.$objPdt->id.'">';
                    echo '<input type="hidden" name="token" value="'.$token.'">';
                    echo '<input class="btnDel" id="validModifArt" type="submit" value="" title="supprimer" >';
                echo '</form>';

            echo '</div>';
        }else{
            $msg="l'option précisée pour définir la liste n'est pas définie";
        }
    }

}else{ // cas d'appel non reconnu
    $msg='Tentative d\'attaque !! ';
}

if (isset($_SESSION['msg'])){
    $_SESSION['msg'].= $msg;
}else{
    $_SESSION['msg']= $msg;
}

?>