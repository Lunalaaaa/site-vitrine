<?php
$nom = $_GET['nomProduit'];
$booster = (new App\eCommerce\Model\Repository\BoosterRepository())->select($nom);
$oldName = $nom;
$oldCategorie = $booster->getCategorie();
?>
<link rel="stylesheet" href="css/style.css">
<form method="post" action="frontController.php?action=updated&controller=booster"/>
<fieldset>
    <legend>Modification du booster <?php echo $oldName ?> :</legend>
    <p>
        <label for="nom_id">Nom du produit</label> :
        <input type="text" value="<?= $nom ?>" name="nom" id="nom_id" required/>
    </p>
    <p>
        <label for="prix_id">Prix</label> :
        <input type="number" value="<?= $booster->getPrixProduit() ?>" name="prix" id="prix_id" step="0.01" min="1" required/>
    </p>
    <p>
        <label for="nbCartes_id">Nombre de cartes</label> :
        <input type="number" value="<?= $booster->getNbCartes() ?>" name="nbCartes" id="nbCartes" min="1" required/>
    </p>
    <p>
        <label for="categorie_id">Jeu</label> :
        <select name="categorie" id="categorie_id" required>
            <?php
            echo '<option value="'.$booster->getCategorie().'">'.ucfirst($booster->getCategorie()).'</option>';
            switch ($booster->getCategorie()) {
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
        <button onclick='location.href="frontController.php?action=delete&controller=booster&nomProduit=<?php echo htmlspecialchars($oldName) ?>"' type="button">Supprimer</button>
    </p>
</fieldset>
</form>