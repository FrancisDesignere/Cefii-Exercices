<?php
/**
 * la class view prend en charge la construction de la page
 * 
 *      elle assemble les html header, navigation, footer
 *      avec le corps de page (construit par sa methode  displayList
 *      ou par les pages construites par ses classes filles
 *  
 */
abstract class View
{
    /**
     * $page est la variable qui accueille l'assemblage de la page,
     *  qui sera affiché ensuite par un echo final
     */
    protected $page;
    /**
     *$frm acceuil le formulaire construit par une des classes filles 
     */
    protected $frm;
    
    /** 
     * le constructeur rempli d'entrée $page avec le header et le menu
     */
    function __construct() {
        $this->page = file_get_contents('view/html/header.html');
        $this->page .= file_get_contents('view/html/nav.html');
    }
    /**
     * affiche le contenu de $page après l'avoir complété du footer
     */
    protected function display() {
        $this->page .= file_get_contents('view/html/footer.html');
        echo $this->page;
    }
    
    /**
     * Methode ajoutant au formulaire et à la session un tocken avant de l'ajout à $page
     * 
     *      Methode commune utilisée par les view fille 
     *      qui gère les formulaires spécifique aux entités
     */
    protected function displayForm(){
        // ajout du token (dans le formulaire et la session)
        $token = uniqid(rand(), true);
        $_SESSION['token']=$token;
        $this->frm = str_replace('{token}', $token, $this->frm);
        // insertion du frm dans la page 
        $this->page .= $this->frm;
        $this->display();
    }    
    
    /**
     * récupération du fichier html pour intégration à $page
     * @param string $ficHtml : le nom du fichier
     */
    public function displayPageHtml($ficHtml){
        $fileName = 'view/html/' . $ficHtml . '.html';
        if(file_exists($fileName)===true){ 
            $this->page .= file_get_contents($fileName);
        }else{
            $this->page .= "il n'existe pas de page ".$fileName;
        }
        $this->display();          
    }
    /**
     * construction de la liste d'item transmis en paramêtre
     * 
     *      la méthode construit un tableau html avec une colonne par attribut et un ligne par item
     *      plus une colonne 'action' contenant un bouton 'Modifier' et un bouton 'Supprimer'
     * 
     * @param $list string contenant les enregistrements à afficher
     * @param $entite string precisant l'entité qui personnalise le titre et qui sera transmise dans les actions des boutons
     */
    public function displayList($list, $entite) {
        $entete = true;
        $token = uniqid(rand(), true);
        $_SESSION['token']= $token;

        // ajout d'un boutou pour ajout d'un item
        $this->page .= '<h3>Liste des '.$entite.'s</h3>';
        
        // construction d'un tableau pour afficher la liste des enregistrements
        $this->page .= '<table class="table table-bordered table-striped table-condensed">';
        foreach ($list as $item) {
            //gestion de la ligne d'entete (nom des attributs au passage du premier item)
            if ($entete){
                $this->page .= "<tr>";
                foreach ($item as $key=>$element) {
                    $this->page .= "<th>".$key."</th>";        
                }
                $this->page .= "<td>Action</td>";
                $this->page .= "</tr>";
                $entete = FALSE;
            };
           // gestion des valeurs
            $this->page .= "<tr>";
                // boucle sur toutes les valeur d'attribut
                foreach ($item as $key=>$element) {
                    $this->page .= "<td>".$element."</td>";
                }

                //colonne spécifique pour les icones d'action
                $this->page .= "<td>";
                    // les boutonss correspondant aux actions (avec spécificité pour les delete interdit pour categ 1 et 2)
                    $this->page .= '<button form="frmUpdt'.$item['id'].'" id="validModifItem" type="submit" title="modifier" ><span class="glyphicon glyphicon-pencil" ></span></button>'; 
                    if ($entite!='category' || $item['id']>2){// on ne propose pas la poubelle pour les 2 première catégories
                        $this->page .= '<button form="frmDel'.$item['id'].'" id="validModifItem" type="submit" title="modifier" ><span class="glyphicon glyphicon-trash" ></span></button>';                     
                    }
                $this->page .= "</td>";
                
                // les formulaires correspondants aux actions (cachés, mais nécessaires...)
                $this->page .= '<div class="frmAction display-inline">';
                    //le formulaire de maj
                    $this->page .= '<form id="frmUpdt'.$item['id'].'" action="./index.php?action=frm&entite='.$entite.'" method="POST">';
                    $this->page .= '<input type="hidden" name="itemId" value="'.$item['id'].'">';
                    $this->page .= '<input type="hidden" name="token" value="'.$token.'">';
                    $this->page .= '</form>';
                    //formulaire de suppression
                    $this->page .= '<form id="frmDel'.$item['id'].'" action="./index.php?action=frmDel&entite='.$entite.'" method="POST">';
                    $this->page .= '<input type="hidden" name="itemId" value="'.$item['id'].'">';
                    $this->page .= '<input type="hidden" name="token" value="'.$token.'">';
                $this->page .= '</form></div>'; 

            $this->page .= "</tr>";
        }
        $this->page .= "</table>";
        
        // ajout d'un boutou pour ajout d'un item
        $this->page .= "<div>";
        $this->page .= '<a href="./?action=frm&entite='.$entite.'"><button class="btn btn-info "><i class="glyphicon glyphicon-plus"></i> Ajout </button></a>'; 
        $this->page .= "<div>";
        $this->display();
    }
}
