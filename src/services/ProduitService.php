<?php

namespace App\services;

use App\classes\Bdd;

class ProduitService
{
    public static function findAll()
    {
        $stmt = Bdd::getInstance()->prepare("SELECT * FROM produit");
        $stmt->execute();
        $catalogue = $stmt->fetchAll();
        return $catalogue;
    }
}
