<?php
/**
 * La classe ProduitModel gère les actions sur l'entité Produit
 *
 * @author francis
 */
class CategoryModel extends Model
{
    static $table = 'crm_category';
    
    private function getItempByData($nom) {
        $strReq = "SELECT * FROM ".self::$table." where nom like :nom limit 0,1";
        $prep = $this->singleConnection->prepare($strReq);
        $prep->execute(array(':nom'=>$nom, ));
        return $ObjItem = $prep->fetch(PDO::FETCH_OBJ);
        }    

    public function getItemById($id) {
        $strReq = "SELECT * FROM ".self::$table." where id = :id";
        $prep = $this->singleConnection->prepare($strReq);
        $prep->execute(array(':id'=>$id));
        return $ObjItem = $prep->fetch(PDO::FETCH_OBJ);
    }
    
    public function Upsert($item){
        if ($_SESSION['token']==$item['token']){
            //on recherche si user (homonyme) déjà présent 
            $ObjItem = $this->getItempByData($item['nom']);

            // suivant le retour, on sait s'il faut créer l'article ou le modifier
            if($ObjItem==false){ // cas d'une création d'utilisateur
                $reqPrepIns = $this->singleConnection->prepare("INSERT INTO ".self::$table." (`nom`, `description`) VALUES (:nom, :description)");
                $reqPrepIns->execute(array(':nom'=>$item['nom'], 'description'=>$item['description']));
                return $reqPrepIns->rowCount();
            }elseif(count($ObjItem)==1){// cas d'une mise à jour d'utilisateur
                $strReq="UPDATE ".self::$table." SET `nom` = :nom, `description` = :description ";
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
    
    public function Delete($item){
        if ($_SESSION['token']==$item['token']){
            $strReq = "DELETE FROM ".self::$table." where id =:id";
            $ReqPrep = $this->singleConnection->prepare($strReq);
            $ReqPrep->bindParam(':id',$item['id'],PDO::PARAM_INT);
            $ReqPrep->execute();
            return $ReqPrep->rowCount(); 
        }
    }
}
 