<?php
/**
 *  classe singleton permettant la création d'une unique connection réutilisable
 * 
 */
class ConnectModel
{
    /**
     * $instancePDO est conservée en static pour servir de témoin à une nouvelle instanciation
     */
    private static $instancePDO; // static donc non lié à classe pas à un objet
    /**
     * $connexion à la base de donnée
     */
    public static $connexion;
    
    /**
     * le construteur ouvre la connection sur la BDD approprié en fonction du serveur http d'ou vient la demande
     * et attribut la connexion à l'attribut static $connexion
     */
    private function __construct(){ // private pour ne pas être instanciée
        // definie la base où se conecter en fonction d'ou est l'execution
        if (($_SERVER['HTTP_HOST']=="exoscefii") || ($_SERVER['HTTP_HOST']=="localhost")) {
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
            //$_SESSION['msg']= 'Erreur de connexion : <br>' . $badConnexion->getMessage();    
        }   
    }
    
    /**
     * cette méthode permet de checker si la méthode était déjà instancier ou non
     * et retourne cette instance (dont la connexion)
     * 
     * @return obj self 
     */
    public static function getInstance(){
        if (!isset(self::$instancePDO)){
            self::$instancePDO = new self; 
        }
        return self::$instancePDO;
    }
    // __clone est privatisée pour être «désactiver» et éviter donc une autre connexion
    private  function __clone()  {} 
    
}