<?php
/* connexion suivant le cas :
 * -  à la base de donnée en local 
 * -  ou à celle de F Désignère sur serveur Cefii
 */

    if(!isset($connexion)==1){// cette condition pour ne pas definir la condition si déjà fait (par include succéssif)

        // definie la base où se conecter en fonction de l'execution    
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
        // Désactive l'émulateur pdo de php pour utiliser celui du sgbdd si disponible
        $arrExtraParam[PDO::ATTR_EMULATE_PREPARES] = false;
        $arrExtraParam[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        // Si l'on souhaite utiliser le mode objet par défaut pour récupérer les données
        // $arrExtraParam[PDO::ATTR_DEFAULT_FETCH_MODE] = PDO::FETCH_OBJ;    

        try {
            // tentative d'instanciation de la connexion
            $connexion = new PDO("mysql:host=".SERVER.";dbname=".BASE.";charset=utf8", USER,PWD);
        }
        catch (Exception $badConnexion)
        {   // gestion d'erreur
            echo 'Erreur de connexio : <br>' . $badConnexion->getMessage();    
        }

    }
?>