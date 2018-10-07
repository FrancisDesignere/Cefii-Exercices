<?php
session_start();
$cleanPost = filter_input_array(INPUT_POST);
$msg = '';

if((sizeof($cleanPost)==6 || sizeof($cleanPost)==7) && ($_SESSION['token']===$cleanPost['token'])){  // ne passe pas la condition si provient d'un formulaire différent
    if($cleanPost['cp'] <> "" && $cleanPost['tel']<> ""){
        $carToDel = array('.','-',' ');
        $pTel = str_replace($carToDel, '', $cleanPost['tel']);
        $bCpOK = ctrlNumLong($cleanPost['cp'],5);
        $bTelOk = ctrlNumLong($pTel,10);
        if (!$bCpOK){$msg = 'le code postal doit être numérique et faire 5 caractères<br>';}
        if (!$bTelOk){$msg .='le numéro de tél doit être numérique et faire 10 caractères<br>';}
        if ($bTelOk && $bCpOK){
            $msg = mailConfirm($cleanPost);
        }
    }else{
       $msg='merci de remplir tout les champs obligatoire (*)';
    }
}else{
    $msg='Tentative d\'attaque !! ';
}

if ($msg==''){$msg='Cas non prévu, merci de nous contacter ;-) ';}

//var_dump($_SESSION['token']);
//var_dump($cleanPost['token']);
//echo $msg;
header('Location: index.php?msg='.$msg); 


// ================= fonctions ====================== //
// fonction de controle de champ texte n'admettant 
//    que du numérique 
//    et pour longuer précise
// ---------------------------------------
function ctrlNumLong ($pNum2ctrl, $pNbCar){
    $ctrlOK = false;
//    $sNum = (string)$pNum2ctrl;
    if (is_numeric($pNum2ctrl)){
        if (strlen($pNum2ctrl) == $pNbCar){
            $ctrlOK = true;
        }
    }
    return $ctrlOK;
}
// ---------------------------------------
// fonction d'envoi du mail de confirmation
//  ---------------------------------------
function mailConfirm($pInputs){
    $msgMail='';

    // nettoyage des saut de ligne dans le message provenant du textarea
    $cleanMessage = str_replace(chr(13), '', $pInputs['msg']);
    $car2conv = array(chr(10));
    $cleanMessage = str_replace($car2conv, '\n', $cleanMessage);        

    $dest = 'francis.designere@gmail.com';
    $objet = 'confirmation de réception de votre message';
    // concaténation du corps de mail (pour connfirmation des infos fournis)
    $corpsMail = 'Bonjour, \n Nous avons bien reçu votre message et tacherons d\'y répondre au plus vite \n';
    $corpsMail .= 'Ci dessous, un récapitulatif de votre message : \n';
    $corpsMail .= 'Nom : '.$pInputs['nom'].'\n';
    $corpsMail .= 'Prénom : '.$pInputs['prenom'].'\n';
    $corpsMail .= 'Code postale : '.$pInputs['cp'].'\n';
    $corpsMail .= 'Téléphone : '.$pInputs['tel'].'\n';
    $corpsMail .= 'votre message : \n'.$cleanMessage.'\n';
    
    // un version du corps du mail avec saut ligne html (pour le retour)
    $corpsMailHtml = str_replace('\n', '<br>', $corpsMail);    
    
    // envoi du mai (sauf si mod debug)
    if ($pInputs['debug'] =='on'){
        $msgMail = '<b>Mode debug : controle msg mail</b><br>'. $corpsMailHtml;
    }else{
        $sendMail = mail($dest,$objet,$corpsMail);
        if ($sendMail){
            $msgMail = 'Votre demande a été envoyée <br>'. $corpsMailHtml;
        }else{
            $msgMail = 'votre message ne nous est pas parvenu, merci de le renouveler ultérieurement';
        }        
    }
    return $msgMail;
}
?>