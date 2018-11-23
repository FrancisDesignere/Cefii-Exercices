<?php

spl_autoload_register(function($classe){
    if (strpos($classe, 'Controller')!==false){
        require 'controller/' . $classe . '.class.php';     
    }elseif(strpos($classe, 'View')!==false){
        require 'view/' . $classe . '.class.php';             
    }elseif(strpos($classe, 'Model')!==false){
        require 'model/' . $classe . '.class.php';             
    }
 });
function testParm ($type = "lorem") 
{
    return "Voici le texte: $type.<br>";
}
echo testParm();
echo testParm("ipsum");
$plop = "";
echo testParm($plop);
