<!DOCTYPE HTML>
<html lang="fr">
<head>
    <title>Exo7 - Module PHP-Debutant - Francis Désignère</title>
    <meta charset="UTF-8" />
</head>
<body>
    <?php
         
        // ===  main ====
        $texte = "Rendez-vous au CEfii, l'école du numérique";
        $positionLien = 3;
        $lienURL = "http://www.cefii.fr/";        
        echo formatText($texte,$positionLien,$lienURL);
        
        // === fonction ===
        function formatText($pTexte, $pPos, $pURL){
            // on met la chaine dans un tableau des mots qui la compose
            $tabText = explode(" ",$pTexte);
            // gestion des positions en dehors du nombre de mots 
            $pPos=min($pPos,count($tabText));
            $pPos=max($pPos,1);
            // on décrémente le paramètre pour correspondre à l'index du tableau
            --$pPos;
            // remplacement du mot de la position demandé par le lien 
            $tabText[$pPos] =  "<a href='".$pURL."' target='_blank'>".$tabText[$pPos]."</a> ";
            
            // on retourne la chaine reconstruite par implode
            return implode(" ",$tabText);;
        } 
    ?>
</body>
</html>