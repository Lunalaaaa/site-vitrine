<?php
use App\eCommerce\Lib\ConnexionClient;
use App\eCommerce\Model\HTTP\Panier;
echo('<h3>'.'Panier :'.'</h3>');
$montant =0;

$p = Panier::getNomPanierActuelle();
if(!Panier::estVide(Panier::getNomPanierActuelle())){
    for($i=0;$i<count($_SESSION[$p]['nomProduit']);$i++){
        $nomProduit =htmlspecialchars($_SESSION[$p]['nomProduit'][$i]);
        $prixProduit =htmlspecialchars($_SESSION[$p]['prixProduit'][$i]) ;
        $quantiteProduit = htmlspecialchars($_SESSION[$p]['quantiteProduit'][$i]);
        $montant+=$prixProduit*$quantiteProduit;
        echo(
            '<p>'.'Nom du produit : '.$nomProduit .'</p>'.
            '<p>'.'Prix du produit : '.$prixProduit.'</p>'.
            '<p>'.'Quantite du produit :'.$quantiteProduit.'</p>'.
            '<form action="frontController.php?controller=panier&action=supprimerProduit" method=post>
         <input type="hidden" name="nomProduit" value="'.$nomProduit.'">
         <button type="submit">'.'Supprimer'.'</button></form>'
            .'<br>'
        );
    }
    echo('<p>'.'Montant total :'.$montant.'</p>');
}

else{
    echo('Panier Vide !');
}



if(ConnexionClient::estConnecte()&&!Panier::estVide(Panier::getNomPanierActuelle())){
    echo('<form action="frontController.php?controller=commande&action=commander" method="post" xmlns="http://www.w3.org/1999/html">'
            .'Saisir votre adresse <input type="text" name="livraison" required>'
          .' <button type="submit">'.'Passer commande'.'</button>'
        .'</form>');
}
echo('<p><a href="frontController.php?controller=panier&action=clear">'.'Effacer panier'.'</a></p>');
