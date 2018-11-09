<?php
class ClientView extends PersonneView
{
    
    function __construct() {
        parent::__construct();
    }
    
    public function displayAdd() {
        $this->feelFrm($personne,true);
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
}
