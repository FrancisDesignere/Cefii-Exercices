    <fieldset>
        <legend>liste des fournisseurs existants</legend>
        <div id='listDel'>
            <?php // la construction des options correspondant à chaque article en base

            $msg='';
            $lstObjFrn = getAllSuppliers();
            $_SESSION['nbFrn']= count($lstObjFrn);
            foreach($lstObjFrn as $OneFrn){
                echo '<div id="Item'.$OneFrn->idfournisseurs.'" class="divItem">';
                    // un form uniquement pour le bouton modification
                    echo '<form class="frmUpdt" id="frmUpdt'.$OneFrn->idfournisseurs.'" action="index.php" method="POST">';
                        echo '<input type="hidden" name="idfournisseurs" value="'.$OneFrn->idfournisseurs.'">';
                        echo '<input type="hidden" name="page" value="UpdtFrn">';
                        echo '<input type="hidden" name="token" value="'.$token.'">';
                        echo '<input class="btnUpdt" id="validModifArt" type="submit" value="" title="modifier" >';
                    echo '</form>';
                    // un form pour le libellé et l'action suppression
                    echo '<form class="frmdel" id="frmDel'.$OneFrn->idfournisseurs.'" action="fonctions/DeleteFournisseur.php" method="POST">';
                        echo '<input id="imputDel'.$OneFrn->idfournisseurs.'" class="bloque" name="societe" type="text" disabled value="'.$OneFrn->societe.' ('.$OneFrn->produit.')"> ';
                        echo '<input type="hidden" name="idfournisseurs" value="'.$OneFrn->idfournisseurs.'">';
                        echo '<input type="hidden" name="token" value="'.$token.'">';
                        echo '<input class="btnDel" id="validDelFrn" type="submit" value="" title="supprimer" >';
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
        <span class="note">Nombre de fournisseurs(s) existant(s) : <?php echo $_SESSION['nbFrn'];?></span>
    </fieldset>
