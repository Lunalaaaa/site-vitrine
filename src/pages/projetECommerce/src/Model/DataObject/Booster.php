<?php

namespace App\eCommerce\Model\DataObject;

class Booster extends AbstractProduit
{
    private $nomBooster;
    private $categorie;
    private $prix;
    private $nbCartes;

    public function __construct($nomBooster, $prix, $categorie, $nbCartes)
    {
        $this->nomBooster = $nomBooster;
        $this->prix = $prix;
        $this->categorie = $categorie;
        $this->nbCartes = $nbCartes;
    }

    public function getNomProduit(): string
    {
        return $this->nomBooster;
    }


    public function getCategorie(): string
    {
        return $this->categorie;
    }

    /**
     * @return mixed
     */
    public function getPrixProduit()
    {
        return $this->prix;
    }

    public function getNbCartes()
    {
        return $this->nbCartes;
    }


    public function getType(): string
    {
        return "Booster";
    }

    public function formatTableau($object): array
    {
        $list = array(
            "nomBoosterTag" => $object->getNomProduit(),
            "categorieTag" => $object->getCategorie(),
            "prixTag" => $object->getPrixProduit(),
            "nbCartesTag" => $object->getNbCartes(),
        );
        return $list;
    }

    /**
     * @param mixed $nomBooster
     */
    public function setNomBooster($nomBooster): void
    {
        $this->nomBooster = $nomBooster;
    }

    /**
     * @param mixed $categorie
     */
    public function setCategorie($categorie): void
    {
        $this->categorie = $categorie;
    }

    /**
     * @param mixed $prix
     */
    public function setPrix($prix): void
    {
        $this->prix = $prix;
    }

    /**
     * @param mixed $nbCartes
     */
    public function setNbCartes($nbCartes): void
    {
        $this->nbCartes = $nbCartes;
    }


}