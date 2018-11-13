<?php
/**
 * La classe UserModel gère les actions sur l'entité User
 *
 * @author francis
 */
class UserModel extends Model
{
    static $table = 'user';
    

    public function getItemById($id) {
        $strReq = "SELECT * FROM ".self::$table." where id = :id";
        $prep = $this->singleConnection->prepare($strReq);
        $prep->execute(array(':id'=>$id));
        return $ObjUsr = $prep->fetch(PDO::FETCH_OBJ);
    }
        
    public function insert($user){
        if ($_SESSION['token']==$user['token']){
            $strReq = "INSERT INTO ".self::$table." (`nom`, `prenom`, `ville`) VALUES (:nom, :prenom, :ville) ";
            $strReq .= "ON DUPLICATE KEY UPDATE `ville` = :ville";
            $prep = $this->singleConnection->prepare($strReq);
            $prep->bindParam(':nom', $user['nom']);
            $prep->bindParam(':prenom', $user['prenom']);
            $prep->bindParam(':ville', $user['ville']);            
            $prep->execute();
            return $prep->rowCount();
        }
    }

        public function update($user){
        if ($_SESSION['token']==$user['token']){
            $strReq="UPDATE ".self::$table." SET `nom` = :nom, `prenom` = :prenom, `ville` = :ville ";
            $strReq.="WHERE `id`= :id";
            $prep = $this->singleConnection->prepare($strReq);
            $prep->bindParam(':nom', $user['nom']);
            $prep->bindParam(':prenom', $user['prenom']);
            $prep->bindParam(':ville', $user['ville']);
            $prep->bindParam(':id', $user['id']);
            $prep->execute();
            return $prep->rowCount();
        }
    }      

    public function delete($user){   
        if ($_SESSION['token']==$user['token']){
            $strReq = "DELETE FROM ".self::$table." where id =:id";
            $ReqPrep = $this->singleConnection->prepare($strReq);
            $ReqPrep->bindParam(':id',$user['id'],PDO::PARAM_INT);
            $ReqPrep->execute();
            return $ReqPrep->rowCount(); 
        }
    }        
}
