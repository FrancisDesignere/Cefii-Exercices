    <fieldset>
        <legend>liste des articles existants</legend>
        <span class="note">Nombre d'article(s) éxistant(s) : <?php echo $_SESSION['nbArt'];?></span>
        <div id='listDel'>
            <?php // la construction des options correspondant à chaque article en base
            $paramList='frmsDelete';
            include 'fonctions/GetListProduits.php';
            ?>    
        </div>
    </fieldset>
