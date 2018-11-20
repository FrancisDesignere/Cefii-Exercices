
<?php
/**
 * Controller pour les clients, il hérite de la classe Controller 
 * sur laquelle il repose en totalité
 */
class AccueilController extends Controller
{
    public function __construct() 
    {
        $viewer = new AccueilView;
        $viewer->displayPagehtml('accueil');
    }
}    
