<?php

/**
 * Classe fille de personneView spécialisant le formulaire pour les clients
 */
class ClientView extends PersonneView
{
    
    function __construct() {
        parent::__construct();
    }
    /**
     * cette méthode remplace les "étiquettes" du template pour qu'il corresponde à la création
     * 
     *      Plus précisement fait uniquement ici les remplacements spécialisant les clients
     *        C'est à dire la personnalisation du titre, la pose de l'action (add client), 
     *        à noter : la valeur par défaut posé à 2 pour que les créations soient catégorisés par défaut 
         *     sur la première des catégorie client ("nouveau client")
     *      Le reste (commun à prospect et client) étant confié à la méthode du parent par appel
     * 
     * @param objet $categories la liste des catégories, dont le nom et l'id seront transmis au parent pour la construction du select
     * @param type $defaultCateg également transmis au parent pour préciser la catégorie par défaut (0:prospect ou 1: nouveau client)
     */
    public function displayAdd($categories, $defaultCateg=2) {
        $this->frm = str_replace('Renseignements Personne', 'Renseignements Client', $this->frm);
        $this->frm = str_replace('{postAction}', './index.php?action=add&entite=client', $this->frm); 
        parent::displayAdd($categories, $defaultCateg);
    }
    
    /**
     * cette méthode remplace les "étiquettes" du template pour qu'il corresponde à la mise à jour
     * 
     *      Plus précisement fait uniquement ici les remplacements spécialisant les prospects
     *        C'est à dire la personnalisation du titre, la pose de l'action (maj prospect), 
     *      Le reste (commun à prospect et client) étant confié à la méthode du parent par appel
     * 
     * @param objet $personne correspondant à la personne (et ses attributs) qui seront transmis au parent.
     * @param objet $categories la liste des catégories, dont le nom et l'id seront transmis au parent pour la construction du select
     */
    public function displayUpdate($personne, $categories) {
        $this->frm = str_replace('Renseignements Personne', 'Renseignements Client', $this->frm);
        $this->frm = str_replace('{postAction}', './index.php?action=maj&entite=client', $this->frm);        
        parent::displayUpdate($personne, $categories);
    }    

    /**
     * cette méthode remplace les "étiquettes" du template pour qu'il corresponde à la suppression
     * 
     *      Plus précisement fait uniquement ici les remplacements spécialisant les prospects
     *        C'est à dire la personnalisation du titre, la pose de l'action (maj prospect), 
     *      Le reste (commun à prospect et client) étant confié à la méthode du parent par appel
     * 
     * @param objet $personne correspondant à la personne (et ses attributs) qui seront transmis au parent.
     * @param objet $categories la liste des catégories, dont le nom et l'id seront transmis au parent pour la construction du select
     */    
    public function displayDelete($personne, $categories) {
        $this->frm = str_replace('Renseignements Personne', 'Client a supprimer', $this->frm);
        $this->frm = str_replace('{postAction}', './index.php?action=del&entite=client', $this->frm);        
        parent::displayDelete($personne, $categories);
    }  
    
}
