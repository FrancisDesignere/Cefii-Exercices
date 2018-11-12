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
    static $lstCateg;
    
    public function __construct() 
    {
        $this->view = new View();
        $this->model = new Model();
        self::$lstCateg = $this->model->getList('category');
    }
    
    public function dispatch() 
    {
        $cleanGet = filter_input_array(INPUT_GET);
        $cleanPost = filter_input_array(INPUT_POST);
        $action = (isset($cleanGet['action']))?$cleanGet['action']:"accueil";
        $entite = (isset($cleanGet['entite']))?$cleanGet['entite']:"Category";
        if(isset($cleanPost['itemId'])) {
            $itemId = $cleanPost['itemId'];
        }else{
            $itemId = '';
        }
        
        if(($_SERVER['HTTP_HOST']=="cefii-developpements.fr")){
            // solution moins évolutive pour le serveur cefii 
            // car la solution dynamique (instanciation d'une classe par un nom dans une variable) 
            // ne marche pas sur le serveur cefii ??
            if ($entite=='produit'){
                $objModel = new ProduitModel();
                $objView = new ProduitView();
            }elseif($entite=='fournisseur'){
                $objModel = new FournisseurModel();
                $objView = new FournisseurView();
            }else{
                $objModel = new UserModel();
                $objView = new UserView();
            }

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
            $objView = new $strClassView();
        }
        switch ($action) {
            
            case 'list': //les listes sont construite pas le Viewer générique 
                $list = $this->model->getList($entite);
                $this->view->displayList($list, $entite);
                break;
            
            case 'frm':
                if ($itemId == ''){
                    $objView->displayAdd(self::$lstCateg);                
                }else{
                    $objItem = $objModel->getItemById($itemId);
                    if($entite == 'prospect'|| $entite == 'client'){
                        $objView->displayUpdate($objItem, self::$lstCateg);
                    }else{
                        $objView->displayUpdate($objItem);
                    }
                }
                break;

            case 'frmDel':
                if ($itemId <> ''){
                   $objItem = $objModel->getItemById($itemId);
                   $objView->displayDelete($objItem, self::$lstCateg);
                }
                break;
                
            case 'add':
                    $objModel->insert($cleanPost);
                break;
                
            case 'maj':
                if (isset($cleanPost['id'])){
                    $objModel->update($cleanPost);
                }
                break;
            
            case 'del':
                if (isset($cleanPost['id'])){
                    $objModel->delete($cleanPost);
                }
                break; 

            default:
                $this->view->displayPageHtml($action);
                break;
        }

        //si action upsert ou delete, retour vers la liste correspondante
        if ($action == 'add' || $action =='del' || $action =='maj'){
            $list = $this->model->getList($entite);
            $this->view->displayList($list, $entite);
        }
    }    
}    
