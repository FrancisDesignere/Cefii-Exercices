<?php
/**
 * Controller pour les catégories, il hérite de la classe Controller 
 * sur laquelle il repose en totalité
 */
class CategoryController extends Controller
{
    public function __construct() 
    {
        parent::switchAction();
    }
}    
