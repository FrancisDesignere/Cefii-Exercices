<?php
/**
 * La classe Dispactcher recoit les indications transmise via paramètres à l'index.
 * A partir de celle ci, elle instancie le controler et la méthode concernée.
 * 
 */
class Dispatcher 
{

    
    /**
     * dispatcher permet d'instancier les viewer, modeler et controller correspondant à l'entité attendue
     *
     *      A noter, le cas particulier des entités client et prospect routé vers le model "personneModel"
     *      (celui ci gérant les 2)
     */
    public function __construct() 
    {
        
        $cleanGet = filter_input_array(INPUT_GET);
        $cleanPost = filter_input_array(INPUT_POST);
        
        $action = (isset($cleanGet['action']))?$cleanGet['action']:"listItems";
        $entite = (isset($cleanGet['entite']))?$cleanGet['entite']:"accueil";
        if(isset($cleanPost['itemId'])) {
            $itemId = $cleanPost['itemId'];
        }
        
        // pour la classe controleur 
        $strClassController = ucfirst($entite).'Controller';
        $entController = new $strClassController();
        if(isset($cleanPost)){
            $entController->$action($cleanPost);
        }else{
            $entController->$action();            
        }
     
        
    }
}    
