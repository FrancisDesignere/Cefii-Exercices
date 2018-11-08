<?php
/**
 *  classe singleton permettant la création d'une unique connection réutilisable
 * 
 */
class ConnectModel
{
    private static $instancePDO; // static en static donc non lié à classe pas à un objet
    public static $connexion;
    
    private function __construct(){ // private pour ne pas être instanciée
        // definie la base où se conecter en fonction d'ou est l'execution
        if (($_SERVER['HTTP_HOST']=="exoscefii") || ($_SERVER['HTTP_HOST']=="localhost")) {
            //// à corriger : je n'arrive pas à ne plus passer ici malgré la condition !isset
            define("SERVER","localhost:3306");
            define("USER","root");
            define("PWD","");
            define("BASE","cefiidev827");
        }else{
            define("SERVER","sqlprive-pc2372-001.privatesql:3306");
            define("USER","cefiidev827");
            define("PWD","m4zP3w7Y");
            define("BASE","cefiidev827");
        }
        // Désactive l'émulateur pdo de php pour utiliser celui du sgbdd si disponible
        $arrExtraParam[PDO::ATTR_EMULATE_PREPARES] = false;
        $arrExtraParam[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        // Si l'on souhaite utiliser le mode objet par défaut pour récupérer les données
        $arrExtraParam[PDO::ATTR_DEFAULT_FETCH_MODE] = PDO::FETCH_OBJ;    
        
        try { // tentative d'instanciation de la connexion            
            self::$connexion = new PDO("mysql:host=".SERVER.";dbname=".BASE.";charset=utf8", USER,PWD);
        }
        catch (Exception $badConnexion)
        {   // gestion d'erreur
            die('Erreur : ' . $badConnexion->getMessage()); //// gestion d'erreur à voir
        }   
    }
    
    public static function getInstance(){
        if (!isset(self::$instancePDO)){
            self::$instancePDO = new self; //// ConnectController; // c'est pareil ?
        }
        return self::$instancePDO;
    }

    private  function __clone()  {} // privatiser cette méthode la « désactive » pour le code extérieur 
    
}