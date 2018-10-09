<?php 
session_start();
//$token = rand(0,9999);
$token= bin2hex(random_bytes(24));
$_SESSION['token']=(string)$token;
if (!isset($_SESSION['msg'])){$_SESSION['msg']='';}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Exercice PHP2-EnvoiMail PHPMailer</title>
    <link rel="stylesheet" href="css/styleFormulaire.css" /> 

</head>

<body>
    <h1>formulaire d'envoi de mail</h1>
    <?php include './formulaire.php'; 
    
    // affichage du message passée en session par le traitement concerné
    echo '<br><p style="color:red">'.$_SESSION['msg'].'</p>';
//    echo '<div>'.$_SESSION['msg'].'</div>';
    $_SESSION['msg']='';

    ?>
</body>
</html>
