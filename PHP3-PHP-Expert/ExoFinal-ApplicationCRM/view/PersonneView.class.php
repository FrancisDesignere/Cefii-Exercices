<?php
class PersonneView extends View
{
    
    function __construct() {
        parent::__construct();
        $this->frm = file_get_contents('view/html/frmPersonne.html');
    }
    
    public function displayAdd($categories) {
        //$this->feelFrm();
        $this->feelFrm($categories);
        $this->frm = str_replace('{postAction}', './index.php?action=add&entite=personne', $this->frm);
        $this->frm = str_replace('{lblBouton}', 'Ajouter', $this->frm);
        $this->frm = str_replace('readonly', '', $this->frm);
        $this->frm = str_replace('disabled', '', $this->frm);
        $this->displayForm();
    }
    
    public function displayUpdate($personne, $categories) {
        $this->feelFrm($categories, $personne);
        $this->frm = str_replace('{postAction}', './index.php?action=maj&entite=personne', $this->frm);
        $this->frm = str_replace('{lblBouton}', 'Mettre à jour', $this->frm);
        $this->frm = str_replace('readonly', '', $this->frm);
        $this->frm = str_replace('disabled', '', $this->frm);
        $this->displayForm();        
    }

    public function displayDelete($personne, $categories) {
        //$this->feelFrm($personne);
        $this->feelFrm($categories, $personne);
        $this->frm = str_replace('{lblBouton}', 'Supprimer', $this->frm);
        $this->frm = str_replace('{postAction}', './index.php?action=del&entite=personne', $this->frm);
        $this->displayForm();        
    }
    
    protected function feelFrm($categories, $personne = null){  
 
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
        // pour le select des catégories, on remplie une variable avec l'option pour chaque catég
        // (cf fonction addLstCateg) et on remplace l'étiquette lstCateg du template
        $lstCateg = $this->addLstCateg($categories, $personne);
        $this->frm = str_replace('{lstCateg}', $lstCateg , $this->frm);       
}    
    
    protected function addLstCateg($categories, $personne=null, $SelectedCateg=1){
        $optsCateg ='';
        foreach($categories as $categ){
            // la variable toBeSelected posera 'selected' sur la catégorie actuel de l'item
            // ou bien sur la 1ere catégorie
            $toBeSelected='';
            if ($personne != null){
                if ($categ['id'] == $personne->fk_id_category){
                    $toBeSelected='selected';
                }
            }else{ // cas des création, le selected sera posé sur la première catégorie
                if ($categ['id'] == $SelectedCateg ){
                    $toBeSelected='selected';
                }
            }
            $optsCateg .= '<option value="'.$categ['id'].'" '.$toBeSelected.'><abbr title="'.$categ['description'].'">'.$categ['nom'].'</abbr></option>';
        }
        return $optsCateg;
    }
}
