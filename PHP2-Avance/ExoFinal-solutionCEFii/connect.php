<?php
	/*déclaration constantes serveur*/
	//define('SERVER' ,"sqlprive-pc2372-001.privatesql:3306");
	//define('USER' ,"cefiidev827");
	//define('PASSWORD' ,"m4zP3w7Y");
	//define('BASE' ,"cefiidev827");
	
	define('SERVER' ,"localhost");
	define('USER' ,"root");
	define('PASSWORD' ,"");
	define('BASE' ,"cefiidev827");
	
	/*test connexion*/
	try {
		$connexion = new PDO("mysql:host=".SERVER.";dbname=".BASE, USER, PASSWORD);
		}
	catch(Exception $e) {
		die('Erreur : '.$e->getMessage());
	}
	
	/**
		* Pour les tests, on peut vouloir afficher que la connexion est ok
		*
		* if ($connexion) {
		*	echo 'Connexion BDD OK !<br>';
		* }
	*/
?>