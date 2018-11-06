<?php
/**
 * La classe Model ouvre la connection et porte les fonction d'accès aux datas
 *
 * @author francis
 */
class Model 
{
    public $singleConnection;
    
    public function __construct() {
        $conn = ConnectModel::getInstance();
        $this->singleConnection = $conn::$connexion;
    }

    /**
    * Retourne la liste de toutes les occurrences
    * de la table produit 
    * 
    * @return type
    */
    public function getList($table) {
        $requete = "SELECT * FROM ".$table;
        $result = $this->singleConnection->query($requete);
        $list = array();
        if($result) {
            $list = $result->fetchAll(PDO::FETCH_ASSOC);
        }
        return $list;
    }
}

