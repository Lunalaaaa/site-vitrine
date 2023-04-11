<?php

namespace App\eCommerce\Model\Repository;

use App\eCommerce\Controller\GenericController;
use App\eCommerce\Model\DataObject\AbstractProduit;
use App\eCommerce\Model\DataObject\Client;
use PDOException;

class ClientRepository extends AbstractRepository {

    protected function getNomClePrimaire(): string
    {
        return 'mailClient';
    }

    protected function construire(array $objetFormatTableau): AbstractProduit
    {
        return new Client($objetFormatTableau['nomClient'],
            $objetFormatTableau['prenomClient'],
            $objetFormatTableau['livraison'],
            $objetFormatTableau['mailClient'],
            $objetFormatTableau['mdpHache'],
            $objetFormatTableau['typeClient']);
    }

    protected function getNomTable(): string
    {
        return 'clients';
    }

    protected function getNomColonnes(): array
    {
        return array("nomClient", "prenomClient", "livraison", "mailClient", "mdpHache", "typeClient");
    }


}