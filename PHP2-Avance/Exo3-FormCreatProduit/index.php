<?php 
session_start();
$token= bin2hex(random_bytes(24));
$_SESSION['token']=(string)$token;
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
    <title>PHP2-Exercice3 Creation Article</title>
    <meta charset="UTF-8" />
</head>
<body>
    <h1>Création d'un nouveau produit</h1>
    <form action="CreaProduit.php" method="POST">
        <label for="code"> code article* : </label><input id="code" name="code" type="text" placeholder="5 car max" required maxlength=5 size=6><br> 
        <label for="designation">désignation* :</label><br>
        <textarea cols="20" rows="3" id="designation" name="designation" required maxlength=50></textarea>
        <input type="hidden" name="token" value="<?php echo $token;?>"><br>
        <input id="validate" type="submit" value="Valider" >
    </form>
    <hr>

<?php
    // récupération du retour éventuel du script traitement.php
    $cleanGet = filter_input_array(INPUT_GET);
    if (isset($cleanGet['msg'])){
        echo '<p style="color:red">'.$cleanGet['msg'].'</p>';
    }
?>
</body>
</html>