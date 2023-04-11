<?php

namespace App\eCommerce\Model\Repository;

use App\eCommerce\Model\DataObject\AbstractProduit;
use App\eCommerce\Model\DataObject\Carte as Carte;

class CarteRepository extends AbstractRepository
{

    protected function getNomClePrimaire(): string
    {
        return "nomCarte";
    }

    protected function construire(array $objetFormatTableau): AbstractProduit
    {
        return new Carte(
            $objetFormatTableau["nomCarte"],
            $objetFormatTableau["prix"],
            $objetFormatTableau["categorie"],
            $objetFormatTableau["rarete"]);
    }

    public function getNomTable(): string
    {
        return "cartes";
    }

    public function getNomColonnes(): array
    {
        $list = array(
            "nomCarte",
            "prix",
            "categorie",
            "rarete",
        );
        return $list;
    }
}