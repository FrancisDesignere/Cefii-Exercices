<?php
/**
 * La classe ProduitModel gère les actions sur l'entité Produit
 *
 * @author francis
 */
class ProduitModel extends Model
{
    static $table = 'produit';

    public function getItemById($id) {
        $strReq = "SELECT * FROM ".self::$table." where id = :id";
        $prep = $this->singleConnection->prepare($strReq);
        $prep->execute(array(':id'=>$id));
        return $ObjItem = $prep->fetch(PDO::FETCH_OBJ);
    }
    
    public function insert($item){
        if ($_SESSION['token']==$item['token']){
            $strReq = "INSERT INTO ".self::$table." (`reference`, `nom`, `quantite`, `commentaire`, `id_fournisseur`) ";
            $strReq .= "VALUES (:reference, :nom, :quantite, :commentaire, :id_fournisseur) ";
            $strReq .= "ON DUPLICATE KEY UPDATE `nom`=:nom, `quantite`=:quantite, `commentaire`=:commentaire, `id_fournisseur`=:id_fournisseur ";
            $prep = $this->singleConnection->prepare($strReq);
            $prep->bindParam(':reference', $item['reference']);
            $prep->bindParam(':nom', $item['nom']);
            $prep->bindParam(':quantite', $item['quantite']);
            $prep->bindParam(':commentaire', $item['commentaire']);
            $prep->bindParam(':id_fournisseur', $item['id_fournisseur']);
            $prep->execute();
            return $prep->rowCount();
        }
    }
    
    public function Update($item){
        if ($_SESSION['token']==$item['token']){
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
 