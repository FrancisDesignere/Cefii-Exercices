<?php
class PersonneView extends View
{
    
    function __construct() {
        parent::__construct();
        $this->frm = file_get_contents('view/html/frmPersonne.html');
    }
    
    public function displayAdd() {
//        $this->feelFrm($personne,true);
        $this->feelFrm();
        $this->frm = str_replace('{postAction}', './index.php?action=add&entite=personne', $this->frm);
        $this->frm = str_replace('{lblBouton}', 'Ajouter', $this->frm);
        $this->frm = str_replace('readonly', '', $this->frm);
        $this->displayForm();        
    }
    
    public function displayUpdate($personne) {
        $this->feelFrm($personne);
        $this->frm = str_replace('{postAction}', './index.php?action=maj&entite=personne', $this->frm);
        $this->frm = str_replace('{lblBouton}', 'Mettre à jour', $this->frm);
        $this->frm = str_replace('readonly', '', $this->frm);
        $this->displayForm();        
    }

    public function displayDelete($personne) {
        $this->feelFrm($personne);
        $this->frm = str_replace('{lblBouton}', 'Supprimer', $this->frm);
        $this->frm = str_replace('{postAction}', './index.php?action=del&entite=personne', $this->frm);
        $this->displayForm();        
    }
    
    protected function feelFrm($personne = null, $vide=false){
        if ($personne == null){
            $this->frm = str_replace('{id}', '', $this->frm);
            $this->frm = str_replace('{nom}', '', $this->frm);
            $this->frm = str_replace('{prenom}', '', $this->frm);
            $this->frm = str_replace('{adresse}', '', $this->frm);
            $this->frm = str_replace('{code_postal}', '', $this->frm);
            $this->frm = str_replace('{ville}', '', $this->frm);
            $this->frm = str_replace('{commentaire}', '', $this->frm);
        }else{
            $this->frm = str_replace('{id}', $personne->id, $this->frm);
            $this->frm = str_replace('{nom}', $personne->nom, $this->frm);
            $this->frm = str_replace('{prenom}', $personne->prenom , $this->frm);
            $this->frm = str_replace('{adresse}', $personne->adresse , $this->frm);
            $this->frm = str_replace('{code_postal}', $personne->code_postal , $this->frm);
            $this->frm = str_replace('{ville}', $personne->ville , $this->frm);
            $this->frm = str_replace('{commentaire}', $personne->commentaire , $this->frm);
        }
    }    
    
    
}
