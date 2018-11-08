<?php
class ProduitView extends View
{

    function __construct() {
        parent::__construct();
        $this->frm = file_get_contents('view/html/frmProduit.html');
    }        

    public function displayAdd() {
        $this->frm = str_replace('{id}', '', $this->frm);
        $this->frm = str_replace('{nom}', '', $this->frm);
        $this->frm = str_replace('{reference}', '', $this->frm);
        $this->frm = str_replace('{quantite}', '', $this->frm);
        $this->frm = str_replace('{commentaire}', '', $this->frm);
        $this->frm = str_replace('{id_fournisseur}', '', $this->frm);
        $this->frm = str_replace('{postAction}', './index.php?action=add&entite=produit', $this->frm);
        $this->frm = str_replace('{lblBouton}', 'Ajouter', $this->frm);
        $this->frm = str_replace('readonly', '', $this->frm);
        $this->displayForm();        
    }
    
    public function displayUpdate($produit) {
        $this->feelFrm($produit);
        $this->frm = str_replace('{postAction}', './index.php?action=maj&entite=produit', $this->frm);
        $this->frm = str_replace('{lblBouton}', 'Mettre à jour', $this->frm);
        $this->frm = str_replace('readonly', '', $this->frm);
        $this->displayForm();        
    }

    public function displayDelete($produit) {
        $this->feelFrm($produit);
        $this->frm = str_replace('{lblBouton}', 'Supprimer', $this->frm);
        $this->frm = str_replace('{postAction}', './index.php?action=del&entite=produit', $this->frm);
        $this->displayForm();        
    }
    
    private function feelFrm($produit){
        $this->frm = str_replace('{id}', $produit->id, $this->frm);
        $this->frm = str_replace('{nom}', $produit->nom, $this->frm);
        $this->frm = str_replace('{reference}', $produit->reference , $this->frm);
        $this->frm = str_replace('{quantite}', $produit->quantite , $this->frm);
        $this->frm = str_replace('{commentaire}', $produit->commentaire , $this->frm);
        $this->frm = str_replace('{id_fournisseur}', $produit->id_fournisseur , $this->frm);
    }
     
}
