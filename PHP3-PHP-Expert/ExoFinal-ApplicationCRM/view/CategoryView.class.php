<?php
class CategoryView extends View
{

    function __construct() {
        parent::__construct();
        $this->frm = file_get_contents('view/html/frmCategory.html');
    }        

    public function displayAdd() {
        $this->frm = str_replace('{id}', '', $this->frm);
        $this->frm = str_replace('{nom}', '', $this->frm);
        $this->frm = str_replace('{description}', '', $this->frm);
       $this->frm = str_replace('{postAction}', './index.php?action=add&entite=category', $this->frm);
        $this->frm = str_replace('{lblBouton}', 'Ajouter', $this->frm);
        $this->frm = str_replace('readonly', '', $this->frm);
        $this->displayForm();        
    }
    
    public function displayUpdate($category) {
        $this->feelFrm($category);
        $this->frm = str_replace('{postAction}', './index.php?action=maj&entite=category', $this->frm);
        $this->frm = str_replace('{lblBouton}', 'Mettre à jour', $this->frm);
        $this->frm = str_replace('readonly', '', $this->frm);
        $this->displayForm();        
    }

    public function displayDelete($category) {
        $this->feelFrm($category);
        $this->frm = str_replace('{lblBouton}', 'Supprimer', $this->frm);
        $this->frm = str_replace('{postAction}', './index.php?action=del&entite=category', $this->frm);
        $this->displayForm();        
    }
    
    private function feelFrm($category){
        $this->frm = str_replace('{id}', $category->id, $this->frm);
        $this->frm = str_replace('{nom}', $category->nom, $this->frm);
        $this->frm = str_replace('{description}', $category->description, $this->frm);
    }
     
}
