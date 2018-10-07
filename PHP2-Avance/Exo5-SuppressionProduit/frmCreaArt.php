    <fieldset>
        <legend>Création simplifiée d'un produit</legend>
        <form id="formCreaArt" action="fonctions/CreaProduit.php" method="POST">
            <ul>
                <li>
                    <label for="codeArtCrea"> code article* : </label><input id="codeArtCrea" name="code" type="text" placeholder="5 car max" required maxlength=5 size=6>
                </li><li>
                    <label for="designArtCrea">désignation* :</label>
                    <textarea cols="20" rows="3" id="designArtCrea" name="designation" required maxlength=50></textarea>
                </li><li>
                    <input type="hidden" name="token" value="<?php echo $token;?>">
                    <input id="validArtCrea" type="submit" value="valider" class="btn_form">                    
                </li>
            </ul>
        </form>        
    </fieldset>
