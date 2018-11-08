<?php
class FournisseurView extends View
{
    
    function __construct() {
        parent::__construct();
        $this->frm = file_get_contents('view/html/frmFournisseur.html');
    }
    
    public function displayAdd() {
        $this->frm = str_replace('{id}', '', $this->frm);
        $this->frm = str_replace('{societe}', '', $this->frm);
        $this->frm = str_replace('{adresse}', '', $this->frm);
        $this->frm = str_replace('{code_postal}', '', $this->frm);
        $this->frm = str_replace('{ville}', '', $this->frm);
        $this->frm = str_replace('{commentaire}', '', $this->frm);
        $this->frm = str_replace('{postAction}', './index.php?action=add&entite=fournisseur', $this->frm);
        $this->frm = str_replace('{lblBouton}', 'Ajouter', $this->frm);
        $this->frm = str_replace('readonly', '', $this->frm);
        $this->displayForm();        
    }
    
    public function displayUpdate($fournisseur) {
        $this->feelFrm($fournisseur);
        $this->frm = str_replace('{postAction}', './index.php?action=maj&entite=fournisseur', $this->frm);
        $this->frm = str_replace('{lblBouton}', 'Mettre à jour', $this->frm);
        $this->frm = str_replace('readonly', '', $this->frm);
        $this->displayForm();        
    }

    public function displayDelete($fournisseur) {
        $this->feelFrm($fournisseur);
        $this->frm = str_replace('{lblBouton}', 'Supprimer', $this->frm);
        $this->frm = str_replace('{postAction}', './index.php?action=del&entite=fournisseur', $this->frm);
        $this->displayForm();        
    }
    
    private function feelFrm($fournisseur){
        $this->frm = str_replace('{id}', $fournisseur->id, $this->frm);
        $this->frm = str_replace('{societe}', $fournisseur->societe, $this->frm);
        $this->frm = str_replace('{adresse}', $fournisseur->adresse , $this->frm);
        $this->frm = str_replace('{code_postal}', $fournisseur->code_postal , $this->frm);
        $this->frm = str_replace('{ville}', $fournisseur->ville , $this->frm);
        $this->frm = str_replace('{commentaire}', $fournisseur->commentaire , $this->frm);
    }    
    
    
}
