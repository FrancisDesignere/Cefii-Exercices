    <fieldset>
        <legend>liste des articles existants</legend>
        <span class="note">Nombre d'article(s) éxistant(s) : <?php echo $_SESSION['nbArt'];?></span>
        <div id='listDel'>
            <?php // la construction des options correspondant à chaque article en base
//            $paramList='frmsDelete';
//            include 'fonctions/GetListProduits.php';
            $msg='';
            $lstObjPdt = getAllItems();
            $_SESSION['nbArt']= count($lstObjPdt);
            foreach($lstObjPdt as $objPdt){
                echo '<div id="Item'.$objPdt->idproduits.'" class="divItem">';
                    // un form uniquement pour le bouton modification
                    echo '<form class="frmUpdt" id="frmUpdt'.$objPdt->idproduits.'" action="index.php" method="POST">';
                        echo '<input type="hidden" name="idproduits" value="'.$objPdt->idproduits.'">';
                        echo '<input type="hidden" name="page" value="UpdtPdt">';
                        echo '<input type="hidden" name="token" value="'.$token.'">';
                        echo '<input class="btnUpdt" id="validModifArt" type="submit" value="" title="modifier" >';
                    echo '</form>';
                    // un form pour le libellé et l'action suppression
                    echo '<form class="frmdel" id="frmDel'.$objPdt->idproduits.'" action="fonctions/DeleteProduit.php" method="POST">';
                        echo '<input id="imputDel'.$objPdt->idproduits.'" class="bloque" name="reference" type="text" disabled value="'.$objPdt->reference.' : ' .$objPdt->nom.'"> ';
                        echo '<input type="hidden" name="idproduits" value="'.$objPdt->idproduits.'">';
                        echo '<input type="hidden" name="token" value="'.$token.'">';
                        echo '<input class="btnDel" id="validModifArt" type="submit" value="" title="supprimer" >';
                    echo '</form>';
                echo '</div>';
            }
            if (isset($_SESSION['msg'])){
                $_SESSION['msg'].= $msg;
            }else{
                $_SESSION['msg']= $msg;
            }
            
            ?>    
        </div>
    </fieldset>
