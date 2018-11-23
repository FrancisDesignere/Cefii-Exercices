<?php
/**
 * Controller pour les prospect, il hérite de la classe Controller 
 * sur laquelle il repose en totalité
 */
class ProspectController extends Controller
{
    public function __construct() 
    {
        parent::switchAction();
    }
}    
