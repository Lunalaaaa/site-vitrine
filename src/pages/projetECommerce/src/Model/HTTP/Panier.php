<?php
namespace App\eCommerce\Model\HTTP;

use App\eCommerce\Lib\ConnexionClient;
use App\eCommerce\Model\DataObject\Client;
use MongoDB\Driver\Exception\ConnectionException;

class Panier
{
    public static function creerPanier(): void
    {
        $panier = array(
            'nomProduit' => array(),
            'quantiteProduit' => array(),
            'prixProduit' => array(),
        );

        if (!(Session::getInstance()->contient('panier'))) {
            Session::getInstance()->enregistrer('panier', $panier);
        }

       else if(!static::estVide('panier') && ConnexionClient::estConnecte() && static::estVide(static::getNomPanierActuelle())){
           $nomPanierClient = 'panier'.ConnexionClient::getMailClientConnecte();
           Session::getInstance()->enregistrer($nomPanierClient, $_SESSION[$nomPanierClient]=$_SESSION['panier']);
          Panier::clear('panier');
       }
       else if(ConnexionClient::estConnecte() && !static::existe('panier'.ConnexionClient::getMailClientConnecte())){
           $nomPanierClient = 'panier'.ConnexionClient::getMailClientConnecte();
           Session::getInstance()->enregistrer($nomPanierClient,$panier);
       }
    }

    public static function getNomPanierActuelle(){
        if(ConnexionClient::estConnecte()){
            $panierClient = 'panier'.ConnexionClient::getMailClientConnecte();
            return $panierClient;
        }
        else return 'panier';
    }

    public static function existe($nomPanier): bool
    {
        return Session::getInstance()->contient($nomPanier);
    }

    public static function ajouterProduit(string $nomProd, int $quantiteProd, float $prixProd): void
    {
        $p = static::getNomPanierActuelle();
        if (static::existe($p)) {
            $produit = array_search($nomProd, $_SESSION[$p]['nomProduit']);
            if ($produit !== false) {
                $_SESSION[$p]['quantiteProduit'][$produit] += $quantiteProd;
            } else {
                array_push( $_SESSION[$p]['nomProduit'],  $nomProd);
                array_push($_SESSION[$p]['quantiteProduit'], $quantiteProd);
                array_push($_SESSION[$p]['prixProduit'], $prixProd);
            }
        }
    }

    public static function estVide($nomPanier):bool{
        if(static::existe($nomPanier) && count($_SESSION[$nomPanier]['nomProduit'])>0){
            return false;
        }
        return true;
    }

    public static function supprimerProduit($nomProd): void
    {
        if(static::existe(static::getNomPanierActuelle())){

            $panierTemp = array(
                'nomProduit' => array(),
                'quantiteProduit' => array(),
                'prixProduit' => array(),
                );

            $p = static::getNomPanierActuelle();

            $produit = array_search($nomProd, $_SESSION[$p]['nomProduit']);
            $_SESSION[$p]['quantiteProduit'][$produit]-=1;

            for($i=0;$i<count($_SESSION[$p]['nomProduit']);$i++){
                if($_SESSION[$p]['quantiteProduit'][$i]>0){
                    array_push($panierTemp['nomProduit'],$_SESSION[$p]['nomProduit'][$i]);
                    array_push($panierTemp['quantiteProduit'],$_SESSION[$p]['quantiteProduit'][$i]);
                    array_push($panierTemp['prixProduit'],$_SESSION[$p]['prixProduit'][$i]);
                }
            }
            $_SESSION[$p]=$panierTemp;
            unset($panierTemp);
        }
    }

    public static function clear($nomPanier):void{
        Session::getInstance()->supprimer($nomPanier);
        static::creerPanier();
    }


}