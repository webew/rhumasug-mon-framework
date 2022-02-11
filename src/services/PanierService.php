<?php

namespace App\services;

use App\classes\Bdd;

class PanierService
{

    public static function addProduit()
    {
        // récupération des données du client (produit à ajouter)
        $produitsAjoutes = trim(file_get_contents("php://input"));
        $produitsAjoutesArray = json_decode($produitsAjoutes, true);
        $key = array_keys($produitsAjoutesArray)[0]; //l'id du produit
        $qtite = array_values($produitsAjoutesArray)[0]; //la quantite du produit

        if ($qtite == 0) {
            unset($_SESSION["panier"][$key]);
        } else {
            $_SESSION["panier"][$key] = $qtite;
        }

        echo json_encode($_SESSION["panier"]);
    }

    public static function produitsBddToSession()
    {
        $stmt = Bdd::getInstance()->prepare("SELECT * FROM vue_vente_contenir_produits WHERE vente.idUser = ? AND vente.etat=0");
        $stmt->execute([
            $_SESSION["idUser"]
        ]);
        $produitsUser = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // on met tous les produits en session, en ajoutant à ceux déjà présents
        foreach ($produitsUser as $produit) {
            // on ajoute les produits enregistrés en bdd à ceux éventuellement présents en session
            if (isset($_SESSION["panier"][$produit["idProduit"]])) {
                $_SESSION["panier"][$produit["idProduit"]] += $produit["quantite"];
            } else {
                $_SESSION["panier"][$produit["idProduit"]] = $produit["quantite"];
            }
        }
    }

    public static function mergeBddProduitsWithSession()
    {
        Bdd::getInstance()->beginTransaction();
        // on supprime le panier en cours (etat=0)
        $sqlDeletePanier = "DELETE FROM vente WHERE idUser=1 and etat=0";
        $stmtDeletePanier = Bdd::getInstance()->prepare($sqlDeletePanier);
        $stmtDeletePanier->execute();
        // on récrée le panier (la vente avec l'état 0)
        $sqlVente = "INSERT INTO vente(idVente,dateVente,idUser,etat) VALUES (NULL,now() ,?,0) ";
        $stmt = Bdd::getInstance()->prepare($sqlVente);
        $stmt->execute([$_SESSION["idUser"]]);
        $idVente = Bdd::getInstance()->lastInsertId(); // récupération de l'id du dernier enregistrement
        // on recherche dans la table produit les produits présents en session, pour récupérer le prix de chacun
        $idsProduits = implode(',', array_keys($_SESSION["panier"]));
        $stmt = Bdd::getInstance()->prepare("SELECT * FROM produit WHERE idProduit IN ($idsProduits)");
        $stmt->execute();
        $produitsAInserer = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        // on crée un enregitrement pour chaque produit à insérer
        $valuesTab = [];
        foreach ($produitsAInserer as $produit) {
            $prixVente = $produit["prixProduit"];
            $idProduit = $produit["idProduit"];
            $quantite = $_SESSION['panier'][$produit["idProduit"]];
            $valuesTab[] = "($idVente,$idProduit,$quantite,$prixVente)";
        }
        $strValues = implode(',', $valuesTab);

        $sqlPanier = "INSERT INTO contenir(idVente, idProduit, quantite, prixVente) VALUES $strValues";
        $stmtPanier = Bdd::getInstance()->prepare($sqlPanier);
        $stmtPanier->execute();
        // on envoie toutes les requêtes
        Bdd::getInstance()->commit();
    }

    public static function calculMontant()
    {
        // calcul du montant du panier en bdd
        $stmt = Bdd::getInstance()->prepare("SELECT SUM(contenir.quantite*contenir.prixVente) as total FROM contenir 
                        JOIN vente ON contenir.idVente=vente.idVente
                        WHERE vente.idUser = ? AND vente.etat=0");
        $stmt->execute([
            $_SESSION["idUser"]
        ]);
        $montant = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $montant;
    }

    public static function validerPaiement()
    {
        $stmt = Bdd::getInstance()->prepare("UPDATE vente SET etat='1' WHERE idUser=?");
        $stmt->execute([$_SESSION["idUser"]]);
    }
}
