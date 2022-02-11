<?php

namespace App\classes;

use App\controller\AppController;

class Kernel
{
    private Request $request;
    private Router $router;
    private AppController $controller;

    public function __construct()
    {
        $this->request = new Request();
        $this->controller = new AppController();
        $this->router = new Router($this->request);
    }

    public function handle()
    {
        $controllerMethod = $this->router->getControllerMethod(); //on récupère la méthode du controller à appeler
        if (method_exists($this->controller, $controllerMethod)) {
            $this->controller->$controllerMethod(); //appel de la méthode du controller
        }
    }
}
