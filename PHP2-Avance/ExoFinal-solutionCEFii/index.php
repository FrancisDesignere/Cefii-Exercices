<?php
    include "connect.php";
    include "header.html";
	
	$page = isset($_GET['page'])?$_GET['page']:"affiche";
	$table = isset($_GET['table'])?$_GET['table']:"produit";
        $id = isset($_GET['id'])?$_GET['id']:1;
        $id = isset($_POST['id'])?$_POST['id']:$id;

        
	switch($page) {
		case "affiche":
		include $table."/affiche.php";
		break;
		
		case "ajout":
		include $table."/formAjout.php";
		break;
		
		case "ajoutBD":
		include $table."/ajout.php";
		break;
		
		case "supp":
		include $table."/supp.php";
		break;
		
		case "select":
		include $table."/select.php";
		break;
		
		case "formModif":
		include $table."/formModif.php";
		break;
		
		case "modifBD":
		include $table."/modif.php";
		break;
		
		default: 
		echo "Page non trouvée";
		break;
	}
	include "footer.html";
?>