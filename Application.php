<?php

declare(strict_types=1);

namespace natoxCore;

use natoxCore\db\Database;
use natoxCore\routes\Router;

class Application
{
    public static string $ROOT_DIR;

    public string $layout = 'main';
    public string $userClass;
    public Session $session;
    public Router $router;
    public View $view;
    public Database $db;

    public static Application $app;
    public ?Controller $controller = null;

    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;

        $this->session = new Session();
        $this->router = new Router($_GET['url']);
        $this->view = new View();

        $this->db = new Database($config['db']);
    }

    /**
     * Get the value of controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * Set the value of controller
     *
     * @return  self
     */
    public function setController($controller)
    {
        $this->controller = $controller;

        return $this;
    }

    public function run()
    {
        try {
            $this->router->resolve();
        }catch(\Exception $e) {
            $this->router->setStatusCode($e->getCode());
            $this->layout = 'error';
            echo $this->view->renderView('_error', [
                'exception' => $e
            ]);
        }
    }

}