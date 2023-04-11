<?php

if (\App\eCommerce\Lib\ConnexionClient::estAdministrateur()){
    foreach ($clients as $client){
        $mailHTML = htmlspecialchars($client->getMailClient());
        $mailURL = rawurlencode($client->getMailClient());

        $messsage = 'frontController.php?controller=client&action=read&mailClient=' . $mailURL;

        $update = 'frontController.php?controller=client&action=update&mailClient=' . $mailURL;
        $delete = 'frontController.php?controller=client&action=delete&mailClient=' . $mailURL;

        echo "Client de login " . $mailHTML . " <a href=$messsage>" . "Consulter" . "</a> <a href='$update'>" . " Modifier" . "</a> <a href = '$delete'>" . " Supprimer" . "</a>" . "<br>";
    }
    $create = 'frontController.php?controller=client&action=create';
    echo "<a href='$create'>" . "Créer un nouvel utilisateur" . "</a>";
}
