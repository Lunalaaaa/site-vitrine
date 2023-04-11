<?php

namespace App\eCommerce\Controller;

use App\eCommerce\Lib\ConnexionClient;
use App\eCommerce\Lib\MessageFlash;
use App\eCommerce\Lib\MotDePasse;
use App\eCommerce\Model\DataObject\Client;
use App\eCommerce\Model\Repository\ClientRepository;

class ControllerClient extends GenericController{
    public static function read(){
        if(ConnexionClient::estConnecte()){
            if(ConnexionClient::estUtilisateur($_REQUEST['mailClient']) || ConnexionClient::estAdministrateur()){
                $client = (new ClientRepository())->select($_REQUEST['mailClient']);
                static::afficheVue('/view.php', ['pagetitle' => 'Détail du client', 'cheminVueBody' => 'Clients/detail.php', 'client' => $client]);
            }
            else{
                echo MessageFlash::afficherMessageFlash("danger", "Vous n'avez pas les droits nécessaires pour regarder ce profil.");
                static::accueil();
            }
        }
        else{
            echo MessageFlash::afficherMessageFlash("info", "Connecter-vous pour consulter des profils.");
            static::accueil();
        }
    }

    public static function readAll(){
        if(ConnexionClient::estConnecte() && ConnexionClient::estAdministrateur()){
            $clients = (new ClientRepository())->selectAll();
            static::afficheVue('/view.php', ['pagetitle' => 'Liste des clients', 'cheminVueBody' => 'Clients/list.php', 'clients' => $clients]);
        }
        else{
            echo MessageFlash::afficherMessageFlash("danger", "Vous n'avez pas les droits nécessaires à cette action.");
            static::accueil();
        }
    }

    public static function create(){
        static::afficheVue('view.php', ["pagetitle" => "Création de client", "cheminVueBody" => "Clients/createUpdate.php"]);
    }

    public static function created(){
        $mailClient = $_POST['mailClient'];
        $test = (new ClientRepository())->select($mailClient);
        if($test != null){
            echo MessageFlash::afficherMessageFlash('info', "Adresse mail déjà utilisée.");
            static::accueil();
        }
        else{
            $nomClient = $_POST['nomClient'];
            $prenomClient = $_POST['prenomClient'];
            if($_POST['mdp'] == $_POST['mdp2']){
                $mdp = $_POST['mdp'];
                if(ConnexionClient::estConnecte() && ConnexionClient::estAdministrateur() && isset($_POST['estAdmin'])){
                    if($_POST['estAdmin'] == 'on'){
                        $client = Client::builder(["mailClient" => $mailClient, "nomClient" => $nomClient, "prenomClient" => $prenomClient, "livraison" => '', "mdpHache" => MotDePasse::hacher($mdp), "typeClient" => 1]);
                    }
                    else{
                        $client = Client::builder(["mailClient" => $mailClient, "nomClient" => $nomClient, "prenomClient" => $prenomClient, "livraison" => '', "mdpHache" => MotDePasse::hacher($mdp), "typeClient" => 0]);
                    }
                }
                else{
                    $client = Client::builder(["mailClient" => $mailClient, "nomClient" => $nomClient, "prenomClient" => $prenomClient, "livraison" => '', "mdpHache" => MotDePasse::hacher($mdp), "typeClient" => 0]);
                }
                (new ClientRepository)->sauvegarder($client);
                echo MessageFlash::afficherMessageFlash("success", 'Client crée');
                if(ConnexionClient::estConnecte()){
                    static::redirect("frontController.php?controller=client&action=read&mailClient={$client->getMailClient()}");
                }
                else{
                    self::connecter();
                }
            }
            else{
                echo MessageFlash::afficherMessageFlash("warning", 'Les 2 mots de passe sont différents');
                static::afficheVue('view.php', ["mailClient" => $mailClient, "nomClient" => $nomClient, "prenomClient" => $prenomClient, "action" => 'create', "pagetitle" => "Création de client", "cheminVueBody" => "Clients/createUpdate.php"]);
            }
        }
    }

    public static function update(){
        if(ConnexionClient::estConnecte()){
            $client = (new ClientRepository())->select($_REQUEST['mailClient']);
            if(ConnexionClient::estUtilisateur($client->getMailClient()) || ConnexionClient::estAdministrateur()){
                static::afficheVue('view.php', ["mailClient" => $client->getMailClient(), "nomClient" => $client->getNomClient(), "prenomClient" => $client->getPrenomClient(), "livraison" => $client->getLivraison(), "pagetitle" => "Changement Client", "cheminVueBody" => "Clients/createUpdate.php"]);
            }
            else{
                echo MessageFlash::afficherMessageFlash("danger", "Vous n'avez pas les droits sur ce client.");
                static::accueil();
            }
        }
        else{
            echo MessageFlash::afficherMessageFlash("info", "Connectez-vous pour changer un profil.");
            static::accueil();
        }
    }

    public static function updated(){
        if (isset($_POST['mailClient'])) {
            if(ConnexionClient::estConnecte()){
                if (ConnexionClient::estUtilisateur($_POST['mailClient']) || ConnexionClient::estAdministrateur()) {
                    $ancienMail = $_POST['mailClient'];
                    $client = (new ClientRepository())->select($ancienMail);
                    if($client == null){
                        echo MessageFlash::afficherMessageFlash("danger", "Le client n'existe pas.");
                        static::accueil();
                    }
                    else if($_POST['mailClient2'] != ''){
                        $client->setMailClient($_POST['mailClient2']);
                    }
                    $client->setNomClient($_POST['nomClient']);
                    $client->setPrenomClient($_POST['prenomClient']);
                    $client->setLivraison($_POST['livraison']);
                    $ancienMdp = $client->getMdpHache();
                    if($_POST['mdp'] != ''){
                        $client->setMdpHache($_POST['mdp']);
                    }
                    if ($_POST['mdp'] == $_POST['mdp2']){
                        if (ConnexionClient::estUtilisateur($_POST['mailClient'])) {
                            if (isset($_POST['mdp_avant'])) {
                                if (MotDePasse::verifier($_POST['mdp_avant'], $ancienMdp)) {
                                    if(ConnexionClient::estAdministrateur()){
                                        if(isset($_POST['estAdmin']) && $_POST['estAdmin'] == 'on'){
                                            $client->setTypeClient(1);
                                        }
                                        else{
                                            $client->setTypeClient(0);
                                        }
                                    }
                                    (new ClientRepository())->update($client, $_POST['mailClient']);
                                    ConnexionClient::connecter($client->getMailClient());
                                    echo MessageFlash::afficherMessageFlash("success", 'Changement réussi');
                                    static::accueil();
                                }
                                else {
                                    echo MessageFlash::afficherMessageFlash("warning", "L'ancien mot de passe ne correspond pas.");
                                    static::afficheVue('view.php', ["action" => 'update', "mailClient" => $ancienMail, "nomClient" => $client->getNomClient(), "prenomClient" => $client->getPrenomClient(), "livraison" => $client->getLivraison(), "mailClient2" => $_POST['mailClient2'], "pagetitle" => "Changement Client", "cheminVueBody" => "Clients/createUpdate.php"]);
                                }
                            }
                            else {
                                echo MessageFlash::afficherMessageFlash("danger", 'Il y a des champs manquants');
                                static::afficheVue('view.php', ["action" => 'update', "mailClient" => $ancienMail, "nomClient" => $client->getNomClient(), "prenomClient" => $client->getPrenomClient(), "livraison" => $client->getLivraison(), "mailClient2" => $_POST['mailClient2'], "pagetitle" => "Changement Client", "cheminVueBody" => "Clients/createUpdate.php"]);
                            }
                        }
                        else {
                            if(isset($_POST['estAdmin']) && $_POST['estAdmin'] == 'on'){
                                $client->setTypeClient(1);
                            }
                            else{
                                $client->setTypeClient(0);
                            }
                            (new ClientRepository())->update($client, $_POST['mailClient']);
                            echo MessageFlash::afficherMessageFlash("success", 'Changement réussi');
                            static::afficheVue('view.php', ['pagetitle' => 'Détail du client', 'cheminVueBody' => 'Clients/detail.php', 'client' => $client]);
                        }
                    }
                    else {
                        echo MessageFlash::afficherMessageFlash("warning", 'Les nouveaux mots de passe sont différents.');
                        static::afficheVue('view.php', ["action" => 'update', "mailClient" => $ancienMail, "nomClient" => $client->getNomClient(), "prenomClient" => $client->getPrenomClient(), "livraison" => $client->getLivraison(), "mailClient2" => $_POST['mailClient2'], "pagetitle" => "Changement Client", "cheminVueBody" => "Clients/createUpdate.php"]);
                    }
                }
                else {
                    echo MessageFlash::afficherMessageFlash("danger", "Vous n'avez pas les droits sur ce client.");
                    static::accueil();
                }
            }
            else{
                echo MessageFlash::afficherMessageFlash("info", "Connectez-vous pour modifier ce profil.");
                static::accueil();
            }
        }
        else {
            echo MessageFlash::afficherMessageFlash("danger", 'Il y a des champs manquants.');
            static::accueil();
        }
    }

    public static function delete(){
        if(ConnexionClient::estConnecte()){
            if(ConnexionClient::estAdministrateur()){
                (new ClientRepository())->delete($_REQUEST['mailClient']);
                echo MessageFlash::afficherMessageFlash('success', 'Le client ' . $_REQUEST['mailClient'] . ' a bien été supprimé.');
                if(ConnexionClient::estUtilisateur($_REQUEST['mailClient'])){
                    self::deconnecter();
                }
                else{
                    static::accueil();
                }
            }
            else if(ConnexionClient::estUtilisateur($_REQUEST['mailClient'])){
                (new ClientRepository())->delete($_REQUEST['mailClient']);
                echo MessageFlash::afficherMessageFlash('success', 'Le client ' . $_REQUEST['mailClient'] . ' a bien été supprimé.');
                self::deconnecter();
            }
            else{
                echo MessageFlash::afficherMessageFlash("danger", "Vous n'avez pas les droits pour supprimer ce client.");
                static::accueil();
            }
        }
        else{
            echo MessageFlash::afficherMessageFlash("info", "Connectez-vous pour supprimer ce profil.");
            static::accueil();
        }
    }

    public static function connecter(){
        if(isset($_POST['mailClient']) && isset($_POST['mdp'])){
            $client = (new ClientRepository())->select($_POST['mailClient']);
            if($client != null){
                if(MotDePasse::verifier($_POST['mdp'], $client->getMdpHache())){
                    ConnexionClient::connecter($client->getMailClient());
                    echo MessageFlash::afficherMessageFlash('success', 'Connecté');
                    static::accueil();
                }
                else{
                    echo MessageFlash::afficherMessageFlash("warning" ,"Mot de passe incorrect.");
                    static::formulaireConnexion();
                }
            }
            else{
                echo MessageFlash::afficherMessageFlash("warning", "Client inexistant.");
                static::formulaireConnexion();
            }
        }
        else{
            echo MessageFlash::afficherMessageFlash("danger", "Informations manquantes.");
            static::formulaireConnexion();
        }
    }

    public static function deconnecter(){
        ConnexionClient::deconnecter();
        echo MessageFlash::afficherMessageFlash('info', 'Déconnecté');
        self::accueil();
    }
}