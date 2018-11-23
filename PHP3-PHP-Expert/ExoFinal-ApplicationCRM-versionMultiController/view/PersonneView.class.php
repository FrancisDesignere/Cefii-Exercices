<?php
/**
 * Classe spécialisant View pour l'affichage du formulaire "fiche personne"
 */
abstract class PersonneView extends View
{
    
    /**
     * le constructeur récupère le template html du formulaire de saisie de personne
     * il l'initie avec l'attribut $frm
     */
    function __construct() {
        parent::__construct();
        $this->frm = file_get_contents('view/html/frmPersonne.html');
    }
    
    /**
     * cette méthode remplace les "étiquettes" du template pour qu'il corresponde à la création
     * 
     *      fait uniquement ici pour les remplacements commun aux 2 classes filles (qui feront le reste)
     *      C'est à dire la personnalisation du bouton action, la pose de l'action (add personne), 
     *       la suppression du readonly et du disabled pour oter la lecture seule des zonnes de saisie et select.
     *      Le reste étant confié à la méthode feelFrm, appelée avec le parametres transmis.
     *      A noter : le remplacement de {postAction} est déjà fait par la classe enfant, il n'est mis là 
     *       que pour couvrir le cas hypothétique d'une future utilisation de cette classe personne en direct
     * 
     * @param objet $categories la liste des catégories, dont le nom et l'id seront transmis à feelFrm pour la construction du select
     * @param type $defaultCateg également transmis à feelFrm pour préciser la catégorie par défaut (0:prospect ou 1: nouveau client)
     */
    public function displayAdd($categories, $defaultCateg=1) {
        $this->feelFrm($categories, null, $defaultCateg );
        $this->frm = str_replace('{postAction}', './index.php?action=add&entite=personne', $this->frm);
        $this->frm = str_replace('{lblBouton}', 'Ajouter', $this->frm);
        $this->frm = str_replace('readonly', '', $this->frm);
        $this->frm = str_replace('disabled', '', $this->frm);
        $this->displayForm();
    }
    
    /**
     * cette méthode remplace les "étiquettes" du template pour qu'il corresponde à la mise à jout
     * 
     *      fait uniquement ici pour les remplacements commun aux 2 classes filles (qui feront le reste)
     *      C'est à dire la personnalisation du bouton action, la pose de l'action (maj personne), 
     *       la suppression du readonly et du disabled pour oter la lecture seule des zonnes de saisie et select.
     *      Le reste étant confié à la méthode feelFrm, appelée avec le parametres transmis.
     *      A noter : le remplacement de {postAction} est déjà fait par la classe enfant, il n'est mis là 
     *       que pour couvrir le cas hypothétique d'une future utilisation de cette classe personne en direct
     * 
     * @param objet $personne correspondant à la personne (et ses attributs) à mettre à jour (sera transmis à feelfrm)
     * @param objet $categories la liste des catégories, dont le nom et l'id seront transmis à feelFrm pour la construction du select
     */
    public function displayUpdate($personne, $categories) {
        $this->feelFrm($categories, $personne);
        $this->frm = str_replace('{postAction}', './index.php?action=maj&entite=personne', $this->frm);
        $this->frm = str_replace('{lblBouton}', 'Mettre à jour', $this->frm);
        $this->frm = str_replace('readonly', '', $this->frm);
        $this->frm = str_replace('disabled', '', $this->frm);
        $this->displayForm();        
    }

    /**
     * cette méthode remplace les "étiquettes" du template pour qu'il corresponde à la suppression
     * 
     *      fait uniquement ici pour les remplacements commun aux 2 classes filles (qui feront le reste)
     *      C'est à dire la personnalisation du bouton action, la pose de l'action (del personne), 
     *      Le reste étant confié à la méthode feelFrm, appelée avec le parametres transmis.
     *      A noter : 
     *       - le remplacement de {postAction} est déjà fait par la classe enfant, il n'est mis là 
     *         que pour couvrir le cas hypothétique d'une future utilisation de cette classe personne en direct
     *       - pas de suppression du readonly et du disabled pour rester en lecture seule des zonnes de saisie et select.
     * 
     * @param objet $personne correspondant à la personne (et ses attributs) à mettre à jour (sera transmis à feelfrm)
     * @param objet $categories la liste des catégories, dont le nom et l'id seront transmis à feelFrm pour la construction du select
     */
    public function displayDelete($personne, $categories) {
        $this->feelFrm($categories, $personne);
        $this->frm = str_replace('{lblBouton}', 'Supprimer', $this->frm);
        $this->frm = str_replace('{postAction}', './index.php?action=del&entite=personne', $this->frm);
        $this->displayForm();        
    }
    
    /**
     * Methode pour mettre à jour le formulaire($frm) avec les données de la personne (si fourni) ou vidage (création).
     * et appel de la méthode addLstCateg pour la construction du select de catégories
     * 
     * @param objet $categories la liste des catégories, dont le nom et l'id seront transmis à feelFrm pour la construction du select
     * @param objet $personne correspondant à la personne (et ses attributs) à mettre à jour (sera transmis à feelfrm)
     * @param type $defaultCateg également transmis à feelFrm pour préciser la catégorie par défaut (0:prospect ou 1: nouveau client)
     */
    protected function feelFrm($categories, $personne = null, $defaultCateg=1){  
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
        $lstCateg = $this->addLstCateg($categories, $personne, $defaultCateg);
        $this->frm = str_replace('{lstCateg}', $lstCateg , $this->frm);       
}    
    
    /**
     * Cette méthode retourne un string qui correspondra aux options du select des catégories
     * 
     * @param objet $categories la liste des catégories, dont le nom et l'id à mettre en libellé et value du chaque option
     * @param objet $personne correspondant à la personne qui permettra de mettre en select la catégorie actuelle de la personne
     * @param string $defaultCateg pour préciser la catégorie par défaut en cas de création (0:prospect ou 1: nouveau client)
     * 
     * @return string
     */
    protected function addLstCateg($categories, $personne=null, $defaultCateg=1){
        $optsCateg ='';
        foreach($categories as $categ){
            // la variable toBeSelected posera 'selected' sur la catégorie actuel de l'item
            // ou bien sur la catégorie par défaut
            $toBeSelected='';
            if ($personne != null){
                if ($categ['id'] == $personne->fk_id_category){
                    $toBeSelected='selected';
                }
            }else{ // cas des créations (appel sans 'personne')
                if ($categ['id'] == $defaultCateg ){
                    $toBeSelected='selected';
                }
            }
            $optsCateg .= '<option value="'.$categ['id'].'" '.$toBeSelected.'>'.$categ['nom'].'</option>';
        }
        return $optsCateg;
    }
}
