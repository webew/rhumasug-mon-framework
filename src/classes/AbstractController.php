<?php

namespace App\classes;

abstract class AbstractController
{
    protected function __construct()
    {
    }

    protected function render($template, $params = null)
    {
        //transforme le tableau $params en variables portant le nom des clés du tableau
        //ces variables sont disponibles dans la vue
        if ($params != null) {
            extract($params);
        }

        include TEMPLATE . '/base.php';
    }
}
