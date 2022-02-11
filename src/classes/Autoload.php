<?php

namespace App\classes;

/**
 * Class Autoloader
 * @package App
 */
class Autoloader
{
    /**
     * Enregistre l'autoloader
     */
    static function register()
    {
        spl_autoload_register(function ($class) {
            // var_dump(__NAMESPACE__);
            // var_dump($class);

            foreach (AUTOLOAD_NAMESPACES as $namespace => $classe) {
                // chargement des classes du dossier src/classes
                $class1 = str_replace($namespace . '\\', '', $class);
                $class1 = str_replace('\\', '/', $class1);
                // var_dump($classe . '/' . $class1 . '.php');
                if (file_exists($classe . '/' . $class1 . '.php')) {
                    require_once $classe . '/' . $class1 . '.php';
                }
            }
        });
    }
}
