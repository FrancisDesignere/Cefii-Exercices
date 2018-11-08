<?php
/**
 * La classe FournisseurModel gère les actions sur l'entité fournisseur
 *
 * @author francis
 */
class FournisseurModel extends Model
{
    static $table = 'fournisseur';
    
    private function getUserByData($societe) {
        $strReq = "SELECT * FROM ".self::$table." where societe like :societe limit 0,1";
        $prep = $this->singleConnection->prepare($strReq);
        $prep->execute(array(':societe'=>$societe, ));
        return $ObjUsr = $prep->fetch(PDO::FETCH_OBJ);
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
            $ObjItem = $this->getUserByData($item['societe']);

            // suivant le retour, on sait s'il faut créer l'article ou le modifier
            if($ObjItem==false){ // cas d'une création d'utilisateur
                $reqPrepIns = $this->singleConnection->prepare("INSERT INTO ".self::$table." (`societe`, `adresse`, `code_postal`, `ville`, `commentaire`) VALUES (:societe, :adresse, :code_postal, :ville, :commentaire)");
                $reqPrepIns->execute(array(':societe'=>$item['societe'], ':adresse'=>$item['adresse'], 'code_postal'=>$item['code_postal'], 'commentaire'=>$item['commentaire'], 'ville'=>$item['ville']));
                return $reqPrepIns->rowCount();
            }elseif(count($ObjItem)==1){// cas d'une mise à jour d'utilisateur
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
 