<form method="post" action="frontController.php?action=<?php
if(!isset($action)){
    $action = $_GET['action'];
}
if($action == 'update'){echo 'updated';}
else{echo 'created';}?>
&controller=client">
    <fieldset>
        <legend> <?php use App\eCommerce\Model\Repository\ClientRepository;

            if($action != 'create'){
                echo 'Modification du compte ' . htmlspecialchars($mailClient);
            }
            else{
                echo 'Création de compte :';
            }
            ?>
        </legend>
        <p>
            <label for="mailClient_id">Mail</label> :
            <input <?php if(isset($mailClient)) {
                echo 'value="' . htmlspecialchars($mailClient) . '"';}?>
                    type="email" name="mailClient" id="mailClient_id" <?php
            if($action == 'update') {
                echo 'readonly';
            } else {echo "";}?>/>
        </p>
        <?php
            if($action == 'update'){
                if(isset($mailClient2)){
                    echo '<p>
                        <label for="mailClient2_id">Nouveau Mail</label> :
                        <input type="email" name="mailClient2" value="' . $mailClient2 . '" id="mailClient2_id"/>
                    </p>';
                }
                else {
                    echo '<p>
                        <label for="mailClient2_id">Nouveau Mail</label> :
                        <input type="email" name="mailClient2" id="mailClient2_id"/>
                    </p>';
                }
            }
        ?>
        <p>
            <label for="nomClient_id">Nom</label> :
            <input <?php
            if(isset($nomClient)) {echo 'value="' . htmlspecialchars($nomClient) . '"';}?> type="text" name="nomClient" id="nomClient_id"/>
        </p>
        <p>
            <label for="prenomClient_id">Prénom</label> :
            <input <?php
            if(isset($prenomClient)) {echo 'value="' . htmlspecialchars($prenomClient) . '"';}?> type="text" name="prenomClient" id="prenomClient_id"/>
        </p>
        <?php
            if($action == 'update'){
                echo '<p>
                            <label for="livraison_id">Adresse de livraison</label> :
                            <input class="InputAddOn-field" type="text" value="'. htmlspecialchars($livraison) .'"  placeholder="" name="livraison" id="livraison_id">
                      </p>';
                if(\App\eCommerce\Lib\ConnexionClient::estUtilisateur($mailClient)){
                    echo '<p class="InputAddOn">
                            <label class="InputAddOn-item" for="mdp_id_avant">Ancien mot de passe&#42;</label> :
                            <input class="InputAddOn-field" type="password" value="" placeholder="" name="mdp_avant" id="mdp_id_avant" required>
                          </p>';
                }
            }
            else {
                echo "";
            }
        ?>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mdp_id"><?php if($action == 'update'){echo 'Nouveau mot de passe';}else{echo 'Mot de passe&#42;';} ?></label> :
            <input class="InputAddOn-field" type="password" value="" placeholder="" name="mdp" id="mdp_id" <?php if($action == 'create') {
                echo 'required';
            }
            else{
                echo "";
            }?>>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mdp2_id"><?php if($action == 'update'){echo 'Vérification nouveau mot de passe';}else{echo 'Vérification mot de passe&#42;';} ?></label> :
            <input class="InputAddOn-field" type="password" value="" placeholder="" name="mdp2" id="mdp2_id" <?php if($action == 'create') {
                echo 'required';
            }
            else{
                echo "";
            }?>>
        </p>
        <?php
            if($action == 'update'){
                $client = (new ClientRepository())->select($mailClient);
                if(\App\eCommerce\Lib\ConnexionClient::estAdministrateur() && $client->getTypeClient() == 1){
                    echo '<p class="InputAddOn">
                                <label class="InputAddOn-item" for="estAdmin_id">Administrateur</label>
                                <input class="InputAddOn-field" type="checkbox" placeholder="" name="estAdmin" id="estAdmin_id" checked>
                          </p>';
                }
                else if(\App\eCommerce\Lib\ConnexionClient::estAdministrateur()){
                    echo '<p class="InputAddOn">
                                <label class="InputAddOn-item" for="estAdmin_id">Administrateur</label>
                                <input class="InputAddOn-field" type="checkbox" placeholder="" name="estAdmin" id="estAdmin_id">
                          </p>';
                }
                else{
                    echo '';
                }
            }
            else{
                if(\App\eCommerce\Lib\ConnexionClient::estConnecte()){
                    if(\App\eCommerce\Lib\ConnexionClient::estAdministrateur()){
                        echo '<p class="InputAddOn">
                                <label class="InputAddOn-item" for="estAdmin_id">Administrateur</label>
                                <input class="InputAddOn-field" type="checkbox" placeholder="" name="estAdmin" id="estAdmin_id">
                              </p>';
                    }
                }
                else{
                    echo "";
                }
            }
        ?>
        <p>
            <input type="submit" value="Envoyer"/>
        </p>
        <p>
            <a href="frontController.php">Retour</a>
        </p>
    </fieldset>
</form>

