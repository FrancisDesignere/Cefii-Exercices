<?php
session_start();

    use PHPMailer\PHPMailer\PHPMailer; // alias des namespace de PHPMailer
    use PHPMailer\PHPMailer\Exception;
    require './PHPMailer/src/PHPMailer.php'; // inclusion de PHPMailer
    require './PHPMailer/src/Exception.php';
 
    $cleanPost = filter_input_array(INPUT_POST);
    $msg='';

    
    if($_SESSION['token']===$cleanPost['token']){
  
        $mailDest = $cleanPost['email'];
        $mail = new PHPMailer(); /* instanciation d'un objet PHPMailer dans la variable mail */
        // On ajoute à l'instance $mail les infos récupérées via le post
        $mail->CharSet = 'utf-8';
        $mail->From ='francis.designere@gmail.net';
        $mail->FromName =$cleanPost['nom']." ".$cleanPost['prenom']; //$mail->FromName =utf8_encode($cleanPost['nom'])." ".utf8_encode($cleanPost['prenom']) ;
        $mail->Subject ='Exercice6-PHPMailer';
        // gestion du cas du message vide et passage en html
        $body = $cleanPost['msg'];

        // ajout de l'adresse avec ou sans le nom suivant le cas
        if ($cleanPost['nom']<>""){
            $mail->addAddress($mailDest,$cleanPost['nom']);
        }else{
            $mail->addAddress($mailDest);
        }
        $mail->addAddress($cleanPost['email'],$cleanPost['nom']);
        
        // gestion de la pièce jointe 
        if (isset($_FILES['pj']) && ($_FILES['pj']['error'] == 0)){
            $fichier = $_FILES['pj']['name'];
            $chemin = $_FILES['pj']['tmp_name'];
            $body .= '<br> voir pièce jointe '. $fichier .'. Poids en ko : '. $_FILES['pj']['size']/1000;
            $mail->AddAttachment($chemin, $fichier);
        }

        // gestion du corps du mail        
        if ($body==""){$body=$mailDest.' Vous envoi un mail vide...';}
        $body = str_replace(chr(10), '<br>', $body);                
        $mail->MsgHTML($body);
        
        try{
            $msg='Le message a bien été envoyé';
            // on tente l'envoi du mail
            $mail->Send();
        }
        catch(Exception $err){
            $msg= 'message non envoyé <br>';
            $msg.= 'Erreur : '. $mail->ErrorInfo;
        }
    }
    
    // on retourne sur la page d'index
    $_SESSION['msg']= $msg;
    header('Location: ./index.php'); 
?>
