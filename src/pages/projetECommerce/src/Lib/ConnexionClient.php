<?php

namespace App\eCommerce\Lib;

use App\eCommerce\Model\HTTP\Panier;
use App\eCommerce\Model\HTTP\Session;
use App\eCommerce\Model\Repository\ClientRepository;

class ConnexionClient{
    private static string $cleConnexion = "_utilisateurConnecte";

    public static function connecter(string $mailClient): void
    {
        $session = Session::getInstance();
        $session->enregistrer(static::$cleConnexion, $mailClient);
        Panier::creerPanier();
    }

    public static function estConnecte(): bool
    {
        $session = Session::getInstance();
        return $session->contient(static::$cleConnexion);
    }

    public static function deconnecter(): void
    {
        $session = Session::getInstance();
        $session->supprimer(static::$cleConnexion);
    }

    public static function getMailClientConnecte(): ?string
    {
        $session = Session::getInstance();
        return $session->lire(static::$cleConnexion) ?? null;
    }

    public static function estUtilisateur($mailClient): bool
    {
        return self::getMailClientConnecte() == $mailClient;
    }

    public static function estAdministrateur(): bool{
        $session = Session::getInstance();
        $client = (new ClientRepository())->select($session->lire(static::$cleConnexion));
        return $client->getTypeClient() == 1;
    }



}