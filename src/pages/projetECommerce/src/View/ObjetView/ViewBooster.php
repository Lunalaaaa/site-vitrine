<?php
echo('<h3>'.'Liste des boosters : '.'</h3>');
foreach ($boosters as $booster){
    $nomBooster = htmlspecialchars($booster->getNomProduit());
    $categorie = htmlspecialchars($booster->getCategorie());
    $prix=htmlspecialchars($booster->getPrixProduit());
    $nbCartes=htmlspecialchars($booster->getNbCartes());
    if(\App\eCommerce\Lib\ConnexionClient::estConnecte() && \App\eCommerce\Lib\ConnexionClient::estAdministrateur()){
        $modif = "frontController.php?action=update&controller=booster&nomProduit=" . $nomBooster;
        $delete = "frontController.php?action=delete&controller=booster&nomProduit=" . $nomBooster;
        echo("<p>".$nomBooster.' '.$categorie.' '.$nbCartes.' '.$prix.'€'. ' <a href='. $modif . '> Modifier</a>' . ' <a href='. $delete .'> Supprimer </a></p>'
            .'<form action="frontController.php?controller=panier&action=ajouterProduit" method=post>
         <input type="hidden" name="nomProduit" value="'.$nomBooster.'">'
            .'<input type="hidden" name="prixProduit" value='.$prix.'>'
            .'<button type="submit">'.'Ajouter au panier'.'</button>'
            .'</form>');
    }
    else{
        echo("<p>".$nomBooster.' '.$categorie.' '.$nbCartes.' '.$prix.'€'.'</p>'
            .'<form action="frontController.php?controller=panier&action=ajouterProduit" method=post>
         <input type="hidden" name="nomProduit" value="'.$nomBooster.'">'
            .'<input type="hidden" name="prixProduit" value='.$prix.'>'
            .'<button type="submit">'.'Ajouter au panier'.'</button>'
            .'</form>');
    }
}
if(\App\eCommerce\Lib\ConnexionClient::estConnecte() && \App\eCommerce\Lib\ConnexionClient::estAdministrateur()){
    echo "<a href='frontController.php?action=create&controller=booster'>Créer un booster</a>";
}