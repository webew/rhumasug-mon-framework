<?php

namespace App\controller;

use App\classes\AbstractController;
use App\services\NavigationService;
use App\services\PanierService;
use App\services\ProduitService;

class AppController extends AbstractController
{

    public function __construct()
    {
    }

    public function accueil()
    {
        $this->render('accueil.php', ["catalogue" => ProduitService::findAll()]);
    }

    public function addProduit()
    {
        PanierService::addProduit();
    }

    public function panier()
    {
        $this->render('panier.php');
    }

    public function page404()
    {
        $this->render('404.php');
    }

    public function paiement()
    {
        if (isset($_SESSION["idUser"])) {
            $this->render("paiement.php", ["montant" => PanierService::calculMontant()]);
        }
    }
    public function validerPaiement()
    {
        PanierService::validerPaiement();
        unset($_SESSION["panier"]);
        header("location:accueil");
    }

    public function validerPanier()
    {
        if (isset($_SESSION["idUser"])) {
            if (isset($_SESSION["panier"])) {
                PanierService::mergeBddProduitsWithSession();
                header("location:paiement");
            }
        }
    }

    private function isUserValid()
    {
        return 1;
    }

    /**
     * TODO : service de validation de la connexion du user
     */
    public function login()
    {
        if (!isset($_SESSION["idUser"])) {

            // on connecte l'utilisateur
            $_SESSION["idUser"] = $this->isUserValid();

            // s'il y a des produits dans le panier en bdd, on les récupère
            PanierService::produitsBddToSession();

            // on redirige vers la page d'origine
            NavigationService::getPreviousPage();
        }
    }

    public function logout()
    {
        unset($_SESSION["idUser"]);
        // on redirige vers la page d'origine
        NavigationService::getPreviousPage();
    }

    public function jsonToto()
    {
        echo json_encode(['toto' => 'toto']);
    }
}
