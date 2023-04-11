<?php

namespace App\eCommerce\Model\DataObject;
class Carte extends AbstractProduit
{

    private $nomCarte;
    private $categorie;
    private $prix;
    private $rarete;

    public function __construct($nomCarte, $prix, $categorie, $rarete)
    {
        $this->nomCarte = $nomCarte;
        $this->prix = $prix;
        $this->categorie = $categorie;
        $this->rarete = $rarete;
    }

    public function formatTableau($object): array
    {
        $list = array(
            "nomCarteTag" => $object->getNomProduit(),
            "categorieTag" => $object->getCategorie(),
            "prixTag" => $object->getPrixProduit(),
            "rareteTag" => $object->getRarete(),
        );
        return $list;
    }

    /**
     * @return mixed
     */
    public function getNomProduit(): string
    {
        return $this->nomCarte;
    }

    public function getRarete(): string
    {
        return $this->rarete;
    }

    /**
     * @return mixed
     */
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

    public function getType(): string
    {
        return "Carte";
    }

    /**
     * @param mixed $nomCarte
     */
    public function setNomCarte($nomCarte): void
    {
        $this->nomCarte = $nomCarte;
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
     * @param mixed $rarete
     */
    public function setRarete($rarete): void
    {
        $this->rarete = $rarete;
    }


}