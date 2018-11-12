<?php
class ProspectView extends PersonneView
{
    
    function __construct() {
        parent::__construct();
    }

    public function displayAdd($categories) {
        $this->frm = str_replace('Renseignements Personne', 'Renseignements Prospect', $this->frm);
        $this->frm = str_replace('{displayCateg}', 'style="display:none"', $this->frm);
        parent::displayAdd($categories);
    }
    public function displayUpdate($personne, $categories) {
        $this->frm = str_replace('Renseignements Personne', 'Renseignements Prospect', $this->frm);
        parent::displayUpdate($personne, $categories);
    }

    public function displayDelete($personne, $categories) {
        $this->frm = str_replace('Renseignements Personne', 'Prospect à supprimer', $this->frm);
        $this->frm = str_replace('{displayCateg}', 'style="display:none"', $this->frm);
        parent::displayDelete($personne, $categories);
    }        
/*
    protected function addLstCateg($categories, $personne=null, $SelectedCateg=1){
        parent::addLstCateg($categories, $personne, $SelectedCateg);
    }
 * 
 */
}
