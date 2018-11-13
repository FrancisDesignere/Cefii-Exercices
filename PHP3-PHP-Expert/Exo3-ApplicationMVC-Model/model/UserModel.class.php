<?php
/**
 * La classe UserModel gère les actions sur l'entité User
 *
 * @author francis
 */
class UserModel extends Model
{

    public function insert($user){
        $strReq = "INSERT INTO user (`nom`, `prenom`, `ville`) VALUES (:nom, :prenom, :ville) ";
        $strReq .= "ON DUPLICATE KEY UPDATE `ville` = :ville";
        $prep = $this->singleConnection->prepare($strReq);
        $prep->bindParam(':nom', $user['nom']);
        $prep->bindParam(':prenom', $user['prenom']);
        $prep->bindParam(':ville', $user['ville']);            
        $prep->execute();
        return $prep->rowCount();
    }

        public function update($user){
        $strReq="UPDATE user SET `nom` = :nom, `prenom` = :prenom, `ville` = :ville ";
        $strReq.="WHERE `id`= :id";
        $prep = $this->singleConnection->prepare($strReq);
        $prep->bindParam(':nom', $user['nom']);
        $prep->bindParam(':prenom', $user['prenom']);
        $prep->bindParam(':ville', $user['ville']);
        $prep->bindParam(':id', $user['id']);
        $prep->execute();
        return $prep->rowCount();
    }      

    public function delete($id){
        
        //// provisoire pour test (suppression de toto)
        $usr = $this->getUserByData('toto', 'titi');
        if($usr!==false){////provisoire
            $id = $usr->id;////provisoire
        
        $strReq = 'DELETE FROM user where id =:id';
        $ReqPrep = $this->singleConnection->prepare($strReq);
        $ReqPrep->bindParam(':id',$id,PDO::PARAM_INT);
        $ReqPrep->execute();
        return $ReqPrep->rowCount(); 
        
        }//// provisoire
    }
    
    public function getlist($table){
        return parent::getList($table);
    }
    
}

