<?php

namespace App\services;

class NavigationService
{
    public static function getPreviousPage()
    {
        $explodeUrl = explode("/", $_SERVER["HTTP_REFERER"]);
        $page = end($explodeUrl);
        $page = in_array($page, ROUTES) ? $page : "accueil";
        header("location:" . $page);
    }
}
