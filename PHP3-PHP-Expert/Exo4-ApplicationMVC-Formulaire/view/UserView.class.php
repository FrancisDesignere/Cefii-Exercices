<?php

class UserView extends View
{
    
    function __construct() {
        parent::__construct();
        $this->frm = file_get_contents('view/html/frmUser.html');
    }    
    
    public function displayAdd() {
        $this->frm = str_replace('{id}', '', $this->frm);
        $this->frm = str_replace('{nom}', '', $this->frm);
        $this->frm = str_replace('{prenom}', '', $this->frm);
        $this->frm = str_replace('{ville}', '', $this->frm);
        $this->frm = str_replace('{postAction}', './index.php?action=add&entite=user', $this->frm);
        $this->frm = str_replace('{lblBouton}', 'Ajouter', $this->frm);
        $this->frm = str_replace('readonly', '', $this->frm);
        $this->displayForm();        
    }

    public function displayUpdate($user) {
        $this->feelFrm($user);
        $this->frm = str_replace('{postAction}', './index.php?action=maj&entite=user', $this->frm);
        $this->frm = str_replace('{lblBouton}', 'Mettre à jour', $this->frm);
        $this->frm = str_replace('readonly', '', $this->frm);
        $this->displayForm();        
    }

    public function displayDelete($user) {
        $this->feelFrm($user);
        $this->frm = str_replace('{lblBouton}', 'Supprimer', $this->frm);
        $this->frm = str_replace('{postAction}', './index.php?action=del&entite=user', $this->frm);
        $this->displayForm();        
    }
    
    private function feelFrm($user){
        $this->frm = str_replace('{id}', $user->id, $this->frm);
        $this->frm = str_replace('{nom}', $user->nom, $this->frm);
        $this->frm = str_replace('{prenom}', $user->prenom, $this->frm);
        $this->frm = str_replace('{ville}', $user->ville, $this->frm);
    }
    
}
