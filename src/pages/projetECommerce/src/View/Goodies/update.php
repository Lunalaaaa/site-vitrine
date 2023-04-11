<?php
$nom = $_GET['nomProduit'];
$goodies = (new App\eCommerce\Model\Repository\GoodiesRepository)->select($nom);
$oldName = $nom;
$oldCategorie = $goodies->getCategorie();
?>
<link rel="stylesheet" href="css/style.css">
<form method="post" action="frontController.php?action=updated&controller=goodies"/>
<fieldset>
    <legend>Modification du goodies <?php echo $oldName ?> :</legend>
    <p>
        <label for="nom_id">Nom du produit</label> :
        <input type="text" value="<?= $nom ?>" name="nom" id="nom_id" required/>
    </p>
    <p>
        <label for="prix_id">Prix</label> :
        <input type="number" value="<?= $goodies->getPrixProduit() ?>" name="prix" id="prix_id" step="0.01" min="1" required/>
    </p>
    <p>
        <label for="categorie_id">Jeu</label> :
        <select name="categorie" id="categorie_id" required>
            <?php
            echo '<option value="'.$goodies->getCategorie().'">'.ucfirst($goodies->getCategorie()).'</option>';
            switch ($goodies->getCategorie()) {
                case "magic" :
                    echo '<option value="yu-gi-oh">Yu-Gi-Oh!</option>';
                    echo '<option value="pokemon">Pokemon</option>';
                    break;
                case "pokemon" :
                    echo '<option value="magic">Magic</option>';
                    echo '<option value="yu-gi-oh">Yu-Gi-Oh!</option>';
                    break;
                case "yu-gi-oh" :
                    echo '<option value="magic">Magic</option>';
                    echo '<option value="pokemon">Pokemon</option>';
                    break;
            }
            ?>
        </select>
    </p>
    <input type="hidden" name="oldNom" value="<?php echo $oldName; ?>">
    <p>
        <input type="submit" value="Envoyer"/>
        <button onclick='location.href="frontController.php?action=delete&controller=goodies&nomProduit=<?php echo htmlspecialchars($oldName) ?>"' type="button">Supprimer</button>
    </p>
</fieldset>
</form>