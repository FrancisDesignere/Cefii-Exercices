<?php
/**
 * La classe FournisseurModel gère les actions sur l'entité fournisseur
 *
 * @author francis
 */
class FournisseurModel extends Model
{
    static $table = 'fournisseur';
    
        public function getItemById($id) {
        $strReq = "SELECT * FROM ".self::$table." where id = :id";
        $prep = $this->singleConnection->prepare($strReq);
        $prep->execute(array(':id'=>$id));
        return $ObjItem = $prep->fetch(PDO::FETCH_OBJ);
    }
    
    public function insert($item) {
        if ($_SESSION['token']==$item['token']){
            $strReq="INSERT INTO ".self::$table." (`societe`, `adresse`, `code_postal`, `ville`, `commentaire`)";
            $strReq.=" VALUES (:societe, :adresse, :code_postal, :ville, :commentaire)";
            $strReq.=" ON DUPLICATE KEY UPDATE `adresse`=:adresse, `code_postal`=:code_postal, `ville`=:ville, `commentaire`=:commentaire ";
            $prep = $this->singleConnection->prepare($strReq);
            $prep->bindParam(':societe', $item['societe']);
            $prep->bindParam(':adresse', $item['adresse']);
            $prep->bindParam(':code_postal', $item['code_postal']);
            $prep->bindParam(':ville', $item['ville']);
            $prep->bindParam(':commentaire', $item['commentaire']);            
            $prep->execute();
            return $prep->rowCount();        
        }
    }

    public function update($item){
        if ($_SESSION['token']==$item['token']){
            $strReq="UPDATE ".self::$table." SET `societe` = :societe, `adresse` = :adresse, `code_postal` = :code_postal, `commentaire` = :commentaire , `ville` = :ville ";
            $strReq.="WHERE `id`= :id";
            $prep = $this->singleConnection->prepare($strReq);
            $prep->bindParam(':societe', $item['societe']);
            $prep->bindParam(':adresse', $item['adresse']);
            $prep->bindParam(':code_postal', $item['code_postal']);
            $prep->bindParam(':ville', $item['ville']);
            $prep->bindParam(':commentaire', $item['commentaire']);
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
 