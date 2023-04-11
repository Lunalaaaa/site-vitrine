<link rel="stylesheet" href="css/style.css">
<form method="post" action="frontController.php?action=created&controller=goodies"/>
<fieldset>
    <legend>Ajout goodies :</legend>
    <p>
        <label for="nom_id">Nom</label> :
        <input type="text" placeholder="Tasse Yu-Gi-Oh Yami Yugi" name="nom" id="nom_id" required/>
    </p>
    <p>
        <label for="prix_id">Prix</label> :
        <input type="number" placeholder="9.99" name="prix" id="prix_id" step="0.01" min="1" required/>
    </p>
    <p>
        <label for="categorie_id">Jeu</label> :
        <select name="categorie" id="categorie_id" required>
            <option value="yu-gi-oh">Yu-Gi-Oh!</option>
            <option value="pokemon">Pokemon</option>
            <option value="magic">Magic</option>
        </select>
    </p>
    <p>
        <input type="submit" value="Envoyer"/>
    </p>
</fieldset>
</form>