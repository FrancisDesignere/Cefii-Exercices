<!DOCTYPE HTML>
<html>
<head>
    <title>Module PHP-Debutant - Exo2 - Francis Désignère</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="fr" />
</head>
<body>
    <?php
        // définition des variables et constante
        $prenom = "Francis";
        define ("ECOLE","CEFii");
        $annee_en_cours = date("Y");
        const ANNEE_NAISSANCE = 1966;
        
        // affichage des informations 
        echo "Je m'appelle $prenom <br/>";
        echo "Je suis en formation au " . ECOLE . "<br/>";
        echo "J'ai " . ($annee_en_cours-ANNEE_NAISSANCE) ." ans <br/>";
    ?>
</body>
</html>

