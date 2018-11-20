<?php
/**
 * Controller a pour role principal le dispactch vers les différents Model et Viewer
 * 
 */
abstract class Controller 
{
    /**
     * lstCateg contient la liste des categories récupérée par requete à l'instanciation et conservée.
     */
    static $lstCateg;

    /**
     * le contructeur de la classe controller initie les attributs static grace aux infos recues en get ou post
     * va chercher et stocker (static) la liste des catégories car elle sera utilisée
     * pour les formulaires de client et prospect (select des catégories)
    */    
    public function __construct() 
    {
        $model = new CategoryModel();
        self::$lstCateg = $model->getList('category');
    }  
    
    public function add($item){
        $this->model->insert($item);
        $this->listItems();
    }
    public function del($item){
        $this->model->delete($item);
        $this->listItems();
    }    
    
}    
