<?php

class View
{
    private $page;
    
    /** le constructeur rempli déjà page avec le header */
    function __construct() {
        $this->page = file_get_contents('view/html/header.html');
    }
    
    /** Affichage de la page */
    private function display() {
        // lien retour accueil
        $this->page .= '<a  href="./index.php">retour page accueil</a>';

        $this->page .= file_get_contents('view/html/footer.html');

        echo $this->page;
    }
    
    /** Alimentation de la page demandée de  (solution non générique) */
    public function displayPageHtml($page){
        $this->page .= file_get_contents('view/html/' . $page . '.html');
        $this->display();
    }
            
    /** Alimentation de la page liste à partir d’un tableau reçu par paramètre */
    public function displayList($list) {
        $entete = true;
        $this->page .= "<table border=1>";
        foreach ($list as $item) {
            if ($entete){
                $this->page .= "<tr>";
                foreach ($item as $key=>$element) {
                    $this->page .= "<td>".$key."</td>";        
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
