<?php

namespace App\eCommerce\Model\DataObject;

abstract class AbstractProduit
{
    private $nomProduit;
    private $categorie; //Marque
    private $type; //objet
    private $prix;


    public function __construct($nomProduit, $prix, $categorie)
    {
        $this->nomProduit = $nomProduit;
        $this->prix = $prix;
        $this->categorie = $categorie;
        $this->type = $this->getType();
    }

    public abstract function getType(): string;

    public abstract function formatTableau($object): array;

    public abstract function getNomProduit(): string;

    public abstract function getPrixProduit();

}