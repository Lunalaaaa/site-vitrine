<?php

namespace App\eCommerce\Model\Repository;

use App\eCommerce\Model\DataObject\AbstractProduit;
use App\eCommerce\Model\DataObject\Carte as Carte;

class CommandeRepository
{
    public function selectCommandes($mailClient){
        $sql = "SELECT * FROM commandes  WHERE mailClient='$mailClient'";
        $pdoStatement = DatabaseConnection::getPdo()->query($sql);
        $tableau = [];
        foreach ($pdoStatement as $objetFormatTableau) {
            $tableau[] = $this->construire($objetFormatTableau);
        }
        return $tableau;
    }

    public function selectAllContenir($mailClient){
        $sql = "SELECT * FROM commandes co JOIN contenir c ON c.numcommande=co.numcommande WHERE mailClient='$mailClient'";

            $pdoStatement = DatabaseConnection::getPdo()->query($sql);
            $tableau = [];
            foreach ($pdoStatement as $objetFormatTableau) {
                $tableau[] = array(
                    'numCommande'=>$objetFormatTableau['numCommande'],
                    'nomProduit'=>$objetFormatTableau['nomProduit'],
                    'prix'=>$objetFormatTableau['prix'],
                    'quantite'=>$objetFormatTableau['quantite'],
                    'dateCommande'=>$objetFormatTableau['dateCommande'],
                    'livraison'=>$objetFormatTableau['livraison'],
                    );

            }
            return $tableau;

    }

    public  function estVide($mailClient):bool
    {
        $sql = "SELECT COUNT(*) as nb FROM commandes co JOIN contenir c ON c.numCommande=co.numCommande WHERE mailClient='$mailClient'";
        $pdoStatement = DatabaseConnection::getPdo()->query($sql);
        $res = $pdoStatement->fetch();
        if($res['nb']==0){
            return true;
        }
        return false;
    }
    public function createCommande(string $nomProduit,string $mailClient,int $quantite,float $prix,int $numCommande,string $livraison):void{
        $nom = "'$nomProduit'";
        $livr = "'$livraison'";
        $mail = "'$mailClient'";
        $pdoStatement = DatabaseConnection::getPdo()->query("CALL CommandeAjout($nom,$mail,$quantite,$prix,$numCommande,$livr)");
    }

    public function getLastNumC():int{
        $sql = "SELECT MAX(numcommande) as maxNum FROM commandes";
        $pdoStatement = DatabaseConnection::getPdo()->query($sql);
        $res=$pdoStatement->fetch();
        if($res['maxNum']!=null){
            return $res['maxNum'];
        }
        else{
            return 0;
        }

    }
}