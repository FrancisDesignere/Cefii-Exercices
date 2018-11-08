<?php
/**
 * La classe ProduitModel gère les actions sur l'entité Produit
 *
 * @author francis
 */
class ProduitModel extends Model
{
    static $table = 'produit';
    
    private function getUserByData($reference) {
        $strReq = "SELECT * FROM ".self::$table." where reference like :reference limit 0,1";
        $prep = $this->singleConnection->prepare($strReq);
        $prep->execute(array(':reference'=>$reference, ));
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
            $ObjItem = $this->getUserByData($item['reference']);

            // suivant le retour, on sait s'il faut créer l'article ou le modifier
            if($ObjItem==false){ // cas d'une création d'utilisateur
                $reqPrepIns = $this->singleConnection->prepare("INSERT INTO ".self::$table." (`reference`, `nom`, `quantite`, `commentaire`, `id_fournisseur`) VALUES (:reference, :nom, :quantite, :commentaire, :id_fournisseur)");
                $reqPrepIns->execute(array(':reference'=>$item['reference'], ':nom'=>$item['nom'], 'quantite'=>$item['quantite'], 'commentaire'=>$item['commentaire'], 'id_fournisseur'=>$item['id_fournisseur']));
                return $reqPrepIns->rowCount();
            }elseif(count($ObjItem)==1){// cas d'une mise à jour d'utilisateur
                $strReq="UPDATE ".self::$table." SET `reference` = :reference, `nom` = :nom, `quantite` = :quantite, `commentaire` = :commentaire , `id_fournisseur` = :id_fournisseur ";
                $strReq.="WHERE `id`= :id";
                $prep = $this->singleConnection->prepare($strReq);
                $prep->bindParam(':reference', $item['reference']);
                $prep->bindParam(':nom', $item['nom']);
                $prep->bindParam(':quantite', $item['quantite']);
                $prep->bindParam(':commentaire', $item['commentaire']);
                $prep->bindParam(':id_fournisseur', $item['id_fournisseur']);
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
 