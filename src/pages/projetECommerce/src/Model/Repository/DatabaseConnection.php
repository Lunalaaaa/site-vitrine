<?php

namespace App\eCommerce\Model\Repository;

use App\eCommerce\Config\Conf;
use PDO;

class DatabaseConnection
{
    private $pdo;
    private static $instance = null;


    public static function getPdo(): PDO
    {
        return static::getInstance()->pdo;
    }

    private function __construct()
    {
        $hostname = Conf::getHostname();
        $databaseName = Conf::getDatabase();
        $login = Conf::getLogin();
        $password = Conf::getPassword();
        $this->pdo = new PDO("mysql:host=$hostname;dbname=$databaseName", $login, $password,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // getInstance controllerVoiture'assure que le constructeur ne sera
    // appelé qu'une seule fois.
    // L'unique instance crée est stockée dans l'attribut $instance
    public static function getInstance(): ?DatabaseConnection
    {
        // L'attribut statique $pdo controllerVoiture'obtient avec la syntaxe static::$pdo
        // au lieu de $this->pdo pour un attribut non statique
        if (is_null(static::$instance))
            // Appel du constructeur
            static::$instance = new DatabaseConnection();
        return static::$instance;
    }

}