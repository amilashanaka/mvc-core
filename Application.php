<?php

namespace etronic\phpmvc;

use etronic\phpmvc\Controller;
use etronic\phpmvc\db\Database;

class Application
{

    public static string $ROOT_DIR;

    public string $layout = 'main';

    public Router $router;

    public Request $request;

    public Response $response;

    public Session $session;

    public static Application $app;

    public ?Controller $controller = null;

    public Database $db;

    public ?UserModel $user;

    public View $view;

    public string $userClass;

    public function __construct($rootPath, array $config)
    {

        self::$ROOT_DIR = $rootPath;

        self::$app = $this;

        $this->request = new Request();

        $this->response = new Response();

        $this->session = new Session();

        $this->router = new Router($this->request, $this->response);

        $this->db = new Database($config['db']);

        $this->userClass = $config['user_class'];

        $this->view = new View();

        $primeryValue = $this->session->get('user');

        if ($primeryValue) {
            $primeryKey = $this->userClass::primeryKey();

            $this->user = $this->userClass::findOne([$primeryKey => $primeryValue]);

        } else {
            $this->user = null;
        }

    }

    public function run()
    {

      try
      {
        echo $this->router->resolve();

      }catch (\Exception $e)
      {
        $this->response->setStatusCode($e->getCode());
        echo $this->router->renderView('error',['exception' => $e]);

      }

       
    }

    public function getController()
    {

        return $this->controller;
    }

    public function setController(Controller $controller)
    {

        $this->controller = $controller;

    }

    public function login(UserModel $user)
    {
        $this->user = $user;
        $primeryKey = $user->primeryKey();
        $primeryValue = $user->{$primeryKey};
        $this->session->set('user', $primeryValue);
        return true;

    }

    public function logout()
    {

        $this->user = null;
        $this->session->remove('user');

    }

    public static function isGuest()
    {
        return !self::$app->user;
    }

}
