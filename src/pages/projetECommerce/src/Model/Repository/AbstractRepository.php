<?php

namespace App\eCommerce\Model\Repository;

use App\eCommerce\Model\DataObject\AbstractProduit;
use PDOException;

abstract class AbstractRepository
{
    public function selectAll(): array
    {
        $nomTable = $this->getNomTable();
        $pdoStatement = DatabaseConnection::getPdo()->query('SELECT * FROM ' . $nomTable);
        $tableau = [];
        foreach ($pdoStatement as $objetFormatTableau) {
            $tableau[] = $this->construire($objetFormatTableau);
        }
        return $tableau;
    }

    public function select(string $valeurClePrimaire): ?AbstractProduit
    {
        $sql = 'SELECT * from ' . $this->getNomTable() . ' WHERE ' . $this->getNomClePrimaire() . '= :ClePrimaireTag';
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
        $values = array(
            "ClePrimaireTag" => $valeurClePrimaire,
        );
        $pdoStatement->execute($values);
        $objet = $pdoStatement->fetch();
        if (!$objet) {
            return null;
        } else {
            return $this->construire($objet);
        }
    }


    public function delete(string $valeurClePrimaire)
    {
        $sql = 'DELETE FROM ' . $this->getNomTable() . ' WHERE ' . $this->getNomClePrimaire() . '= :ClePrimaireTag';
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
        $values = array(
            "ClePrimaireTag" => $valeurClePrimaire
        );
        try {
            $pdoStatement->execute($values);
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }

    public function update(AbstractProduit $object, String $oldName): void
    {
        $valuesObject = $object->formatTableau($object);
        $valuesObject['oldNameTag'] = $oldName;
        $array = $this->getNomColonnes();
        $colonnes = "";
        foreach ($array as $item) {
            $colonnes = $colonnes . $item . "=:" . $item . "Tag,";
        }
        $colonnes = rtrim($colonnes, ",");
        $sql = "UPDATE {$this->getNomTable()} SET $colonnes WHERE {$this->getNomClePrimaire()}=:oldNameTag";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
        $pdoStatement->execute($valuesObject);
    }


    public function sauvegarder(AbstractProduit $object): bool
    {
        $valuesObject = $object->formatTableau($object);
        $array = $this->getNomColonnes();
        $colonnesTag = "";
        foreach ($array as $item) {
            $colonnesTag = $colonnesTag . ":" . $item . "Tag,";
        }
        $colonnesTag = rtrim($colonnesTag, ",");

        $colonnes = "";
        foreach ($array as $item) {
            $colonnes = $colonnes . $item . ",";
        }
        $colonnes = rtrim($colonnes, ",");

        $sql = "INSERT INTO {$this->getNomTable()} ({$colonnes}) VALUES ({$colonnesTag})";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);

        try {
            $pdoStatement->execute($valuesObject);
            return true;
        } catch (PDOException $exception) {
            return false;
        }

    }

    public static function create(string $objetName, array $objetFormatTableau): ?AbstractProduit
    {
        switch ($objetName) {
            case "goodies" :
                return (new GoodiesRepository)->construire($objetFormatTableau);
            case "cartes" :
                return (new CarteRepository)->construire($objetFormatTableau);
            case "booster" :
                return (new BoosterRepository())->construire($objetFormatTableau);
        }
        return null;
    }

    public function getPokemonProduct()
    {
        $nomTable = $this->getNomTable();
        $sql = "SELECT * FROM $nomTable WHERE categorie='pokemon'";

        $pdoStatement = model::getPdo()->query($sql);
        $tableau = array();
        foreach ($pdoStatement as $objet) {

            $tableau[] = $this->construire($objet);
        }
        return $tableau;

    }

    public function getYuGiOhProduct()
    {
        $nomTable = $this->getNomTable();
        $sql = "SELECT * FROM $nomTable WHERE categorie='yu-gi-oh'";

        $pdoStatement = model::getPdo()->query($sql);
        $tableau = array();
        foreach ($pdoStatement as $objet) {
            $tableau[] = $this->construire($objet);
        }
        return $tableau;
    }

    public function getMagicProduct()
    {
        $nomTable = $this->getNomTable();
        $sql = "SELECT * FROM $nomTable WHERE categorie='magic'";

        $pdoStatement = model::getPdo()->query($sql);
        $tableau = array();
        foreach ($pdoStatement as $objet) {

            $tableau[] = $this->construire($objet);
        }
        return $tableau;
    }

    public function getPrix($nomProduit):float{
        $nomtable = $this->getNomTable();
        $clePrimaire = $this->getNomClePrimaire();
        $sql = "SELECT prix FROM $this->getnomCl WHERE $clePrimaire=$nomProduit";
        $pdoStatement = DatabaseConnection::getPdo()->query($sql);
        $res=$pdoStatement->fetch();
        return $res['prix'];
    }


    protected abstract function getNomClePrimaire(): string;

    protected abstract function construire(array $objetFormatTableau): AbstractProduit;

    protected abstract function getNomTable(): string;

    protected abstract function getNomColonnes(): array;
}