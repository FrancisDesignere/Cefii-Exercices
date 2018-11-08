<?php
/**
 * La classe Model ouvre la connection et porte les fonction d'accès aux datas
 *
 * @author francis
 */
class Model 
{
    public $singleConnection;
    static $tablesAccessible = "|user|produit|fournisseur|";
    
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
    * de la table demandée 
    * 
    * @return type
    */
    public function getList($table) {
        $list= array();
        if($this->checkTable($table)){
            $requete = "SELECT * FROM ".$table;
            $prep = $this->singleConnection->prepare($requete);
            $prep->execute();
            $list = $prep->fetchAll(PDO::FETCH_ASSOC);   
            return $list;
        }
    }
}