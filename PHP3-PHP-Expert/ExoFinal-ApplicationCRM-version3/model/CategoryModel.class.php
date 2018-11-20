<?php
/**
 * La classe CategoryModel gère les actions sur l'entité Category
 * 
 *      Gère les actions création/maj/suppression en Base pour les categories
 *      Herite la connexion à la bdd de la classe Model 
 *
 * @author francis
 */
class CategoryModel extends Model
{    
    /**
     * $table contient le nom de la table qui sera requetée
     */
    protected $table = 'crm_category';
    
    /**
     * Methode lancant la requete de création d'une catégorie en base
     * 
     * @param array $item
     * @return int le nombre correspondant au nombre d'enregistrement créé (1 si OK)
     */
    public function insert($item) {
        if ($_SESSION['token']==$item['token']){
            $reqPrepIns = $this->singleConnection->prepare("INSERT INTO ".$this->table." (`nom`, `description`) VALUES (:nom, :description)");
            $reqPrepIns->bindParam(':nom', $item['nom']);
            $reqPrepIns->bindParam(':description', $item['description']);            
            $reqPrepIns->execute();
            return $reqPrepIns->rowCount();
        }
    }
    
    /**
     * Méthode lancant la requete de mise à jour d'une catégorie 
     * 
     *      les données fournies proviennent du formulaire (incluant l'id de la catégorie) 
     * 
     * @param array $item un tableau correspondant aux données à mettre à jour + l'id
     * @return int le nombre correspondant au nombre d'enregistrement mis à jour (1 si OK)
     */
    public function Update($item){  
        if ($_SESSION['token']==$item['token']){
            $strReq="UPDATE ".$this->table." SET `nom` = :nom, `description` = :description ";
            $strReq.="WHERE `id`= :id";
            $prep = $this->singleConnection->prepare($strReq);
            $prep->bindParam(':nom', $item['nom']);
            $prep->bindParam(':description', $item['description']);
            $prep->bindParam(':id', $item['id']);
            $prep->execute();
            return $prep->rowCount();
        }
    }
    

}
 