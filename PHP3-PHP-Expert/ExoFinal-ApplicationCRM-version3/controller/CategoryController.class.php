<?php
/**
 * Controller pour les catégories, il hérite de la classe Controller 
 * sur laquelle il repose en totalité
 */
class CategoryController extends Controller
{

private $view;
protected $model;


    public function __construct() 
    {
        $this->view = new CategoryView;
        $this->model = new CategoryModel;
    }
    
    public function frm($post=null){
        if ($post == null){
            $this->view->displayAdd();
        }else{
            $objItem = $this->model->getItemById($post);
            $this->view->displayUpdate($objItem);
        }
    }
    
    public function frmDel($itemId =''){
            $objItem = $this->model->getItemById($itemId);
            $this->view->displayDelete($objItem);
    }
    
    public function maj($post){        
        $this->model->update($post);
        $this->listItems();
    }
    
    public function listItems(){
        $list = $this->model->getList('category');
        $this->view->displayList($list, 'category');        
    }
        
}    
