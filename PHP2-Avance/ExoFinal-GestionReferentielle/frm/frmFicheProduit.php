<?php

if ($page=='AddPdt'){
    unset($objArt);
    $objArtFrn= getItemSuppliers();
}else{
    if (isset($_SESSION['idArtEnCours'])){
        $objArt= getItemById($_SESSION['idArtEnCours']);
        $objArtFrn= getItemSuppliers($_SESSION['idArtEnCours']);
    }
}
?>

<!-- formulaire de saisie des modifications de l'article -->
    <fieldset>
        <legend>Saisisser les nouvelles valeurs de votre fiche article</legend>
            <form id="formModifArt" action="fonctions/ModifProduit.php" method="POST">
                <ul>
                    <li>
                        <?php
                        if($page!='AddPdt'){
                            echo '<label for="idArtModif"> identifiant interne : </label>';
                            echo '<input id="idArtModif" class="bloque" name="idproduits" type="text" disabled value="'; if (isset($objArt)){echo $objArt->idproduits;} echo '"> ';
                        }
                        ?>
                    </li><li>
                        <label for="refArtModif"> référence * :</label>
                        <input id="refArtModif" class="bloque" name="reference" maxlength=20 type="text" <?php if ($page=='AddPdt'){echo 'required';}else{echo 'readonly';}?> value="<?php if (isset($objArt)){echo $objArt->reference;}?>"> 
                    </li><li>
                        <label for="nomArtModif"> Nom * : </label>
                        <input id="nomArtModif" name="nom" required type="text" maxlength=45 size=25 value="<?php if (isset($objArt)){echo $objArt->nom;}?>"> 
                    </li><li>
                        <label for="designArtModif">commentaire :</label>
                        <textarea cols="20" rows="3" id="designArtModif" name="pdt_commentaire"  maxlength=500><?php if (isset($objArt)){echo $objArt->pdt_commentaire;}?></textarea> 
                    </li><li>
                        <label for="qteArtModif">Quantité en stock : </label>
                        <input id="qteArtModif" name="qte" type="number" maxlength=5 size=6 value="<?php if (isset($objArt)){echo $objArt->quantite;}?>"> 
                    </li><li>
                        <label>Fournisseur(s) du produit <br> (touche Ctrl pour multiselection)</label>
                        <select name="frnPdt[]" multiple size="4">
                            <?php
                                foreach($objArtFrn as $frn){
                                    if ($frn->idproduits!==null){$selected='selected';}else{$selected='';};
                                    echo '<option value="'.$frn->idfournisseurs.'" '.$selected.'>'.$frn->societe.'</option>';
                                }
                            ?>
                        </select
                     </li><li>
                            <input type="hidden" name="token" value="<?php echo $token;?>">
                            <input id="validModifArt" type="submit" value="valider" class="btn_form">      
                    </li>
                </ul>
            </form>
    </fieldset>
