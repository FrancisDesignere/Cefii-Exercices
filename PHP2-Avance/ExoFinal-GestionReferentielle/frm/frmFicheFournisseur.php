<?php
if ($page=='AddFrn'){
    unset($objFrn);
    $objFrnArt= getSupplierItems();
}else{
    if (isset($_SESSION['idFrnEnCours'])){
        $objFrn= getSupplierById($_SESSION['idFrnEnCours']);
        $objFrnArt= getSupplierItems($_SESSION['idFrnEnCours']);
    }else{
        unset($objFrn);
    }
}
?>

<!-- formulaire de saisie des modifications (ou création) de fournisseur -->
    <fieldset>
        <legend>Saisisser les nouvelles valeurs de votre fiche Fournisseur</legend>
            <form id="formModifArt" action="fonctions/ModifFournisseur.php" method="POST">
                <ul>
                    <li>
                        <?php
                        if($page!='AddFrn'){
                            echo '<label for="idFrnModif"> identifiant interne : </label>';
                            echo '<input id="idFrnModif" class="bloque" name="idFournisseur" type="text" disabled value="'; if (isset($objFrn)){echo $objFrn->idfournisseurs;} echo '"> ';
                        }
                        ?>
                    </li><li>
                        <label for="socFrnModif"> Société * :</label>
                        <input id="socFrnModif" class="bloque" name="societe" maxlength=45 type="text" <?php if ($page=='AddFrn'){echo 'required';}else{echo 'readonly';}?> value="<?php if (isset($objFrn)){echo $objFrn->societe;}?>"> 
                    </li><li>
                        <label for="AdrFrnModif"> Adresse : </label>
                        <input id="AdrFrnModif" name="adresse" required type="text" maxlength=45 size=25 value="<?php if (isset($objFrn)){echo $objFrn->adresse;}?>"> 
                    </li><li>
                        <label for="cpFrnModif">Code Postal : </label>
                        <input id="cpFrnModif" name="cp" type="number" maxlength=5 size=6 value="<?php if (isset($objFrn)){echo $objFrn->cp;}?>"> 
                    </li><li>
                        <label for="villeFrnModif"> Ville : </label>
                        <input id="villeFrnModif" name="ville" required type="text" maxlength=45 size=25 value="<?php if (isset($objFrn)){echo $objFrn->ville;}?>"> 
                    </li><li>
                        <label for="commFrnModif">commentaire :</label>
                        <textarea cols="20" rows="3" id="commFrnModif" name="frn_commentaire"  maxlength=500><?php if (isset($objFrn)){echo $objFrn->frn_commentaire;}?></textarea> 
                    </li><li>
                        <label>Produits du Fournisseur <br> (touche Ctrl pour multiselection)</label>
                        <select name="pdtFrn[]" multiple size="4">
                            <?php
                                foreach($objFrnArt as $pdt){
                                    if ($pdt->idfournisseurs!==null){$selected='selected';}else{$selected='';};
                                    echo '<option value="'.$pdt->idproduits.'" '.$selected.'>'.$pdt->nom.'</option>';
                                }
                            ?>
                        </select>
                     </li><li>
                            <input type="hidden" name="token" value="<?php echo $token;?>">
                            <input id="validModifFrn" type="submit" value="valider" class="btn_form">      
                    </li>
                </ul>
            </form>
    </fieldset>
