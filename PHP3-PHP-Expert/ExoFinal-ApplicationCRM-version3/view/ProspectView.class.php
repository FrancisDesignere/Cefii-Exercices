<?php
/**
 * Classe fille de personneView spécialisant le formulaire pour les prospects
 * 
 *      avec notemment la gestion des affichage/masquage des select de catégorie
 *      et du bouton "passer en nouveau client"
 */
class ProspectView extends PersonneView
{
    
    function __construct() {
        parent::__construct();
    }

    /**
     * cette méthode remplace les "étiquettes" du template pour qu'il corresponde à la création
     * 
     *      Plus précisement fait uniquement ici les remplacements spécialisant les prospects
     *        C'est à dire la personnalisation du titre, la pose de l'action (add prospect), 
     *        le masquage du select des catégories (puisqu'on connait la categ d'un prospect).
     *        à noter : la valeur par défaut posé à 1 pour que les créations soient catégorisés en prospect
     *      Le reste (commun à prospect et client) étant confié à la méthode du parent par appel
     * 
     * @param objet $categories la liste des catégories, dont le nom et l'id seront transmis au parent pour la construction du select
     * @param type $defaultCateg également transmis au parent pour préciser la catégorie par défaut (0:prospect ou 1: nouveau client)
     */
    public function displayAdd($categories, $defaultCateg=1) {
        $this->frm = str_replace('Renseignements Personne', 'Renseignements Prospect', $this->frm);
        $this->frm = str_replace('{displayCateg}', 'style="display:none"', $this->frm);
        $this->frm = str_replace('{postAction}', './index.php?action=add&entite=prospect', $this->frm);         
        parent::displayAdd($categories, $defaultCateg);
    }
    
    /**
     * cette méthode remplace les "étiquettes" du template pour qu'il corresponde à la mise à jour
     * 
     *      Plus précisement fait uniquement ici les remplacements spécialisant les prospects
     *        C'est à dire la personnalisation du titre, la pose de l'action (maj prospect), 
     *        et enlève le masquage du bouton de "passage en nouveau client" (à afficher uniquement dans ce cas).
     *      Le reste (commun à prospect et client) étant confié à la méthode du parent par appel
     * 
     * @param objet $personne correspondant à la personne (et ses attributs) qui seront transmis au parent.
     * @param objet $categories la liste des catégories, dont le nom et l'id seront transmis au parent pour la construction du select
     */
    public function displayUpdate($personne, $categories) {
        $this->frm = str_replace('Renseignements Personne', 'Renseignements Prospect', $this->frm);
        $this->frm = str_replace('{postAction}', './index.php?action=maj&entite=prospect', $this->frm);
        $this->frm = str_replace('id="btnNewClient" style="display:none"', 'id="btnNewClient"', $this->frm);
        parent::displayUpdate($personne, $categories);
    }

    /**
     * cette méthode remplace les "étiquettes" du template pour qu'il corresponde à la suppression
     * 
     *      Plus précisement fait uniquement ici les remplacements spécialisant les prospects
     *        C'est à dire la personnalisation du titre, la pose de l'action (del prospect), 
     *        le masquage du select des catégories (puisqu'on connait la categ d'un prospect).
     *      Le reste (commun à prospect et client) étant confié à la méthode du parent par appel
     * 
     * @param objet $personne correspondant à la personne (et ses attributs) qui seront transmis au parent.
     * @param objet $categories la liste des catégories, dont le nom et l'id seront transmis au parent pour la construction du select
     */
    public function displayDelete($personne, $categories) {
        $this->frm = str_replace('Renseignements Personne', 'Prospect à supprimer', $this->frm);
        $this->frm = str_replace('{postAction}', './index.php?action=del&entite=prospect', $this->frm);
        $this->frm = str_replace('{displayCateg}', 'style="display:none"', $this->frm);
        parent::displayDelete($personne, $categories);
    }        
}
