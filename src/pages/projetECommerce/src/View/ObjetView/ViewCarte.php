<?php
echo('<h3>'.'Liste des cartes : </h3>');
foreach ($cartes as $carte){
    $nom =htmlspecialchars($carte->getNomProduit());
    $prix=htmlspecialchars($carte->getPrixProduit());
    $categorie=htmlspecialchars($carte->getCategorie());
    $rarete=htmlspecialchars($carte->getRarete());
    if(\App\eCommerce\Lib\ConnexionClient::estConnecte() && \App\eCommerce\Lib\ConnexionClient::estAdministrateur()){
        $modif = "frontController.php?action=update&controller=carte&nomProduit=" . $nom;
        $delete = "frontController.php?action=delete&controller=carte&nomProduit=" . $nom;
        echo("<p>".$nom.' '.$categorie.' '.$rarete.' '.$prix.'€'. ' <a href='. $modif . '> Modifier</a>' . ' <a href='. $delete .'> Supprimer </a></p>'
            .'<form action="frontController.php?controller=panier&action=ajouterProduit" method=post>
         <input type="hidden" name="nomProduit" value="'.$nom.'">'
            .'<input type="hidden" name="prixProduit" value='.$prix.'>'
            .'<button type="submit">'.'Ajouter au panier'.'</button>'
            .'</form>');
    }
    else{
        echo("<p>".$nom.' '.$categorie.' '.$rarete.' '.$prix.'€'.'</p>'
            .'<form action="frontController.php?controller=panier&action=ajouterProduit" method=post>
         <input type="hidden" name="nomProduit" value="'.$nom.'">'
            .'<input type="hidden" name="prixProduit" value='.$prix.'>'
            .'<button type="submit">'.'Ajouter au panier'.'</button>'
            .'</form>');
    }
}
if(\App\eCommerce\Lib\ConnexionClient::estConnecte() && \App\eCommerce\Lib\ConnexionClient::estAdministrateur()){
    echo "<a href='frontController.php?action=create&controller=carte'>Créer une carte</a>";
}