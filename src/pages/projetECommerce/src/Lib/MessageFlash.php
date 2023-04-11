<?php

namespace App\eCommerce\Lib;

use App\eCommerce\Model\HTTP\Session;

class MessageFlash
{
    private static Session $session;
    // Les messages sont enregistrés en session associée à la clé suivante
    private static string $cleFlash = "_messagesFlash";

    private static function initSession()
    {
        self::$session = Session::getInstance();
    }

    // $type parmi "success", "info", "warning" ou "danger"
    public static function ajouter(string $type, string $message): void
    {
        self::initSession();
        // On vérifie si la clé existe déjà dans la session
        if (!self::$session->contient(self::$cleFlash)) {
            // Si elle n'existe pas, on la crée et on lui affecte un tableau vide
            self::$session->enregistrer(self::$cleFlash, []);
        }

        // On ajoute le message au tableau des messages de la session
        self::$session->modifier(self::$cleFlash, $type, $message);
    }

    public static function contientMessage(string $type): bool
    {
        self::initSession();
        // On vérifie si la clé existe dans la session et si elle contient des messages du type demandé
        return self::$session->contient(self::$cleFlash) && self::$session->contientFlash(self::$cleFlash, $type);
    }

    // Attention : la lecture doit détruire le message
    public static function lireMessages(string $type): array
    {
        self::initSession();
        // On vérifie si la clé existe dans la session et si elle contient des messages du type demandé
        if (self::contientMessage($type)) {
            // Si oui, on récupère les messages et on les supprime de la session
            $messages = self::$session->lire(self::$cleFlash)[$type];
            self::$session->supprimerFlash(self::$cleFlash, $type);
            return array(
                'type' => $type,
                'message' => $messages,
            );
        } else {
            // Si non, on renvoie un tableau vide
            return [];
        }
    }

    public static function lireTousMessages(): array
    {
        self::initSession();
        // On vérifie si la clé existe dans la session
        if (self::$session->contient(self::$cleFlash)) {
            // Si oui, on récupère les messages et on les supprime de la session
            $messages = self::$session->lire(self::$cleFlash);
            //$messages = $_SESSION[self::$cleFlash];
            self::$session->supprimer(self::$cleFlash);
            //unset($_SESSION[self::$cleFlash]);
            return $messages;
        } else {
            // Si non, on renvoie un tableau vide
            return [];
        }
    }

    // $type parmi "success", "info", "warning" ou "danger"
    public static function afficherMessageFlash($type, $message): string
    {
        self::ajouter($type, $message);
        $messageFlash = self::lireMessages($type);
        return '<div class="alert alert-' . $type . '">' . $messageFlash['message'][0] . '</div>';
    }

}