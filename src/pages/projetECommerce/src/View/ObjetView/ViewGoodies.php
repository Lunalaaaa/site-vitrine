
<?php
echo("<h3>".'Liste des goodies : </h3>');
foreach ($goodies as $goodie){
    $nom =htmlspecialchars($goodie->getNomProduit());
    $prix=htmlspecialchars($goodie->getPrixProduit());
    $categorie=htmlspecialchars($goodie->getCategorie());
    if(\App\eCommerce\Lib\ConnexionClient::estConnecte() && \App\eCommerce\Lib\ConnexionClient::estAdministrateur()){
        $modif = "frontController.php?action=update&controller=carte&nomProduit=" . $nom;
        $delete = "frontController.php?action=delete&controller=carte&nomProduit=" . $nom;
        echo("<p>" . $nom . ' ' . $categorie . ' '.$prix.'€'. ' <a href='. $modif . '> Modifier</a>' . ' <a href='. $delete .'> Supprimer </a></p>'
            . '<form action="frontController.php?controller=panier&action=ajouterProduit" method="post">
        <input type="hidden" name="nomProduit" value="' . $nom . '">
        <input type="hidden" name="prixProduit" value=' . $prix . '>
        <button type="submit">' . 'Ajouter au panier' . '</button></form>');
    }
    else{
        echo("<p>" . $nom . ' ' . $categorie . ' ' . $prix . '€' . '</p>'
            . '<form action="frontController.php?controller=panier&action=ajouterProduit" method="post">
        <input type="hidden" name="nomProduit" value="' . $nom . '">
        <input type="hidden" name="prixProduit" value=' . $prix . '>
        <button type="submit">' . 'Ajouter au panier' . '</button></form>');
    }
}
if(\App\eCommerce\Lib\ConnexionClient::estConnecte() && \App\eCommerce\Lib\ConnexionClient::estAdministrateur()){
    echo "<a href='frontController.php?action=create&controller=goodies'>Créer un goodies</a>";
}