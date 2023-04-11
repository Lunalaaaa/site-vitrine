<?php

namespace App\eCommerce\Model\Repository;

use App\eCommerce\Model\DataObject\AbstractProduit;
use App\eCommerce\Model\DataObject\Booster as Booster;

class BoosterRepository extends AbstractRepository
{

    protected function getNomClePrimaire(): string
    {
        return "nomBooster";
    }

    protected function construire(array $objetFormatTableau): AbstractProduit
    {
        return new Booster(
            $objetFormatTableau["nomBooster"],
            $objetFormatTableau["prix"],
            $objetFormatTableau["categorie"],
            $objetFormatTableau["nbCartes"]);
    }

    public function getNomTable(): string
    {
        return "boosters";
    }

    public function getNomColonnes(): array
    {
        $list = array(
            "nomBooster",
            "categorie",
            "prix",
            "nbCartes",
        );
        return $list;
    }
}