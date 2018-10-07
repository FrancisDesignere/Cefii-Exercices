<!DOCTYPE HTML>
<html lang="fr">
<head>
    <title>Exo6 - Module PHP-Debutant - Francis Désignère</title>
    <meta charset="UTF-8" />
</head>
<body>
    <?php
        // ===  1 etape ====
        echo "1) Affichage de la table de multiplication d'un nombre entre 0 et 100 <br>";
        $entierAlea = mt_rand(0,100);             // affectation nbre aléatoire variable
        for ($cptMult=0;$cptMult<=10;$cptMult++){
            echo $cptMult."*".$entierAlea."=".$cptMult*$cptMult,"<br>";
        }
        
        echo "<hr>";
        // ===  2 etape ====
        echo "2) idem, avec distinction de couleur pour lignes pairs/impaires<br>";
        $color="red";
        for ($cptMult=0;$cptMult<=10;$cptMult++){
            $color=($color=='red')?"":"red";        //changement de la couleur à chaque passage
            echo "<span style='color:$color'>".$cptMult."*".$entierAlea."=".$cptMult*$cptMult,"</span><br>";
        }
    ?>
</body>
</html>
