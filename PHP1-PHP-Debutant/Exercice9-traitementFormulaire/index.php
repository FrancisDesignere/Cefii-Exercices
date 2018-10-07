<?php 
session_start();
//$token = rand(0,9999);
$token= bin2hex(random_bytes(24));
$_SESSION['token']=(string)$token;
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
    <title>Exercice 9 formulaire</title>
    <meta charset="UTF-8" />
</head>
<body>
    <h1>formulaire de contact</h1>
    <form action="traitement.php" method="POST">
        <label for="nom">Nom : </label><input id="nom" name="nom" type="text" placeholder="votre nom ici"><br> 
        <label for="prenom">Pr&eacute;nom :</label><input id="prenom" name="prenom" type="text" placeholder="votre prénom ici"><br> 
        <label for="cp">Code postal * </label><input id="cp" name="cp" size="5" maxlength="5" type="text" placeholder="24560"><br> <!--type="number"-->
        <label for="tel">Téléphone * </label><input id="tel" placeholder="0123456789" name="tel" type="text" ><br> <!--type="tel"--> 
        <p><label for="msg">Un message ? : </label><br>
        <textarea cols="40" rows="10" id="msg" name="msg" ></textarea></p>
        <label for="debug">Mode debug mail </label><input id="debug" name="debug" type="checkbox" checked><br>
        <input type="hidden" name="token" value="<?php echo $token;?>">
        <input id="validate" type="submit" >
        <input id="reset" type="reset" >
    </form>
<?php
    // récupération du retour éventuel du script traitement.php
    $cleanGet = filter_input_array(INPUT_GET);
    if (isset($cleanGet['msg'])){
        echo '<p style="color:red">'.$cleanGet['msg'].'</p>';
    }
?>
    <!-- Un formulaire 'non conforme' pour tests -->
    <hr>
    <h5>formulaire non conforme (pour test control)</h5>
    <form action="traitement.php" method="POST">
        <label for="nom">Nom : </label><input id="nom1" name="nom" type="text" placeholder="votre nom ici"><br> 
        <label for="prenom">Pr&eacute;nom :</label><input id="prenom" name="prenom" type="text" placeholder="votre prénom ici"><br> 
        <label for="cp">Code postal * </label><input id="cp" name="cp" size="5" maxlength="5" type="text" placeholder="24560"><br> <!--type="number"-->
        <label for="tel">Téléphone * </label><input id="tel" placeholder="0123456789" name="tel" type="text" ><br> <!--type="tel"--> 
        <p><label for="msg">Un message ? : </label><br>
        <textarea cols="40" rows="10" id="msg" name="msg" ></textarea></p>
        <label for="debug">Mode debug mail </label><input id="debug" name="debug" type="checkbox" checked><br>
        <input type="hidden" name="token" value="mauvais token">
        <input id="validateVide" type="submit" >
    </form>
    
</body>
</html>
