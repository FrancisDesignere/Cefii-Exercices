<?php
/**
 * La classe Dispactcher recoit les indications transmise via paramètres à l'index.
 * A partir de celle ci, elle instancie le controler et la méthode concernée.
 * 
 */
class Dispacther 
{
    static $model;
    /**
     * lstCateg contient la liste des categories récupérée par requete à l'instanciation et conservée.
     */
    static $lstCateg;
    
    
    static $cleanGet;
    static $cleanPost;
    static $action;
    static $entite;
    static $itemId;
    
    static $entModel;
    static $entView;

    /**
     * le contructeur de la classe controller initie les attributs static grace aux infos recues en get ou post
     *
     *      Le demandes de simple navigation sont recues par get, les demandes entrainant des changements
     *      sont recus par post.
     *      il récupère également la liste des catégories, qui sera passée aux ClientView et ProspectView 
     *      pour la construction du select des categories
     * 
     */    
    public function __construct() 
    {
        self::$model = new Model();
        self::$lstCateg = self::$model->getList('category');

        self::$cleanGet = filter_input_array(INPUT_GET);
        self::$cleanPost = filter_input_array(INPUT_POST);
        
        self::$action = (isset(self::$cleanGet['action']))?self::$cleanGet['action']:"accueil";
        self::$entite = (isset(self::$cleanGet['entite']))?self::$cleanGet['entite']:"Category";
        if(isset(self::$cleanPost['itemId'])) {
            self::$itemId = self::$cleanPost['itemId'];
        }else{
            self::$itemId = '';
        }        
    }
    
    /**
     * dispatch permet d'instancier les viewer, modeler et controller correspondant à l'entité attendue
     *
     *      A noter, le cas particulier des entités client et prospect routé vers le model "personneModel"
     *      (celui ci gérant les 2)
     */
    public function dispatcher() 
    {
     // instanciation avec un nom de classe dynamique, en fonction de l'entité
        // pour la classe model à utiliser
        if(self::$entite=='client' || self::$entite=='prospect'){
            // une spécifité pour les  entités client et prospect qui s'appuie sur le model personne
            $strClassModel= 'PersonneModel';
        }else{
            $strClassModel = ucfirst(self::$entite).'Model';            
        }
        self::$entModel = new $strClassModel();
        
        // pour la classe view à utiliser
        $strClassView = ucfirst(self::$entite).'View';
        self::$entView = new $strClassView();

        // pour la classe controleur (à instancier en dernier car dépendante des autres)
        $strClassController = ucfirst(self::$entite).'Controller';
        $entController = new $strClassController();

    }
        
    /**
     *  cette méthode permet d'appeler les méthodes des viewer et/ou modeler en fonction de l'action demandée
     * 
     *      Les différentes demandes correspondent soit à l'affichage des listes ou des formulaires
     *      soit à actions de mise à jour, création, suppression
     *      suivant le cas, le dispatch demande donc des affichages de formulaires aux viewers
     *      ou bien des actions à effectuer en base aux modelers
     */
    protected function switchAction(){
        switch (self::$action) {
            
            case 'list': //les listes sont construites pas le Viewer générique                 
                $list = self::$model->getList(self::$entite);
                self::$entView->displayList($list, self::$entite);
                break;
            
            case 'frm':
                if (self::$itemId == ''){
                    self::$entView->displayAdd(self::$lstCateg);                
                }else{
                    $objItem = self::$entModel->getItemById(self::$itemId);
                    if(self::$entite == 'prospect'|| self::$entite == 'client'){
                        self::$entView->displayUpdate($objItem, self::$lstCateg);
                    }else{
                        self::$entView->displayUpdate($objItem);
                    }
                }
                break;

            case 'frmDel':
                if (self::$itemId <> ''){
                   $objItem = self::$entModel->getItemById(self::$itemId);
                   self::$entView->displayDelete($objItem, self::$lstCateg);
                }
                break;
                
            case 'add':
                    self::$entModel->insert(self::$cleanPost);
                break;
                
            case 'maj':
                if (isset(self::$cleanPost['id'])){
                    self::$entModel->update(self::$cleanPost);
                }
                break;
            
            case 'del':
                if (isset(self::$cleanPost['id'])){
                    self::$entModel->delete(self::$cleanPost);
                }
                break; 

            default:
                self::$entView->displayPageHtml(self::$action);
                break;
        }

        //si action upsert ou delete, retour vers la liste correspondante
        if (self::$action == 'add' || self::$action =='del' || self::$action =='maj'){        
            // une condition spécifique pour envoyer sur la bonne liste lors des passages de prospect à client
            if((isset(self::$cleanPost['btnNewClient'])||(isset(self::$cleanPost['fk_id_category']) && (self::$cleanPost['fk_id_category']>1) ))){self::$entite = 'client';}
            
            $list = self::$model->getList(self::$entite);
            self::$entView->displayList($list, self::$entite);
        }
    }    
}    
