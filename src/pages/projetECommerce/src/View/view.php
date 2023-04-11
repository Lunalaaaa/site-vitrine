<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title><?php use App\eCommerce\Lib\ConnexionClient;

        echo $pagetitle; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">

</head>
<body>
<header>
    <nav>
        <ul>
        <!-- Votre menu de navigation ici -->
            <li><a href="frontController.php">Accueil</a></li>
            <li><a href="frontController.php?action=readAll&controller=carte">Cartes</a></li>
            <li><a href="frontController.php?action=readAll&controller=booster">Boosters</a></li>
            <li><a href="frontController.php?action=readAll&controller=goodies">Goodies</a></li>
            <li><a href="frontController.php?action=affichePanier&controller=panier">Panier</a></li>
            <?php
            if(\App\eCommerce\Lib\ConnexionClient::estConnecte()){
                echo('<li><a href="frontController.php?action=afficheCommande&controller=commande">Historique</a></li>');
                if(ConnexionClient::estAdministrateur()){
                    echo '<li><a href="frontController.php?action=readAll&controller=client"><img src="../assets/images/user.png" alt="user"></a></li>';
                }
                else{
                    echo '<li><a href="frontController.php?action=read&mailClient='.ConnexionClient::getMailClientConnecte().'&controller=client"><img src="../assets/images/user.png" alt="user"></a></li>';
                }
                echo '<li><a href="frontController.php?controller=client&action=deconnecter"><img src="../assets/images/logout.png" alt="logout"></a></li>';
            }
            else{
                echo '<li><a href="frontController.php?controller=client&action=formulaireConnexion"><img src="../assets/images/enter.png" alt="enter"></a></li>';
            }
            ?>
        </ul>
    </nav>

</header>
<main>
    <?php
    require __DIR__ . "/{$cheminVueBody}";
    ?>
</main>
<footer>
        <p>
            Site de e-Commerce
        </p>
</footer>
</body>
</html>
