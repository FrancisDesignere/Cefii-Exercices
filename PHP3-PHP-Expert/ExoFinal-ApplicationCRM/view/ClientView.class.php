<?php
class ClientView extends PersonneView
{
    
    function __construct() {
        parent::__construct();
    }
    public function displayAdd($categories) {
        $this->frm = str_replace('Renseignements Personne', 'Renseignements Client', $this->frm);
        parent::displayAdd($categories);
    }
    
    public function displayUpdate($personne, $categories) {
        $this->frm = str_replace('Renseignements Personne', 'Renseignements Client', $this->frm);
        parent::displayUpdate($personne, $categories);
    }    

    public function displayDelete($personne, $categories) {
        $this->frm = str_replace('Renseignements Personne', 'Client a supprimer', $this->frm);
        parent::displayDelete($personne, $categories);
    }  
    /*
    protected function addLstCateg($categories, $personne=null, $SelectedCateg=2){
        parent::addLstCateg($categories, $personne, $SelectedCateg);
    }
     * 
     */
    
}
