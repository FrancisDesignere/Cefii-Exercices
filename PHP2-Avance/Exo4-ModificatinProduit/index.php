<?php 
session_start();
$_SESSION['nbArt']=0;
$token= bin2hex(random_bytes(24));
$_SESSION['token']=(string)$token;
require './fonctions/functions.php';

?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>PHP2-Exercice4 modification d'Article</title>
    <link rel="stylesheet" href="css/styleFormulaire.css" />
</head>
<body>
    <h1>PHP2-Exercice4 modification d'Article</h1>
    <hr>
    <!-- formulaire de choix de l'article -->
    <fieldset>
        <legend>Selectionez un article à modifier</legend>
        <form id="formChoixArt" action="fonctions/GetObjProduit.php" method="POST">
            <ul>
                <li>                    
                    <label for="codeChoixModif">code</label>
                    <select id="codeChoixModif" name="code" required>
                        <option value="" ></option>
                        <?php // la construction des options correspondant à chaque article en base
                        include 'fonctions/GetListOptionProduits.php';
                        ?>
                    </select>
                </li><li>
                    <input type="hidden" name="token" value="<?php echo $token;?>">
                    <input id="validChoixArt" type="submit" value="valider" class="btn_form">
                </li>
            </ul>
        </form>
        <span class="note">Nombre d'article(s) éxistant(s) : <?php echo $_SESSION['nbArt'];?></span>
    </fieldset>
    <?php 
    if ($_SESSION['nbArt']==0){
        $_SESSION['msg']='la table produit est vide, crééz donc les premiers produits';
        // inclusion d'un formulaire de création s'il n'existe aucun n'article
        include './frmCreaArt.php';
    }else{
        // inclusion d'un formulaire du formulaire de Modification d'article
        if (isset($_SESSION['idArtEnCours'])){
            include './frmModifArt.php';
        }
    }
    
    // affichage du message passée en session par le traitement concerné
    echo '<p style="color:red">'.$_SESSION['msg'].'</p>';

?>    
</body>
</html>