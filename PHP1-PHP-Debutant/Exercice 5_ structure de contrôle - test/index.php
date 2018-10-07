<!DOCTYPE HTML>
<html lang="fr">
<head>
    <title>Exo5 - Module PHP-Debutant - Francis Désignère</title>
    <meta charset="UTF-8" />
</head>
<body>
    <?php
        $heureAlea = mt_rand(0,24);
        echo "il est $heureAlea h<br>";
        if ($heureAlea<12){
            echo "matin";
        }else{
            echo "après midi";
        }
    ?>
</body>
</html>
