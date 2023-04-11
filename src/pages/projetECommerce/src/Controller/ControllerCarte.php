<?php

namespace App\eCommerce\Controller;

use App\eCommerce\Lib\ConnexionClient;
use App\eCommerce\Lib\MessageFlash;
use App\eCommerce\Model\Repository\AbstractRepository;
use App\eCommerce\Model\Repository\CarteRepository;

class ControllerCarte extends GenericController
{
    public static function readAll(): void
    {
        $cartes = (new CarteRepository())->selectAll();
        static::afficheVue('view.php', ['pagetitle' => 'Liste des cartes', 'cheminVueBody' => 'ObjetView/ViewCarte.php', 'cartes' => $cartes]);

    }

    public static function create(): void
    {
        if(ConnexionClient::estConnecte() && ConnexionClient::estAdministrateur()){
            ControllerCarte::afficheVue('Cartes/CreerCartes.php');
        }
        else{
            echo MessageFlash::afficherMessageFlash('danger', 'Vous n\'avez pas les droits pour créer des cartes.');
            static::readAll();
        }
    }

    public static function created(): void
    {
        if(ConnexionClient::estConnecte() && ConnexionClient::estAdministrateur()){
            $nomHTML = $_POST['nom'];
            $prixHTML = $_POST['prix'];
            $rareteHTML = $_POST['rarete'];
            $categorieHTML = $_POST['categorie'];
            if (is_null((new CarteRepository)->select("$nomHTML"))) {
                $carte = AbstractRepository::create("cartes", ["nomCarte" => $nomHTML, "prix" => $prixHTML, "rarete" => $rareteHTML, "categorie" => $categorieHTML]);
                (new CarteRepository)->sauvegarder($carte);
                echo MessageFlash::afficherMessageFlash("success", "La carte a bien été créée !");
                self::readAll();
            } else {
                echo MessageFlash::afficherMessageFlash("danger", "La carte $nomHTML existe déjà");
                self::readAll();
            }
        }
        else{
            echo MessageFlash::afficherMessageFlash('danger', 'Vous n\'avez pas les droits pour créer des cartes.');
            static::readAll();
        }
    }

    public static function update() : void {
        if(ConnexionClient::estConnecte() && ConnexionClient::estAdministrateur()){
            $nomHTML = $_GET['nomProduit'];
            ControllerGoodies::afficheVue("Cartes/update.php", ["nomProduit" => htmlspecialchars($nomHTML)]);
        }
       else{
            echo MessageFlash::afficherMessageFlash('danger', 'Vous n\'avez pas les droits pour modifier des cartes.');
            static::readAll();
        }
    }

    public static function updated() : void {
        if(ConnexionClient::estConnecte() && ConnexionClient::estAdministrateur()){
            $nomHTML = $_POST['nom'];
            $prixHTML = $_POST['prix'];
            $rareteHTML = $_POST['rarete'];
            $categorieHTML = $_POST['categorie'];
            $oldNomHTML = $_POST['oldNom'];
            if (is_null((new CarteRepository)->select("$nomHTML")) || $oldNomHTML == $nomHTML) {
                $carte = (new CarteRepository)->select($oldNomHTML);
                $carte->setNomCarte($nomHTML);
                $carte->setPrix($prixHTML);
                $carte->setCategorie($categorieHTML);
                $carte->setRarete($rareteHTML);
                (new CarteRepository)->update($carte, $oldNomHTML);
                echo MessageFlash::afficherMessageFlash("success", "La carte $oldNomHTML a bien été modifiée");
                self::readAll();
            } else {
                echo MessageFlash::afficherMessageFlash("danger", "La carte $nomHTML existe déjà");
                self::readAll();
            }
        }
        else{
            echo MessageFlash::afficherMessageFlash('danger', 'Vous n\'avez pas les droits pour modifier des cartes.');
            static::readAll();
        }
    }

    public static function delete() : void {
        if(ConnexionClient::estConnecte() && ConnexionClient::estAdministrateur()){
            $nomHTML = $_GET['nomProduit'];
            (new CarteRepository)->delete($nomHTML);
            echo MessageFlash::afficherMessageFlash("success", "La carte $nomHTML à été supprimée");
            self::readAll();
        }
        else{
            echo MessageFlash::afficherMessageFlash('danger', 'Vous n\'avez pas les droits pour supprimer des cartes.');
            static::readAll();
        }
    }
}