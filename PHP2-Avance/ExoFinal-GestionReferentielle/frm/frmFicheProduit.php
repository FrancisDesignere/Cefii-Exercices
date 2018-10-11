<?php

if ($page=='AddPdt'){
    unset($objArt);
}else{
    if (isset($_SESSION['idArtEnCours'])){
    $objArt= getItemById($_SESSION['idArtEnCours']);
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
                            echo '<input id="idArtModif" class="bloque" name="id" type="text" disabled value="'; if (isset($objArt)){echo $objArt->id;} echo '"> ';
                        }
                        ?>
                    </li><li>
                        <label for="codeArtModif"> code article* :</label>
                        <input id="codeArtModif" class="bloque" name="code" type="text" <?php if ($page=='AddPdt'){echo 'required';}else{echo 'readonly';}?> value="<?php if (isset($objArt)){echo $objArt->code;}?>"> 
                    </li><li>
                        <label for="designArtModif">désignation* :</label>
                        <textarea cols="20" rows="3" id="designArtModif" name="designation" required  maxlength=50><?php if (isset($objArt)){echo $objArt->designation;}?></textarea> 
                    </li><li>
                        <label for="PuArtModif">Prix Unitaire : </label>
                        <input id="PuArtModif" name="pu" type="text" maxlength=5 size=6 value="<?php if (isset($objArt)){echo $objArt->prixUnitaire;}?>"> 
                    </li><li>
                        <label for="madeInArtModif"> Made in : </label>
                        <input id="madeInArtModif" name="madeIn" type="text" maxlength=100 size=25 value="<?php if (isset($objArt)){echo $objArt->madeIn;}?>"> 
                    </li><li>
                        <input type="hidden" name="token" value="<?php echo $token;?>">
                        <input id="validModifArt" type="submit" value="valider" class="btn_form">
                    </li>
                </ul>
            </form>
    </fieldset>
