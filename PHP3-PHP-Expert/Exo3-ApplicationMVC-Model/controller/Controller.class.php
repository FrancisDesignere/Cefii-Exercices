<?php
/**
 *  class du controller principal avec pour role principal 
 * le dispactch vers les différents Model et Viewer
 *  
 */
class Controller 
{
    private $view;
    
    public function __construct() 
    {
        $this->view = new View();
    }
    
    public function dispatch() 
    {
        $action = (isset($_GET['action']))?$_GET['action']:"accueil";
        $entite = (isset($_GET['entite']))?$_GET['entite']:"user";
        
        // instanciation avec un nom de classe dynamique, en fonction de l'entité
        $strClassModel = ucfirst($entite).'Model';
        $objModel = new $strClassModel();
        //à faire à l'identique pour les 
        $strClassView = ucfirst($entite).'View';
        //$objView = new $strClassView();

            
        switch ($action) {
            case 'list':
                $list = $objModel->getList($entite);
                $this->view->displayList($list);
                break;
            
            case 'add':
                ////$newItem provisoirement setté en dur, à remplacer par $newItem = new $classView();
                $newItem =  array('nom'=>'toto', 'prenom'=>'titi', 'ville'=>'tatu');
                
                $objModel->insert($newItem);
                break;

            case 'maj':
                 ////$newItem provisoirement setté en dur, à remplacer par $newItem = new $classView();
                $majItem =  array('id'=>1,'nom'=>'Désignère', 'prenom'=>'Francis', 'ville'=>date("H:i:s"));
        
                $objModel->update($majItem);
                break;
            
            case 'del':
                ////$newUsr provisoirement setté en dur, l'id sera à récupérer un post;
                $item2del = 3;

                $objModel->delete($item2del);
                break;                
                
            default:
                $this->view->displayPageHtml($action);
                break;
        }

        //si action upsert ou delete, retour vers la liste correspondante
        if ($action == 'add' || $action =='del' || $action =='maj'){
            $list = $objModel->getList($entite);
            $this->view->displayList($list);   
        }
    }    
}    
