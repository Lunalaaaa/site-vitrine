<?php

namespace App\eCommerce\Model\DataObject;

use App\eCommerce\Lib\MotDePasse;
use App\eCommerce\Model\Repository\DatabaseConnection;
use PDOException;

class Client extends AbstractProduit {
    private $nomClient;
    private $prenomClient;
    private $livraison;
    private $mailClient;
    private $mdpHache;
    private $typeClient;

    /**
     * @param $nomClient
     * @param $prenomClient
     * @param $livraison
     * @param $mailClient
     * @param $mdpHache
     * @param $typeClient
     */
    public function __construct($nomClient, $prenomClient, $livraison, $mailClient, $mdpHache, $typeClient)
    {
        $this->nomClient = $nomClient;
        $this->prenomClient = $prenomClient;
        $this->livraison = $livraison;
        $this->mailClient = $mailClient;
        $this->mdpHache = $mdpHache;
        $this->typeClient = $typeClient;
    }

    /**
     * @return mixed
     */
    public function getNomClient()
    {
        return $this->nomClient;
    }

    /**
     * @param mixed $nomClient
     */
    public function setNomClient($nomClient): void
    {
        $this->nomClient = $nomClient;
    }

    /**
     * @return mixed
     */
    public function getPrenomClient()
    {
        return $this->prenomClient;
    }

    /**
     * @param mixed $prenomClient
     */
    public function setPrenomClient($prenomClient): void
    {
        $this->prenomClient = $prenomClient;
    }

    /**
     * @return mixed
     */
    public function getMailClient()
    {
        return $this->mailClient;
    }

    /**
     * @param mixed $mailClient
     */
    public function setMailClient($mailClient): void
    {
        $this->mailClient = $mailClient;
    }

    /**
     * @return mixed
     */
    public function getMdpHache()
    {
        return $this->mdpHache;
    }

    /**
     * @param mixed $mdpHache
     */
    public function setMdpHache(string $mdpHache): void
    {
        $this->mdpHache = MotDePasse::hacher($mdpHache);
    }

    /**
     * @return mixed
     */
    public function getTypeClient()
    {
        return $this->typeClient;
    }

    /**
     * @param mixed $typeClient
     */
    public function setTypeClient($typeClient): void
    {
        $this->typeClient = $typeClient;
    }

    /**
     * @return mixed
     */
    public function getLivraison()
    {
        return $this->livraison;
    }

    /**
     * @param mixed $livraison
     */
    public function setLivraison($livraison): void
    {
        $this->livraison = $livraison;
    }

    public static function builder($clientFormatTableau): Client
    {
        return new Client($clientFormatTableau['nomClient'], $clientFormatTableau['prenomClient'], $clientFormatTableau['livraison'] ,$clientFormatTableau['mailClient'], $clientFormatTableau['mdpHache'], $clientFormatTableau['typeClient']);
    }

    public function getType(): string {
        return "";
    }

    public function formatTableau($object): array {
        return array(
            'nomClientTag' => $object->nomClient,
            'prenomClientTag' => $object->prenomClient,
            'livraisonTag' => $object->livraison,
            'mailClientTag' => $object->mailClient,
            'mdpHacheTag' => $object->mdpHache,
            'typeClientTag' => $object->typeClient,
        );
    }

    public function getNomProduit(): string {
        return "";
    }

    public function getPrixProduit() {
    }

}