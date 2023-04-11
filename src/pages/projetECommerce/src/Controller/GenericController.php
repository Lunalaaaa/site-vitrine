<?php

namespace App\eCommerce\Controller;

class GenericController
{
    protected static function afficheVue(string $cheminVue, array $parametres = []): void
    {
        extract($parametres);
        require __DIR__ . "/../View/$cheminVue";
    }

    public static function accueil(): void
    {
        static::afficheVue('view.php', ['pagetitle' => 'Accueil', 'cheminVueBody' => 'ObjetView/ViewAccueil.php']);
    }

    public static function redirect(string $url) {
        header("Location: $url");
        exit();
    }

    public static function formulaireConnexion(){
        static::afficheVue('view.php', ["pagetitle" => "Formulaire connexion", "cheminVueBody" => "Clients/formulaireConnexion.php"]);
    }

}