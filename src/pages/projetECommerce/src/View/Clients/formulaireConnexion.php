<form method="post" action="frontController.php?action=connecter&controller=client">
<fieldset>
    <legend>Formulaire de connexion :</legend>
    <p>
        <label for="mailClient">Mail</label> :
        <input type="text" placeholder="mail@mail.com" name="mailClient" id="mailClient" required/>
    </p>
    <p class="InputAddOn">
        <label class="InputAddOn-item" for="mdp">Mot de passe</label> :
        <input class="InputAddOn-field" type="password" value="" placeholder="" name="mdp" id="mdp" required/>
    </p>
    <p>
        <input type="submit" value="Connexion"/>
    </p>
    <p>Pas encore de compte ? Créez en un <a href="frontController.php?controller=client&action=create">ici</a></p>
</fieldset>
</form>

