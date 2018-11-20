<?php
/**
 * Classe spécialisant View pour l'affichage du formulaire "fiche catégorie"
 */
class CategoryView extends View
{
    /**
     * le constructeur récupère le template html du formulaire de saisie de catégorie
     * il l'initie avec l'attribut $frm
     */
    function __construct() {
        parent::__construct();
        $this->frm = file_get_contents('view/html/frmCategory.html');
    }        

    /**
     * cette méthode remplace les "étiquettes" du template pour qu'il corresponde à la création
     * 
     *      vidage des zone de saisie, (pour laisser s'afficher les 'placeholder')
     *      personalisation du bouton (libellé 'ajouter')
     *      suppression du readonly des zones de saisie
     *      pose de l'action (pour correspondre à l'ajout de catégorie)
     */
    public function displayAdd() {
        $this->frm = str_replace('{id}', '', $this->frm);
        $this->frm = str_replace('{nom}', '', $this->frm);
        $this->frm = str_replace('{description}', '', $this->frm);
       $this->frm = str_replace('{postAction}', './index.php?action=add&entite=category', $this->frm);
        $this->frm = str_replace('{lblBouton}', 'Ajouter', $this->frm);
        $this->frm = str_replace('readonly', '', $this->frm);
        $this->displayForm();        
    }
    
    /**
     * cette méthode remplace les "étiquettes" du template pour qu'il corresponde à la modification
     * 
     *      appel de la méthode de remplissage des zones de saisie (avec les valeur de la catégorie) 
     *      personalisation du bouton (libellé 'Mettre à jour')
     *      suppression du readonly des zones de saisie
     *      pose de l'action (pour correspondre à l'udpate de catégorie)
     * 
     * @param objet $category correspondant à la catégorie à modifier (et ses attributs) 
     */ 
    public function displayUpdate($category) {
        $this->feelFrm($category);
        $this->frm = str_replace('{postAction}', './index.php?action=maj&entite=category', $this->frm);
        $this->frm = str_replace('{lblBouton}', 'Mettre à jour', $this->frm);
        $this->frm = str_replace('readonly', '', $this->frm);
        $this->displayForm();        
    }
    
    /**
     * cette méthode remplace les "étiquettes" du template pour qu'il corresponde à la suppression
     * 
     *      appel de la méthode de remplissage des zones de saisie (avec les valeur de la catégorie) 
     *      personalisation du bouton (libellé 'Supprimer')
     *      pose de l'action (pour correspondre à la suppressionn de catégorie)
     *      à noter : le readonly des zones de saisie est ici conservé
     * 
     * @param objet $category correspondant à la catégorie à modifier (et ses attributs) 
     */
    public function displayDelete($category) {
        $this->feelFrm($category);
        $this->frm = str_replace('{lblBouton}', 'Supprimer', $this->frm);
        $this->frm = str_replace('{postAction}', './index.php?action=del&entite=category', $this->frm);
        $this->displayForm();        
    }
    
    /**
     * Methode privée pour le remplissage des zonnes de saisie avec les valeurs de la catégorie
     * 
     * @param objet $category correspondant à la catégorie à modifier (et ses attributs) 
     */
    private function feelFrm($category){
        $this->frm = str_replace('{id}', $category->id, $this->frm);
        $this->frm = str_replace('{nom}', $category->nom, $this->frm);
        $this->frm = str_replace('{description}', $category->description, $this->frm);
    }
    
    public function displayList($list, $entite) {
        parent::displayList($list, $entite);
    }
    
}
