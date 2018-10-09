    <div class="bloc_formulaire">
        <form action="./traitement.php" method="POST" enctype="multipart/form-data">
            <ul>
                <li>
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" placeholder="Le nom du destinataire">
                </li>
                <li>
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" placeholder="Le prénom du destinataire">
                </li>
                <li>
                    <label for="email">Email* : (du destinataire) </label>
                    <input type="email" id="email" name="email" required placeholder="XXX@YYY.ZZ">
                </li>
                <li>
                    <label for="msg">Votre message* :</label>
                    <textarea cols="32" rows="7" id="msg" name="msg">Bonjour,

Voici mon message : </textarea>
                </li>
                <li>
                    <label for="pj">Pièce jointe :</label>
                    <input type="file" id="pj" name="pj" >
                </li>
                <li>
                    <label for="submit"></label>
                    <input class="btn_form" type="reset" id="reset" value="Effacer">
                    <input class="btn_form" type="submit" id="submit" value="Valider">
                </li>
                <input type="hidden" name="token" value="<?php echo $token;?>">
            </ul>
        </form>
    </div>
