<?php
/**
 * La classe FournisseurModel gère les actions sur l'entité fournisseur
 *
 * @author francis
 */
class PersonneModel extends Model
{
    static $table = 'crm_personne';
    
    protected function getItemByData($item) {
        $strReq = "SELECT * FROM ".self::$table." where ";
        $strReq .= "nom like :nom and ";
        $strReq .= "prenom like :prenom and ";
        $strReq .= "adresse like :adresse and ";
        $strReq .= "code_postal like :code_postal limit 0,1";
        $prep = $this->singleConnection->prepare($strReq);
        $prep->bindParam(':nom', $item['nom']);
        $prep->bindParam(':prenom', $item['prenom']);
        $prep->bindParam(':adresse', $item['adresse']);
        $prep->bindParam(':code_postal', $item['code_postal']);
        $prep->execute(); 
        $ObjUsr = $prep->fetch(PDO::FETCH_OBJ);
        return $ObjUsr;

    }

        public function getItemById($id) {
        $strReq = "SELECT * FROM ".self::$table." where id = :id";
        $prep = $this->singleConnection->prepare($strReq);
        $prep->execute(array(':id'=>$id));
        return $ObjItem = $prep->fetch(PDO::FETCH_OBJ);
    }
    
    public function insert($item) {
        if ($_SESSION['token']==$item['token']){
            //on s'assure qu'il n'y a pas de user (homonyme et adresse) déjà présent 
            $ObjItem = $this->getItemByData($item);

            // suivant le retour, on sait s'il faut créer l'article ou le modifier
            if($ObjItem==false){ // cas d'une création d'utilisateur
                $strReq = "INSERT INTO ".self::$table." (`nom`, `prenom`, `adresse`, `code_postal`, `ville`, `commentaire`, `fk_id_category`) ";
                $strReq .= "VALUES (:nom, :prenom, :adresse, :code_postal, :ville, :commentaire, :fk_id_category)";
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
            }elseif(count($ObjItem)==1){// cas d'une mise à jour d'utilisateur
                // à voir si mise à jour de l'existant ou bien on met un message et on ne fait rien
            }
        }
    }
    
    public function update($item){
        if ($_SESSION['token']==$item['token']){

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
 