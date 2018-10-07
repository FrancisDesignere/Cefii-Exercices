<?php
    include 'header.html';
    include 'menu.html';
    
    if (isset($_GET['page']) ) {
        
        switch ($_GET['page']) {
        case "presentation":
            include 'presentation.html';
            break;
        case "contact":
            include 'contact.html';
            break;
        default:
            include 'home.html';
            break;
        }
    }

    include 'footer.html';
?>