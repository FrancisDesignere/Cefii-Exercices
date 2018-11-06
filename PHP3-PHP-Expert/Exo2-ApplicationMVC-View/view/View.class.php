<?php

class View
{
    private $page;
    
    /** le constructeur rempli déjà page avec le header */
    function __construct() {
        $this->page = file_get_contents('view/html/header.html');
        $this->page .= file_get_contents('view/html/nav.html');
    }
    
    /** Affichage de la page */
    private function display() {
        $this->page .= file_get_contents('view/html/footer.html');

        // gestion de la bascule serveur local > serveur cefii
        if ($_SERVER['HTTP_HOST']=="cefii-developpements.fr"){
            $this->page = str_replace('http://exoscefii/', 'http://cefii-developpements.fr/francis827/',$this->page);
            //passage remplacement des fichier boostrap par leur version minimisée
            // (ou eventuellement pointer vers le ressources cdn (voir https://www.bootstrapcdn.com/)
            // à noter également pour éviter le replace en prod, je devrais peut etre faire le contraire ...
            $this->page = str_replace('bootstrap.css', 'bootstrap.min.css',$this->page);
            $this->page = str_replace('bootstrap-theme.css', 'bootstrap-theme.min.css',$this->page);
            $this->page = str_replace('bootstrap.js', 'bootstrap.min.js',$this->page);
        }
        echo $this->page;
    }
    
    /** Alimentation de la page demandée */
    public function displayPageHtml($page){
        $this->page .= file_get_contents('view/html/' . $page . '.html');
        $this->display();
    }
            
    /** Alimentation de la page liste à partir d’un tableau reçu par paramètre */
    public function displayList($list) {
        $entete = true;
        $this->page .= '<table class="table table-bordered table-striped table-condensed">';
        foreach ($list as $item) {
            if ($entete){
                $this->page .= "<tr>";
                foreach ($item as $key=>$element) {
                    $this->page .= "<th>".$key."</th>";        
                }
                $this->page .= "</tr>";
                $entete = FALSE;
            };
            $this->page .= "<tr>";
            foreach ($item as $key=>$element) {
                $this->page .= "<td>".$element."</td>";
            }            
            $this->page .= "</tr>";
        }
        $this->page .= "</table>";
        $this->display();
    }
}
