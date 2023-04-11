<link rel="stylesheet" href="css/style.css">
<form method="post" action="frontController.php?action=created&controller=booster"/>
<fieldset>
    <legend>Ajout boosters :</legend>
    <p>
        <label for="nom_id">Nom</label> :
        <input type="text" placeholder="Booster #1" name="nom" id="nom_id" required/>
    </p>
    <p>
        <label for="prix_id">Prix</label> :
        <input type="number" placeholder="5" name="prix" id="prix_id" step="0.01" min="1" required/>
    </p>
    <p>
        <label for="nbCartes_id">Nombre de cartes</label> :
        <input type="number" placeholder="20" name="nbCartes" id="nbCartes_id" min="1" required/>
    </p>
    <p>
        <label for="categorie_id">Jeu</label> :
        <select name="categorie" id="categorie_id" required>
            <option value="magic">Magic</option>
            <option value="pokemon">Pokemon</option>
            <option value="yu-gi-oh">Yu-Gi-Oh!</option>
        </select>
    </p>
    <p>
        <input type="submit" value="Envoyer"/>
    </p>
</fieldset>
</form>