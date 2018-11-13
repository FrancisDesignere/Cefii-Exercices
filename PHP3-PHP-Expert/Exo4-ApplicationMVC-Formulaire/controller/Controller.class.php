<?php
/**
 *  class du controller principal avec pour role principal 
 * le dispactch vers les différents Model et Viewer
 *  
 */
class Controller 
{
////    private $view;
 
    
    public function __construct() 
    {
////        $this->view = new View();
    }
    
    public function dispatch() 
    {
        $cleanGet = filter_input_array(INPUT_GET);
        $cleanPost = filter_input_array(INPUT_POST);
        $action = (isset($cleanGet['action']))?$cleanGet['action']:"accueil";
        $entite = (isset($cleanGet['entite']))?$cleanGet['entite']:"user";
        // provisoirement, itemId peut venir de post ou get
        if(isset($cleanGet['itemId'])){
            $itemId = $cleanGet['itemId'];
        }elseif(isset($cleanPost['itemId'])) {
            $itemId = $cleanPost['itemId'];
        }else{
            $itemId = '';
        }

        // instanciation avec un nom de classe dynamique, en fonction de l'entité
        $strClassModel = ucfirst($entite).'Model';// autres tentatives '\\'.$entite.'Model'; ou '\\'.__NAMESPACE__.'\\'.$entite.'Model';
        $objModel = new $strClassModel();

        $strClassView = ucfirst($entite).'View';
        $objView = new $strClassView();

        switch ($action) {
            
            case 'list': //les listes sont construite pas le Viewer générique 
                $list = $objModel->getList($entite);
////                $this->view->displayList($list, $entite);
                $objView->displayList($list, $entite);
                break;
            
            case 'frm':
                if ($itemId == ''){
                    $objView->displayAdd();                
                }else{
                   $objItem = $objModel->getItemById($itemId);
                   $objView->displayUpdate($objItem);
                }
                break;

            case 'frmDel':
                if ($itemId <> ''){
                   $objItem = $objModel->getItemById($itemId);
                   $objView->displayDelete($objItem);
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
////                $this->view->displayPageHtml($action);
                $objView->displayPageHtml($action);
                break;
        }

        //si action upsert ou delete, retour vers la liste correspondante
        if ($action == 'add' || $action =='del' || $action =='maj'){
            $list = $objModel->getList($entite);
////                $this->view->displayList($list, $entite);
                $objView->displayList($list, $entite);

        }
    }    
}    
