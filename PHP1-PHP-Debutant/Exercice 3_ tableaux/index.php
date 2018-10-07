<!DOCTYPE HTML>
<html>
<head>
    <title>Module PHP-Debutant - Exo3 - Francis Désignère</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="fr" />
</head>
<body>
    <?php
        // ======== 1 =========== 
        // definition du Tableau de typeMusic
        $musicTypes = array("Classique", "Jazz", "Pop", "Rock", "Indépendant");
        foreach($musicTypes as $musicType){
            echo "$musicType <br/>";
        }
        
        echo str_repeat("=",50)." <br/>";
        // ======== 2 ===========
        // creation du tableau associatif
        // (j'ai adopté ici une méthode pour construire la clé)
        $listeAuteurs = "Mozart, Amstrong, Bowie, Beatles, Les Têtes Raides";
        $tempAuteurs = explode(", " , $listeAuteurs);
        for($i=0;$i<count($tempAuteurs);$i++){
            $auteurs["auteur".$i]=$tempAuteurs[$i];
        }
        // affichage de tableau
        foreach($auteurs as $cle=>$valeur){
            echo "$cle : $valeur <br/>";
        }
        
         echo str_repeat("=",50)." <br/>";
        // ======== 3 ===========
        // tableau multidimensionnel
        // j'ai réutilisé le principe du '2' et l'ai imbriqué dans une boucle pour les style
        unset($listeAuteurs);
        $listeAuteurs[] = "Mozart, Bach, Haendel";
        $listeAuteurs[] = "Amstrong";
        $listeAuteurs[] = "David Bowie, Iggy Pop";
        $listeAuteurs[] = "Beatles";
        $listeAuteurs[] = "Les Têtes Raides";
        for($cptstyle=0;$cptstyle<=4;$cptstyle++){                      // boucle sur les style de musiques (clé1)
            unset($auteurs);
            //echo "1 === ";
            //echo "listeAuteurs $cptstyle   = $listeAuteurs[$cptstyle]";
            $tempAuteurs = explode(", " , $listeAuteurs[$cptstyle]);    // chargement de la liste dans un tableau numéric
            //var_dump($tempAuteurs);
            
            for($i=0;$i<count($tempAuteurs);$i++){                      // boucle pour chargement en tableau associatif
                $auteurs["auteur".$i]=$tempAuteurs[$i];
            }
            $style=$musicTypes[$cptstyle];                              // récupération du style dans tableau 
            $stylesAuteurs[$style]= $auteurs;                           // affectation du tableau auteurs dans le style correspondant
        }
//        var_dump($stylesAuteurs);
        
        // affichage des auteurs de style Pop
       echo "Voici les auteurs de musique pop : <B>";
//       foreach($stylesAuteurs['Pop'] as $cleAuteur=>$auteur){
       $cptAut = 1;
       foreach($stylesAuteurs['Pop'] as $auteur){
            echo "$auteur ";
            if ($cptAut < count($stylesAuteurs['Pop'])){                // condition permettant de gérer la virgule entre chaque auteur
                echo ", ";                                              // sans en mettre apprès le dernier                
            }
            $cptAut++;
        }
        echo "</B><br/>";

        // affichage de tout le tableau
        echo "<br/>--- affichage de tout le tableau ---<br/>";
        foreach($stylesAuteurs as $style=>$tabAuteurs){
            foreach($tabAuteurs as $cleAuteur=>$auteur){
                echo "$style | $cleAuteur  |  $auteur <br/>";
            }
        }        

        // tentative d'affichage de tout le tableau ...
        // mais apparement, le foreach ne peut pas directement récuperer les N dimensions
/*
        echo "--- affichage de tous le tableau ---";
        foreach($stylesAuteurs as $style=>$cleAuteur=>$auteur){
            echo "$style | $cleAuteur  |  $auteur <br/>";
        }
*/

    ?>
</body>
</html>