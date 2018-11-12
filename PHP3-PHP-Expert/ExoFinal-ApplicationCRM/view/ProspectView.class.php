<?php
class ProspectView extends PersonneView
{
    
    function __construct() {
        parent::__construct();
    }

    public function displayAdd($categories, $defaultCateg=1) {
        $this->frm = str_replace('Renseignements Personne', 'Renseignements Prospect', $this->frm);
        $this->frm = str_replace('{displayCateg}', 'style="display:none"', $this->frm);
        $this->frm = str_replace('{postAction}', './index.php?action=add&entite=prospect', $this->frm);         
        parent::displayAdd($categories, $defaultCateg);
    }
    public function displayUpdate($personne, $categories) {
        $this->frm = str_replace('Renseignements Personne', 'Renseignements Prospect', $this->frm);
        $this->frm = str_replace('{postAction}', './index.php?action=maj&entite=prospect', $this->frm);     
        parent::displayUpdate($personne, $categories);
    }

    public function displayDelete($personne, $categories) {
        $this->frm = str_replace('Renseignements Personne', 'Prospect à supprimer', $this->frm);
        $this->frm = str_replace('{postAction}', './index.php?action=del&entite=prospect', $this->frm);
        $this->frm = str_replace('{displayCateg}', 'style="display:none"', $this->frm);
        parent::displayDelete($personne, $categories);
    }        
}
