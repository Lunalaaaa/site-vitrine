<?php

use App\eCommerce\Lib\MotDePasse;
    if(\App\eCommerce\Lib\ConnexionClient::estAdministrateur() || \App\eCommerce\Lib\ConnexionClient::estUtilisateur($_GET['mailClient'])) {
        echo 'Informations client :';
        echo '<br>';
        if ($client->getTypeClient() == 1) {
            echo '<h3>[Administrateur]</h3>';
        }
        echo 'Client de mail : ' . $client->getMailClient();
        echo '<br>';
        echo 'Nom : ' . $client->getNomClient();
        echo '<br>';
        echo 'Prenom : ' . $client->getPrenomClient();
        echo '<br>';
        if($client->getLivraison() != '' && $client->getLivraison() != null){
            echo 'Adresse de livraison : ' . $client->getLivraison();
            echo '<br>';
        }
        $update = 'frontController.php?controller=client&action=update&mailClient=' . $client->getMailClient();
        echo "<a href='$update'>" . "Modifier mes informations" . "</a>";
        $delete = 'frontController.php?controller=client&action=delete&mailClient=' . $client->getMailClient();
        echo '<br>';
        echo "<a href='$delete'>" . "Supprimer mon compte" . "</a>";
    }


