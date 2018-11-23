<?php
/**
 * Controller pour les clients, il hérite de la classe Controller 
 * sur laquelle il repose en totalité
 */
class ClientController extends Controller
{
    public function __construct() 
    {
        parent::switchAction();
    }
}    
