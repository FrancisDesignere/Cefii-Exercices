<?php

/**
 *  class du controller principal
 */
class Controller 
{
    private $view;
    private $model;
    
    public function __construct() 
    {
        $this->view = new View();
        $this->model = new Model();
////        $this->conn = new Connect();        
    }
    
    public function dispatch() 
    {
        $page = (isset($_GET['page']))?$_GET['page']:"home";
        $table = (isset($_GET['table']))?$_GET['table']:"produit";

        switch ($page) {
            case 'home':
                $this->view->displayHome();
                break;
            case 'list':
                $list = $this->model->getList($table);
                $this->view->displayList($list);
                break;
            case 'edito':
                $this->view->displayPageHtml('edito');
                break;
            default:
                $this->view->displayPageHtml($page);
                break;
        }
    }    
}    
