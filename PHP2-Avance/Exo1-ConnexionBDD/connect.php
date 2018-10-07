<?php
/* suivant le cas :
 * -  à la base de donnée en local 
 * -  ou à celle de F Désignère sur serveur Cefii
 */

    if (($_SERVER['HTTP_HOST']=="exoscefii") || ($_SERVER['HTTP_HOST']=="localhost")) {
        // mySql version 5.7
        define("SERVER","localhost:3306");
        define("USER","root");
        define("PWD","");
        define("BASE","cefiidev827");
    }else{
        // serveur de cefii (mySql version 5.5)
        define("SERVER","sqlprive-pc2372-001.privatesql:3306");
        define("USER","cefiidev827");
        define("PWD","m4zP3w7Y");
        define("BASE","cefiidev827");
    }
    
try {
    // tentative d'instanciation de la connexion
    $connexion = new PDO("mysql:host=".SERVER.";dbname=".BASE, USER,PWD);
    echo('connecté ok');
}
catch (Exception $badConnexion)
{
    echo 'Erreur : ' . $badConnexion->getMessage();    
}
?>