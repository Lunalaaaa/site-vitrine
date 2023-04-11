<?php

namespace App\eCommerce\Controller;

use App\eCommerce\Lib\ConnexionClient;
use App\eCommerce\Lib\MessageFlash;
use App\eCommerce\Model\Repository\AbstractRepository;
use App\eCommerce\Model\Repository\GoodiesRepository;


class ControllerGoodies extends GenericController
{
    public static function readAll(): void
    {
        $goodies = (new GoodiesRepository())->selectAll();
        static::afficheVue('/view.php', ['pagetitle' => 'liste des goodies', 'cheminVueBody' => 'ObjetView/ViewGoodies.php', 'goodies' => $goodies]);
    }

    public static function create(): void
    {
        if(ConnexionClient::estConnecte() && ConnexionClient::estAdministrateur()){
            ControllerCarte::afficheVue('Goodies/CreerGoodies.php');
        }
        else{
            echo MessageFlash::afficherMessageFlash('danger', "Vous n'avez pas les droits pour créer les goodies.");
            static::readAll();
        }
    }

    public static function created(): void
    {
        if(ConnexionClient::estConnecte() && ConnexionClient::estAdministrateur()){
            $nomHTML = $_POST['nom'];
            $prixHTML = $_POST['prix'];
            $categorieHTML = $_POST['categorie'];
            if (is_null((new GoodiesRepository)->select("$nomHTML"))) {
                $goodies = AbstractRepository::create("goodies", ["nomGoodies" => $nomHTML, "prix" => $prixHTML, "categorie" => $categorieHTML]);
                (new GoodiesRepository())->sauvegarder($goodies);
                echo MessageFlash::afficherMessageFlash("success", "Le goodies a bien été créer !");
                self::readAll();
            } else {
                echo MessageFlash::afficherMessageFlash("danger", "Le goodies $nomHTML existe déjà");
                self::readAll();
            }
        }
        else{
            echo MessageFlash::afficherMessageFlash('danger', 'Vous n\'avez pas les droits pour créer des goodies.');
            static::readAll();
        }
    }

    public static function update() : void {
        if(ConnexionClient::estConnecte() && ConnexionClient::estAdministrateur()){
            $nomHTML = $_GET['nomProduit'];
            ControllerGoodies::afficheVue("Goodies/update.php", ["nomProduit" => htmlspecialchars($nomHTML)]);
        }
        else{
            echo MessageFlash::afficherMessageFlash('danger', 'Vous n\'avez pas les droits pour modifier des goodies.');
            static::readAll();
        }
    }

    public static function updated() : void {
        if(ConnexionClient::estConnecte() && ConnexionClient::estAdministrateur()){
            $nomHTML = $_POST['nom'];
            $prixHTML = $_POST['prix'];
            $categorieHTML = $_POST['categorie'];
            $oldNomHTML = $_POST['oldNom'];
            if (is_null((new GoodiesRepository)->select("$nomHTML")) || $oldNomHTML == $nomHTML) {
                $goodies = (new GoodiesRepository)->select($oldNomHTML);
                $goodies->setNom($nomHTML);
                $goodies->setPrix($prixHTML);
                $goodies->setCategorie($categorieHTML);
                (new GoodiesRepository)->update($goodies, $oldNomHTML);
                echo MessageFlash::afficherMessageFlash("success", "Le goodies $oldNomHTML a bien été modifié");
                self::readAll();
            } else {
                echo MessageFlash::afficherMessageFlash("danger", "Le goodies $nomHTML existe déjà");
                self::readAll();
            }
        }
        else{
            echo MessageFlash::afficherMessageFlash('danger', 'Vous n\'avez pas les droits pour modifier des goodies.');
            static::readAll();
        }
    }

    public static function delete() : void {
        if(ConnexionClient::estConnecte() && ConnexionClient::estAdministrateur()){
            $nomHTML = $_GET['nomProduit'];
            (new GoodiesRepository())->delete($nomHTML);
            echo MessageFlash::afficherMessageFlash("success", "Le goodie $nomHTML à été supprimé");
            self::readAll();
        }
        else{
            echo MessageFlash::afficherMessageFlash('danger', "Vous n'avez pas les droits pour supprimer des goodies.");
        }
    }
}