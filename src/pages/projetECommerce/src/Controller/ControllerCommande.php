<?php

namespace App\eCommerce\Controller;

use App\eCommerce\Lib\MessageFlash;
use App\eCommerce\Model\HTTP\Commande;
use App\eCommerce\Model\HTTP\Panier;

class ControllerCommande extends GenericController
{

    public static function afficheCommande():void{
        static::afficheVue("view.php",['pagetitle'=>'Historique des commandes','cheminVueBody'=>'PanierView/CommandeView.php']);
    }
    public static function commander():void{
        if(Panier::existe(Panier::getNomPanierActuelle())&&count($_SESSION[Panier::getNomPanierActuelle()]['nomProduit'])>0){
            Commande::passerCommande();
            echo MessageFlash::afficherMessageFlash('success','Commande effectuée !');
            static::afficheVue('view.php',['pagetitle'=>'Historique des commandes','cheminVueBody'=>'PanierView/CommandeView.php']);

        }
        else{
            echo MessageFlash::afficherMessageFlash('warning','Panier vide !');
            static::afficheVue("view.php",['pagetitle'=>'Panier','cheminVueBody'=>'PanierView/PanierView.php']);
        }
    }

    public static function clear():void{
        echo MessageFlash::afficherMessageFlash('success','Commande effacée !');
        static::afficheVue('view.php',['pagetitle'=>'Historique des commandes','cheminVueBody'=>'PanierView/CommandeView.php']);
    }
}