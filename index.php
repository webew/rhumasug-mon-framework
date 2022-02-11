<?php
session_start();
// namespace App\classes;

use App\classes\Autoloader;
use App\classes\Kernel;

//chargement du fichier de configuration
require_once 'src/config/config.php';

//chargement automatique des classes du dossier classes
require_once 'src/classes/Autoload.php';
Autoloader::register();
// $autoloader->register();

//instanciation du kernel (lance l'application)
$kernel = new Kernel();
$kernel->handle();
