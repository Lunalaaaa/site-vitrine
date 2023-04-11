<?php
use App\eCommerce\Model\Repository\CommandeRepository;
use App\eCommerce\Lib\ConnexionClient;
echo('<h3>'.'Historique des commandes :'.'</h3>');


if(!(new CommandeRepository())->estVide(ConnexionClient::getMailClientConnecte())){
    $commandes = (new CommandeRepository())->selectAllContenir(ConnexionClient::getMailClientConnecte());

    foreach ($commandes as $commande){
        $montantCommande=0;
        $nomProduit =htmlspecialchars($commande['nomProduit']);
        $prixProduit =htmlspecialchars($commande['prix']) ;
        $quantiteProduit = htmlspecialchars($commande['quantite']);
        $numCommande = htmlspecialchars($commande['numCommande']);
        $montantCommande += $prixProduit*$quantiteProduit;
        $livraison = htmlspecialchars($commande['livraison']);

        echo(
            '<h4>'.'Commande numéro '.$numCommande .'</h4>'.
            '<p>'.'Nom du produit : '.$nomProduit.'</p>'.
            '<p>'.'Prix du produit : '.$prixProduit.'</p>'.
            '<p>'.'Quantite du produit :'.$quantiteProduit.'</p>'.
            '<p>'.'Montant de la commande : '.$montantCommande.'</p>'.
            '<p>'.'Adresse de livraison : '.$livraison.'</p>'.
            '<br>'
        );
    }
}
else{
    echo('<p>Aucune commande</p>');
}