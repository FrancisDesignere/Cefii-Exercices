<?php
/**
 *  class du controller principal avec pour role principal 
 * le dispactch vers les différents Model et Viewer
 *  
 */
class Controller 
{
    private $view;
    private $model;
    
    public function __construct() 
    {
        $this->view = new View();
        $this->model = new Model();
    }
    
    public function dispatch() 
    {
        $action = (isset($_GET['action']))?$_GET['action']:"accueil";
        $entite = (isset($_GET['entite']))?$_GET['entite']:"user";
        
        if(($_SERVER['HTTP_HOST']=="cefii-developpements.fr")){
            // en dur pour le serveur cefii car la solution dynamique ne marche pas ??
            $objModel = new UserModel();
            //$objView = new userView;
            
        }else{
            // la solution d'instanciation avec un nom de classe dynamique marche bien en local 
            $strClassModel = $entite.'Model';// autres tentatives '\\'.$entite.'Model'; ou '\\'.__NAMESPACE__.'\\'.$entite.'Model';
            $objModel = new $strClassModel();
            /* autre solution essayée, mais tout aussi infructueuse
              $reflect = new ReflectionClass($strClassModel);
              $objModel = $reflect->newInstance();
             */
            
            //à faire à l'identique pour les 
            $strClassView = $entite.'View';
            //$objView = new $strClassView();
        }

        switch ($action) {
            case 'list':
                $list = $this->model->getList($entite);
                $this->view->displayList($list);
                break;
            
            case 'add':
                ////$newItem provisoirement setté en dur, à remplacer par $newItem = new $classView();
                $newItem =  array('nom'=>'toto', 'prenom'=>'titi', 'ville'=>'tata');
                
                $objModel->Upsert($newItem);
                break;

            case 'maj':
                 ////$newItem provisoirement setté en dur, à remplacer par $newItem = new $classView();
                $majItem =  array('nom'=>'Désignère', 'prenom'=>'Francis', 'ville'=>date("H:i:s"));
        
                $objModel->Upsert($majItem);
                break;
            
            case 'del':
                ////$newUsr provisoirement setté en dur, l'id sera à récupérer un post;
                $item2del = 3;

                $objModel->Delete($item2del);
                break;                
                
            default:
                $this->view->displayPageHtml($action);
                break;
        }

        //si action upsert ou delete, retour vers la liste correspondante
        if ($action == 'add' || $action =='del' || $action =='maj'){
            $list = $this->model->getList($entite);
            $this->view->displayList($list);   
        }
    }    
}    
