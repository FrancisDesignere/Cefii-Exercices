<?php
session_start();
spl_autoload_register(function($classe){
    if (strpos($classe, 'Controller')!==false){
        require 'controller/' . $classe . '.class.php';     
    }elseif(strpos($classe, 'View')!==false){
        require 'view/' . $classe . '.class.php';             
    }elseif(strpos($classe, 'Model')!==false){
        require 'model/' . $classe . '.class.php';             
    }
 });

$main = new Controller();
$main->dispatch();