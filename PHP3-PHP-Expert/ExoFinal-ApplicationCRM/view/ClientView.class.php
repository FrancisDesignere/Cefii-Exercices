<?php
class ClientView extends PersonneView
{
    
    function __construct() {
        parent::__construct();
    }
    public function displayAdd($categories, $defaultCateg=2) {
        $this->frm = str_replace('Renseignements Personne', 'Renseignements Client', $this->frm);
        $this->frm = str_replace('{postAction}', './index.php?action=add&entite=client', $this->frm); 
        parent::displayAdd($categories, $defaultCateg);
    }
    
    public function displayUpdate($personne, $categories) {
        $this->frm = str_replace('Renseignements Personne', 'Renseignements Client', $this->frm);
        $this->frm = str_replace('{postAction}', './index.php?action=maj&entite=client', $this->frm);        
        parent::displayUpdate($personne, $categories);
    }    

    public function displayDelete($personne, $categories) {
        $this->frm = str_replace('Renseignements Personne', 'Client a supprimer', $this->frm);
        $this->frm = str_replace('{postAction}', './index.php?action=del&entite=client', $this->frm);        
        parent::displayDelete($personne, $categories);
    }  
}
