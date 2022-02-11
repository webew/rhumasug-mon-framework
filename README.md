# RhumaSug avec PHP Framework

## Créer une nouvelle page

1. Créer la route dans config/routes.php

```php
// src/config/routes.php

<?php

return array(
    "/" => "accueil",
    "/accueil" => "accueil",
    "/about" => "about"
);
```

2. Créer la méthode de controller dans src/controller/AppController.php

```php
// src/controller/AppController.php

public function about()
{
    $this->render('about.php');
}

```

3. Créer le template dans template/pages

## Configuration de la base de données

```php
// src/config/congBdd.php

define('BDD_HOST', 'localhost');

define('BDD_NAME', 'test');

define('BDD_PORT', 3306);

define('BDD_USER', 'root');

define('BDD_PASSWORD', '');
```

## Structure du controller

```php
// src/controller/AppController.php

<?php

namespace App\controller;

use App\classes\AbstractController;
use App\classes\Bdd;

class AppController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function accueil()
    {
        $conn = Bdd::getInstance();
        $stmt = $conn->prepare("SELECT * FROM user");
        $stmt->execute();
        $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $this->render('accueil.php', ["users" => $users]);
    }

    public function about()
    {
        $this->render('about.php');
    }

    public function page404()
    {
        $this->render('404.php');
    }

    public function jsonToto()
    {
        echo json_encode(['toto' => 'toto']);
    }
}
```

## Requête sur la base de données

```php
// src/controller/AppController.php

public function accueil()
{
    $conn = Bdd::getInstance();
    $stmt = $conn->prepare("SELECT * FROM user");
    $stmt->execute();
    $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    $this->render('accueil.php', ["users" => $users]);
}
```

## Front controller : index.php

```php
// index.php

<?php

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
```
