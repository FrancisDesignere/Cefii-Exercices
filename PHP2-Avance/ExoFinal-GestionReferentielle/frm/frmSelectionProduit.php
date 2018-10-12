<?php 
if($page=='DelPdt'){
    $legend = ' Selectionez un article à supprimer ';
    $btnText = 'Supprimer';
    $action = './fonctions/DeleteProduit.php';
}else{
    $legend = ' Selectionez un article à modifier ';    
    $btnText = 'Modifier';
    $action = './fonctions/GetObjProduit.php';
}
?>

    <!-- formulaire de choix de l'article -->
    <fieldset>
        <legend><?php echo $legend?></legend>
        <form id="formChoixArt" action="<?php echo $action;?>" method="POST">
            <ul>
                <li>                    
                    <label for="ChoixProduit">Référence : nom </label>
                    <select id="ChoixProduit" name="idproduits" required>
                        <option value="" ></option>
                        <?php // la construction des options correspondant à chaque article en base
                        $paramList='option';
                        include 'fonctions/GetListProduits.php';
                        ?>
                    </select>
                </li><li>
                    <label for="validChoixArt"></label>
                    <input type="hidden" name="token" value="<?php echo $token;?>">
                    
                    <input id="validChoixArt" type="submit" value="<?php echo $btnText;?>" class="btn_form">
                </li>
            </ul>
        </form>
        <span class="note">Nombre d'article(s) éxistant(s) : <?php echo $_SESSION['nbArt'];?></span>
    </fieldset>