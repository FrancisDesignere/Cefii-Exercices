<?php
/**
 * Controller a pour role principal le dispactch vers les différents Model et Viewer
 * 
 * @author francis
 */
class Controller 
{
    private $model;
    /**
     * lstCateg contient la liste des categories récupérée par requete à l'instanciation et conservée.
     */
    static $lstCateg;

    /**
     * le contructeur de la classe controller 
     * 
     *      il récupère notamment la liste des catégories, qui sera passée aux ClientView et ProspectView 
     *      pour la construction du select des categories
     * 
     */    
    public function __construct() 
    {
        $this->model = new Model();
        self::$lstCateg = $this->model->getList('category');
    }
    
    /**
     * dispatche au viewer et/ou modeler correspondant suivant la demande recue par get ou post
     * 
     *      Le demandes de simple navigation sont recues par get, les demandes entrainant des changements
     *      sont recus par post.
     *      Les différentes demandes correspondent soit à l'affichage des listes ou des formulaires
     *      soit à actions de mise à jour, création, suppression
     *      suivant le cas, le dispatch demande donc des affichages de formulaires aux viewers
     *      ou bien des actions à effectuer en base aux modelers
     */
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
        
        // instanciation avec un nom de classe dynamique, en fonction de l'entité
        // pour la classe model à utiliser
        if($entite=='client' || $entite=='prospect'){
            // une spécifité pour les  entités client et prospect qui s'appuie sur le model personne
            $strClassModel= 'PersonneModel';
        }else{
            $strClassModel = ucfirst($entite).'Model';            
        }
        $entModel = new $strClassModel();
        
        // pour la classe view à utiliser
        $strClassView = ucfirst($entite).'View';
        $entView = new $strClassView();
        
        
        // prise ne compte des différents cas d'action demandées
        switch ($action) {
            
            case 'list': //les listes sont construites pas le Viewer générique 
                $list = $this->model->getList($entite);
                $entView->displayList($list, $entite);
                break;
            
            case 'frm':
                if ($itemId == ''){
                    $entView->displayAdd(self::$lstCateg);                
                }else{
                    $objItem = $entModel->getItemById($itemId);
                    if($entite == 'prospect'|| $entite == 'client'){
                        $entView->displayUpdate($objItem, self::$lstCateg);
                    }else{
                        $entView->displayUpdate($objItem);
                    }
                }
                break;

            case 'frmDel':
                if ($itemId <> ''){
                   $objItem = $entModel->getItemById($itemId);
                   $entView->displayDelete($objItem, self::$lstCateg);
                }
                break;
                
            case 'add':
                    $entModel->insert($cleanPost);
                break;
                
            case 'maj':
                if (isset($cleanPost['id'])){
                    $entModel->update($cleanPost);
                }
                break;
            
            case 'del':
                if (isset($cleanPost['id'])){
                    $entModel->delete($cleanPost);
                }
                break; 

            default:
                $entView->displayPageHtml($action);
                break;
        }

        //si action upsert ou delete, retour vers la liste correspondante
        if ($action == 'add' || $action =='del' || $action =='maj'){        
            // une condition spécifique pour envoyer sur la bonne liste lors des passages de prospect à client
            if((isset($cleanPost['btnNewClient'])||(isset($cleanPost['fk_id_category']) && ($cleanPost['fk_id_category']>1) ))){$entite = 'client';}
            
            $list = $this->model->getList($entite);
            $entView->displayList($list, $entite);
        }
    }    
}    
