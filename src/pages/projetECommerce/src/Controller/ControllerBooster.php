<?php

namespace App\eCommerce\Controller;

use App\eCommerce\Lib\ConnexionClient;
use App\eCommerce\Lib\MessageFlash;
use App\eCommerce\Model\Repository\AbstractRepository;
use App\eCommerce\Model\Repository\BoosterRepository;

class ControllerBooster extends GenericController
{
    public static function readAll(): void
    {
        $boosters = (new BoosterRepository())->selectAll();
        static::afficheVue('/view.php', ['pagetitle' => 'Liste des boosters', 'cheminVueBody' => 'ObjetView/ViewBooster.php', 'boosters' => $boosters]);

    }

    public static function create(): void
    {
        if(ConnexionClient::estConnecte() && ConnexionClient::estAdministrateur()){
            ControllerCarte::afficheVue('Boosters/CreerBoosters.php');
        }
        else{
            echo MessageFlash::afficherMessageFlash('danger', "Vous n'avez pas les droits pour créer des boosters.");
            static::readAll();
        }
    }

    public static function created(): void{
        if(ConnexionClient::estConnecte() &&ConnexionClient::estAdministrateur()){
            $nomHTML = $_POST['nom'];
            $prixHTML = $_POST['prix'];
            $nbCartesHTML = $_POST['nbCartes'];
            $categorieHTML = $_POST['categorie'];
            if (is_null((new BoosterRepository)->select("$nomHTML"))) {
                $booster = AbstractRepository::create("booster", ["nomBooster" => $nomHTML, "prix" => $prixHTML, "nbCartes" => $nbCartesHTML, "categorie" => $categorieHTML]);
                (new BoosterRepository)->sauvegarder($booster);
                echo MessageFlash::afficherMessageFlash("success", "Le booster a bien été crée !");
                self::readAll();
            } else {
                echo MessageFlash::afficherMessageFlash("danger", "Le booster $nomHTML existe déjà");
                self::readAll();
            }
        }
        else{
            echo MessageFlash::afficherMessageFlash('danger', "Vous n'avez pas les droits pour créer des boosters.");
            static::readAll();
        }
    }

    public static function update() : void {
        if(ConnexionClient::estConnecte() && ConnexionClient::estAdministrateur()){
            $nomHTML = $_GET['nomProduit'];
            ControllerGoodies::afficheVue("Boosters/update.php", ["nomProduit" => htmlspecialchars($nomHTML)]);
        }
        else{
            echo MessageFlash::afficherMessageFlash('danger', "Vous n'avez pas les droits pour modifier des boosters.");
            static::readAll();
        }
    }

    public static function updated() : void {
        if(ConnexionClient::estConnecte() && ConnexionClient::estAdministrateur()){
            $nomHTML = $_POST['nom'];
            $prixHTML = $_POST['prix'];
            $categorieHTML = $_POST['categorie'];
            $nbCartesHTML = $_POST['nbCartes'];
            $oldNomHTML = $_POST['oldNom'];
            if (is_null((new BoosterRepository)->select("$nomHTML")) || $oldNomHTML == $nomHTML) {
                $booster = (new BoosterRepository)->select($oldNomHTML);
                $booster->setNomBooster($nomHTML);
                $booster->setPrix($prixHTML);
                $booster->setCategorie($categorieHTML);
                $booster->setNbCartes($nbCartesHTML);
                (new BoosterRepository)->update($booster, $oldNomHTML);
                echo MessageFlash::afficherMessageFlash("success", "Le booster $oldNomHTML a bien été modifié");
                self::readAll();
            } else {
                echo MessageFlash::afficherMessageFlash("danger", "Le booster $nomHTML existe déjà");
                self::readAll();
            }
        }
        else{
            echo MessageFlash::afficherMessageFlash('danger', 'Vous n\'avez pas les droits pour modifier des boosters.');
            static::readAll();
        }
    }

    public static function delete() : void {
        if(ConnexionClient::estConnecte() && ConnexionClient::estAdministrateur()){
            $nomHTML = $_GET['nomProduit'];
            (new BoosterRepository)->delete($nomHTML);
            echo MessageFlash::afficherMessageFlash("success", "Le booster $nomHTML à été supprimé");
            self::readAll();
        }
        else{
            echo MessageFlash::afficherMessageFlash('danger', 'Vous n\'avez pas les droits pour supprimer des boosters.');
            static::readAll();
        }
    }
}