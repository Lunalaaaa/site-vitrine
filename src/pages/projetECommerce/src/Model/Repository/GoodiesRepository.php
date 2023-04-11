<?php

namespace App\eCommerce\Model\Repository;

use App\eCommerce\Model\DataObject\AbstractProduit;
use App\eCommerce\Model\DataObject\Goodies as Goodies;

class GoodiesRepository extends AbstractRepository
{
    protected function getNomClePrimaire(): string
    {
        return "nomGoodies";
    }

    protected function construire(array $objetFormatTableau): AbstractProduit
    {
        return new Goodies(
            $objetFormatTableau["nomGoodies"],
            $objetFormatTableau["categorie"],
            $objetFormatTableau["prix"]);
    }

    public function getNomTable(): string
    {
        return "goodies";
    }

    public function getNomColonnes(): array
    {
        $list = array(
            "nomGoodies",
            "prix",
            "categorie",
        );
        return $list;
    }
}