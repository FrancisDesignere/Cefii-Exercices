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
    }
    
    public function dispatch() 
    {
        $page = (isset($_GET['page']))?$_GET['page']:"accueil";
        $table = (isset($_GET['table']))?$_GET['table']:"produit";

        switch ($page) {
            case 'list':
                $list = $this->model->getList($table);
                $this->view->displayList($list);
                break;
            default:
                $this->view->displayPageHtml($page);
                break;
        }
    }    
}    
