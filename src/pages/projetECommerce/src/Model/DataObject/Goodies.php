<?php

namespace App\eCommerce\Model\DataObject;

class Goodies extends AbstractProduit
{
    private $nomGoodies;
    private $categorie;
    private $prix;

    public function __construct($nomGoodies, $categorie, $prix)
    {
        $this->nomGoodies = $nomGoodies;
        $this->prix = $prix;
        $this->categorie = $categorie;
    }

    public function formatTableau($object): array
    {
        $list = array(
            "nomGoodiesTag" => $object->getNomProduit(),
            "categorieTag" => $object->getCategorie(),
            "prixTag" => $object->getPrixProduit(),
        );
        return $list;
    }

    public function getNomProduit(): string
    {
        return $this->nomGoodies;
    }


    public function getCategorie(): string
    {
        return $this->categorie;
    }


    public function getPrixProduit()
    {
        return $this->prix;
    }


    public function getType(): string
    {
        return "Goodies";
    }

    /**
     * @param mixed $nomGoodies
     */
    public function setNom($nomGoodies): void
    {
        $this->nomGoodies = $nomGoodies;
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


}