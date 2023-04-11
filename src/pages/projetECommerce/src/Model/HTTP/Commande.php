<?php

namespace App\eCommerce\Model\HTTP;

use App\eCommerce\Lib\ConnexionClient;
use App\eCommerce\Lib\MessageFlash;
use App\eCommerce\Model\Repository\CommandeRepository;

class Commande
{
    public static function passerCommande(){ // l'utilisateur est normalment connecté
        $p = Panier::getNomPanierActuelle();
        if(Panier::existe($p)&&count($_SESSION[$p]['nomProduit'])>0){
            for($i=0;$i<count($_SESSION[$p]['nomProduit']);$i++){
                $numC = (new CommandeRepository())->getLastNumC()+1;
                $nomProduit =$_SESSION[$p]['nomProduit'][$i];
                $prix = $_SESSION[$p]['prixProduit'][$i];
                $mailClient = ConnexionClient::getMailClientConnecte();
                $quantite = $_SESSION[$p]['quantiteProduit'][$i];
                $livraison = $_POST['livraison'];
                (new CommandeRepository())->createCommande($nomProduit,$mailClient,$quantite,$prix,$numC,$livraison);
            }

            Panier::clear(Panier::getNomPanierActuelle());
        }
        else if(count($_SESSION[$p]['nomProduit'])<=0) {
            MessageFlash::afficherMessageFlash('success','Panier vide !');
        }
    }
}