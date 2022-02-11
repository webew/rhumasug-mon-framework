<?php

define('INDEX_PATH', 'PUBLIC');

define('ROOT', "");

define('SRC', ROOT . "src");

define('PUB', "public");

define('ASSETS_PATH', PUB . "/assets");

define('STYLESHEET_DIR_PATH', ASSETS_PATH . "/css");

define('IMAGES_PATH', ASSETS_PATH . "/images");

define("SCRIPTS_PATH", ASSETS_PATH . "/js");

define('TITLE', 'Rhuma Sug');

define('TEMPLATE', SRC . "/template");

define('TEMPLATE_PARTS', TEMPLATE . '/template-parts');

define('PAGES', TEMPLATE . '/pages');

define('ROUTES', include SRC . '/config/routes.php');

define('DATAS_PATH', SRC . '/datas');

define('CLASSES', SRC . "/classes");

define('CONTROLLER', SRC . "/controller");

define('SERVICES', SRC . "/services");

define('SRC_NAMESPACE', 'App');
// les dossiers des fichiers à charger automatiquement avec autoload
define('AUTOLOAD_NAMESPACES', [SRC_NAMESPACE . "\classes" => CLASSES, SRC_NAMESPACE . "\controller" => CONTROLLER, SRC_NAMESPACE . "\services" => SERVICES]);

require_once 'configBdd.php';
require_once 'myConfig.php';
