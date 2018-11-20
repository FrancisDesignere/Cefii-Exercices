<?php
/**
 * La classe Model ouvre la connection et porte les fonctions d'accès aux datas
 * 
 *      C'est également la classe mère de CategoryModel et PersonneModel
 *
 * @author francis
 */
abstract class Model 
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

    /**
     * Methode retournant un objet correspondant à l'id demandée
     * (id de catégorie ou personne suivant la classe fille qui appele)
     * 
     * @param int $id
     * @return obj Category $ObjItem
     */
    public function getItemById($post) {
        $strReq = "SELECT * FROM ".$this->table." where id = :id";
        $prep = $this->singleConnection->prepare($strReq);
        $prep->execute(array(':id'=>$post['itemId']));
        return $ObjItem = $prep->fetch(PDO::FETCH_OBJ);
    }
    
    /**
     * Méthode lançant la requete de suppression de l'id demandé 
     * (id de catégorie ou personne suivant la classe fille qui appele)
     *   
     * @param array $item un tableau contenant l'id de l'item à supprimer
     * @return int le nombre correspondant au nombre d'enregistrement mis à jour (1 si OK)
     */    
    public function Delete($item){
        if ($_SESSION['token']==$item['token']){
            $strReq = "DELETE FROM ".$this->table." where id =:id";
            $ReqPrep = $this->singleConnection->prepare($strReq);
            $ReqPrep->bindParam(':id',$item['id'],PDO::PARAM_INT);
            $ReqPrep->execute();
            return $ReqPrep->rowCount(); 
        }
    }
    
}

