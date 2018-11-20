<?php
/**
  * La classe CategoryModel gère les actions sur l'entité Personne
 * 
 *      Gère les actions création/maj/suppression en Base pour les categories
 *      Herite la connexion à la bdd de la classe Model 
 * 
 * @author francis
 */
class PersonneModel extends Model
{
    /**
     * $table contient le nom de la table qui sera requetée
     */
    static $table = 'crm_personne';


    /**
     * Methode retournant un objet correspondant à la personne requetée catégorie
     * 
     * @param int $id
     * @return obj Personne $ObjItem
     */
        public function getItemById($post) {
        $strReq = "SELECT * FROM ".self::$table." where id = :id";
        $prep = $this->singleConnection->prepare($strReq);
        $prep->execute(array(':id'=>$post['itemId']));
        return $ObjItem = $prep->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Methode lancant la requete de création d'une personne en base
     * 
     * @param array $item
     * @return int le nombre correspondant au nombre d'enregistrement créé (1 si OK)
     */    
    public function insert($item) {
        if ($_SESSION['token']==$item['token']){
            $strReq = "INSERT INTO ".self::$table." (`nom`, `prenom`, `adresse`, `code_postal`, `ville`, `commentaire`, `fk_id_category`) ";
            $strReq .= " VALUES (:nom, :prenom, :adresse, :code_postal, :ville, :commentaire, :fk_id_category)";
            $strReq .= " ON DUPLICATE KEY UPDATE `prenom` = :prenom, `ville` = :ville, `commentaire` = :commentaire ";                
            $reqPrepIns = $this->singleConnection->prepare($strReq);
            $reqPrepIns->bindParam(':nom', $item['nom']);
            $reqPrepIns->bindParam(':prenom', $item['prenom']);
            $reqPrepIns->bindParam(':adresse', $item['adresse']);
            $reqPrepIns->bindParam(':code_postal', $item['code_postal']);
            $reqPrepIns->bindParam(':ville', $item['ville']);
            $reqPrepIns->bindParam(':commentaire', $item['commentaire']);
            $reqPrepIns->bindParam(':fk_id_category', $item['fk_id_category']);
            $reqPrepIns->execute();    
            return $reqPrepIns->rowCount();
        }
    }
    
    /**
     * Méthode lancant la requete de mise à jour d'une personne 
     * 
     *      les données fournies proviennent du formulaire (incluant l'id de la personne) 
     * 
     * @param array $item un tableau correspondant aux données à mettre à jour + l'id
     * @return int le nombre correspondant au nombre d'enregistrement mis à jour (1 si OK)
     */    
    public function update($item){
        if ($_SESSION['token']==$item['token']){
            //si provient du clic sur le bouton 'nouveau client' on ne tient pas compte de select on passe en catég 2
            if(isset($item['btnNewClient'])){$item['fk_id_category']=2;}

            $strReq="UPDATE ".self::$table." SET `nom` = :nom, `prenom` = :prenom, `adresse` = :adresse, ";
            $strReq.="`code_postal` = :code_postal, `commentaire` = :commentaire , `ville` = :ville, `fk_id_category` = :fk_id_category ";
            $strReq.="WHERE `id`= :id";
            $prep = $this->singleConnection->prepare($strReq);
            $prep->bindParam(':nom', $item['nom']);
            $prep->bindParam(':prenom', $item['prenom']);
            $prep->bindParam(':adresse', $item['adresse']);
            $prep->bindParam(':code_postal', $item['code_postal']);
            $prep->bindParam(':ville', $item['ville']);
            $prep->bindParam(':commentaire', $item['commentaire']);
            $prep->bindParam(':fk_id_category', $item['fk_id_category']);
            $prep->bindParam(':id', $item['id']);
            $prep->execute();
            return $prep->rowCount();
        }
    }

    /**
     * Méthode lançant la requete de suppression d'une personne 
     *  
     * @param array $item un tableau contenant l'id de l'item à supprimer
     * @return int le nombre correspondant au nombre d'enregistrement mis à jour (1 si OK)
     */        
    public function delete($item){
        if ($_SESSION['token']==$item['token']){
            $strReq = "DELETE FROM ".self::$table." where id =:id";
            $ReqPrep = $this->singleConnection->prepare($strReq);
            $ReqPrep->bindParam(':id',$item['id'],PDO::PARAM_INT);
            $ReqPrep->execute();
            return $ReqPrep->rowCount(); 
        }
    }    
    
}
 