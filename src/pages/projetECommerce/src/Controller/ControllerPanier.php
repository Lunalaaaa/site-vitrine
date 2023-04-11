<?php

namespace App\eCommerce\Controller;

use App\eCommerce\Lib\MessageFlash;
use App\eCommerce\Model\HTTP\Panier;


class ControllerPanier extends GenericController {


    public static function affichePanier():void{
        if(!Panier::existe(Panier::getNomPanierActuelle())){
            Panier::creerPanier();
            if(Panier::existe(Panier::getNomPanierActuelle())){
               //echo MessageFlash::afficherMessageFlash('success','Panier crée');
            }
        }
        static::afficheVue("view.php",['pagetitle'=>'Panier','cheminVueBody'=>'PanierView/PanierView.php']);
    }
    public static function ajouterProduit():void{
        Panier::ajouterProduit($_POST['nomProduit'],1,$_POST['prixProduit']);
        echo MessageFlash::afficherMessageFlash('success','Produit ajouté !');
        static::afficheVue("view.php",['pagetitle'=>'Panier ajout','cheminVueBody'=>'PanierView/PanierView.php']);
    }

    public static function supprimerProduit():void{
        Panier::supprimerProduit($_POST['nomProduit']);
        echo MessageFlash::afficherMessageFlash('success','Produit supprimé !');
        static::afficheVue("view.php",['pagetitle'=>'Panier ajout','cheminVueBody'=>'PanierView/PanierView.php']);
    }

    public static function clear():void{
        Panier::clear(Panier::getNomPanierActuelle());
        echo MessageFlash::afficherMessageFlash('success','Panier effacé !');
        static::afficheVue('view.php',['pagetitle'=>'Panier','cheminVueBody'=>'PanierView/PanierView.php']);
    }
}