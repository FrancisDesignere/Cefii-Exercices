<?php
/**
 * La classe Model ouvre la connection et porte les fonctions d'accès aux datas
 * 
 *      C'est également la classe mère de CategoryModel et PersonneModel
 *
 * @author francis
 */
class Model 
{
    /**
     * $singleConnection est l'object PDO correspondant à la connection unique qui sera réutilisée
     */
    public $singleConnection;
    /**
     * attribut  portant la liste des tables et vue que l'appli pourra acceder
     */
    static $tablesAccessible = "|crm_personne|crm_category|crm_client|crm_prospect|";
    
    /**
     * le constructeur instancie la connexion unique
     */
    public function __construct() {
        $conn = ConnectModel::getInstance();
        $this->singleConnection = $conn::$connexion;
    }
    
    protected function checkTable($tbl2chck){
        if(strpos(self::$tablesAccessible, '|'.$tbl2chck.'|')===false){
            return false;
        }else{
            return true;
        }
    }
    
    /**
    * Retourne la liste de toutes les occurrences
    * de la table (ou vue) demandée 
    * 
    * @return string[] un tableau avec la liste de tous les enregistrements (et tous leur attributs)
    */
    public function getList($table) {
        $list= array();
        $table = 'crm_'.$table; 
        if($this->checkTable($table)){
            $requete = "SELECT * FROM ".$table;
            $prep = $this->singleConnection->prepare($requete);
            $prep->execute();
            $list = $prep->fetchAll(PDO::FETCH_ASSOC);
        }
        return $list;
    }
}

