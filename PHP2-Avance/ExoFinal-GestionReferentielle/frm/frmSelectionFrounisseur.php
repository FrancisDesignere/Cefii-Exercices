<?php 
if($page=='DelFrn'){
    $legend = ' Selectionez un fournisseur à supprimer ';
    $btnText = 'Supprimer';
    $action = './fonctions/DeleteFournisseur.php';
}else{
    $legend = ' Selectionez un fournisseur à modifier ';    
    $btnText = 'Modifier';
    $action = './index.php';
}
?>

    <!-- formulaire de choix de l'article -->
    <fieldset>
        <legend><?php echo $legend?></legend>
        <form id="formChoixArt" action="<?php echo $action;?>" method="POST">
            <ul>
                <li>                    
                    <label for="ChoixFrn">Société : </label>
                    <select id="ChoixFrn" name="idfournisseurs" required>
                        <option value="" ></option>
                        <?php // la construction des options correspondant à chaque article en base
                            $msg='';

                            $lstObjFrn = getAllSuppliers();
                            $_SESSION['nbFrn']= count($lstObjFrn);
                            foreach($lstObjFrn as $oneFrn){
                                        echo '<option value="'.$oneFrn->idfournisseurs.'">'.$oneFrn->societe.' (proposant : ' .$oneFrn->produit.')</option>' ;
                            }

                            if (isset($_SESSION['msg'])){
                                $_SESSION['msg'].= $msg;
                            }else{
                                $_SESSION['msg']= $msg;
                            }                        
                        
                        ?>
                    </select>
                </li><li>
                    <label for="validChoixArt"></label>
                    <input type="hidden" name="token" value="<?php echo $token;?>">
                    <input id="validChoixArt" type="submit" value="<?php echo $btnText;?>" class="btn_form">
                </li>
            </ul>
        </form>

        <span class="note">Nombre de fournisseur(s) existant(s) : <?php echo $_SESSION['nbFrn'];?></span>
    </fieldset>