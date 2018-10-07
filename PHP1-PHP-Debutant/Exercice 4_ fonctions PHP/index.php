<!DOCTYPE HTML>
<html>
<head>
    <title>Module PHP-Debutant - Exo4 - Francis Désignère</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="fr" />
</head>
<body>
    <?php

         // ======== 1 =========== 
        // definition de la variable avec lorem Ipsum       
        $loremIpsum = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie,enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim.Pellentesque congue. Ut in risus volutpat libero pharetra tempor. Cras vestibulum bibendum augue. Praesent egestas leo in pede. Praesent blandit<br/>odio eu enim. Pellentesque sed dui ut augue blandit sodales. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam nibh. Mauris ac mauris sed pede pellentesque fermentum. Maecenas adipiscing ante non diam sodales hendrerit. Ut velit mauris, egestassed, gravida nec, ornare ut, mi. Aenean ut orci vel massa suscipit pulvinar. Nulla sollicitudin. Fusce varius, ligula non tempus aliquam, nunc turpisullamcorper nibh, in tempus sapien eros vitae ligula. Pellentesque rhoncus nunc et augue. Integer id felis. Curabitur aliquet pellentesque diam. vitae elit lobortis egestas. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Morbi vel erat non mauris convallis vehicula.Nulla et sapien. Integer tortor tellus, aliquam faucibus, convallis id, congue eu, quam. Mauris ullamcorper felis vitae erat. Proin feugiat, augue nonelementum posuere, metus purus iaculis lectus, et tristique ligula justo vitae magna. Aliquam convallis sollicitudin purus. Praesent aliquam, enim atfermentum mollis, ligula massa adipiscing nisl, ac euismod nibh nisl eu lectus. Fusce vulputate sem at sapien. Vivamus leo. Aliquam euismod libero euenim. Nulla nec felis sed leo placerat imperdiet. Aenean suscipit nulla in justo. Suspendisse cursus rutrum augue. Nulla tincidunt tincidunt mi. ettristique ligula justo vitae magna. Aliquam convallis sollicitudin purus. Praesent aliquam, enim at fermentum mollis, ligula massa adipiscing nisl, aceuismod nibh nisl eu lectus. Fusce vulputate sem at sapien. Vivamus leo. Aet tristique ligula justo vitae magna. Aliquam convallis sollicitudin purus. Praesent aliquam, enim at fermentum mollis, ligula massa adipiscing nisl, ac euismod nibh nisl eu lectus. Fusce vulputate sem at sapien. Vivamus leo.ACurabitur iaculis, lorem vel rhoncus faucibus, felis magna fermentum augue, et ultricies lacus lorem varius purus. Curabitur eu amet.";
        $first50dgtLorem = substr($loremIpsum, 0, 50);      // affectation des 50 premiers mots dans une variable
        echo "$first50dgtLorem <br/>";                      // affichage des 50 caractères mots
        echo str_repeat("-",50)." <br/>";
        
        // ======== 2 =========== 
        // recupération pour affichage des 50 premiers mots
        $tabLorem = explode(" ", $loremIpsum );
        for($cptMots=0; $cptMots<50; $cptMots++){
            echo "$tabLorem[$cptMots] ";
        }
        echo "... [ Lire la suite ]<br/>";
        
        echo str_repeat("-",50)." <br/>";
        // ======== 3 affichage de la date =========== 
        // initialisation de 2 tableaux portant avec les jours de la semaines et les mois 
        $joursSemaine= array("","Lundi", "Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche");
        $mois= array("","Janvier", "Février","Mars","Avril","Mai","Juin","Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre");
        $jourEnCours = $joursSemaine[date("N")];        // une variable avec le jour de la semaine
        $moisEnCours = $mois[date("n")];                // une variable avec le mois en cours
        echo $jourEnCours, date(" d "), $moisEnCours, date(" Y "), "<br/>";

    ?>
</body>
</html>
