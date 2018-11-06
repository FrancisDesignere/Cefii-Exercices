<?php
/**
 * La classe UserModel gère les actions sur l'entité User
 *
 * @author francis
 */
class UserModel extends Model
{
    /**
     * methode privée pour recherchée l'existance d'un user (avant création notamment)
     * 
     * @param string $lastName
     * @param string $firstName
     * @return object
     */
    private function getUserByData($lastName, $firstName) {
        $strReq = "SELECT * FROM user where nom like :nom and prenom like :prenom limit 0,1";
        $prep = $this->singleConnection->prepare($strReq);
        $prep->execute(array(':nom'=>$lastName, ':prenom'=>$firstName, ));
        return $ObjUsr = $prep->fetch(PDO::FETCH_OBJ);
        }
    
    public function Upsert($user){
        //on recherche si user (homonyme) déjà présent 
        $usr = $this->getUserByData($user['nom'], $user['prenom']);
        // suivant le retour, on sait s'il faut créer l'article ou le modifier
        if($usr==false){ // cas d'une création d'utilisateur
            $reqPrepIns = $this->singleConnection->prepare("INSERT INTO user (`nom`, `prenom`, `ville`) VALUES (:nom, :prenom, :ville)");
            $reqPrepIns->execute(array(':prenom'=>$user['prenom'], ':nom'=>$user['nom'], 'ville'=>$user['ville']));
            return $reqPrepIns->rowCount();
        }elseif(count($usr)==1){// cas d'une mise à jour d'utilisateur
            $usrId = $usr->id;
            $strReq="UPDATE user SET `nom` = :nom, `prenom` = :prenom, `ville` = :ville ";
            $strReq.="WHERE `id`= :id";
            $prep = $this->singleConnection->prepare($strReq);
            $prep->bindParam(':nom', $user['nom']);
            $prep->bindParam(':prenom', $user['prenom']);
            $prep->bindParam(':ville', $user['ville']);
            $prep->bindParam(':id', $usrId);
            $prep->execute();
            return $prep->rowCount();
        }
    }      

    public function Delete($id){
        
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
}

