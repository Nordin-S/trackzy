<?php

namespace app\core;

use app\models\User;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

date_default_timezone_set('Etc/UTC');

/**
 * Class Application
 *
 * @package app\core
 * @author Nordin Suleimani <nordin.suleimani@email.com>
 */
class Application
{
    public static string $ROOT_DIR;
    public static Application $app;
    public array $config = [];
    public ?string $userClass;
    public string $layout = 'main';
    public Database $db;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public ?Controller $controller = null;
    public ?userModel $user;
    public View $view;

    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        $this->config = $config;
        $this->userClass = $config['userClass'] ?? null;
        self::$app = $this;
        $this->db = new Database($config['db']);
        $this->session = new Session();
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->view = new View();
        $this->user = null;

        $primaryValue = Application::$app->session->get('user');
        $hasAppliedMigrations = $this->db->getAppliedMigrations() != null;
        if ($primaryValue && $this->userClass != null && $hasAppliedMigrations && $this->userClass::findUser([$this->userClass::primaryKey() => $primaryValue]) != null) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findUser([$primaryKey => $primaryValue]);
        }
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('response-error', [
                'exception' => $e
            ]);
        }
    }

    /**
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    public function login(UserModel $user)
    {
        $this->user = $user;
        $className = get_class($user);
        $primaryKey = $className::primaryKey();
        $primaryValue = $user->{$primaryKey};
        Application::$app->session->set('user', $primaryValue);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->unsetSessionKey('user');
    }

    public function resetPassword(DbModel $resetPassword)
    {
        $this->user = $resetPassword;
        $className = get_class($resetPassword);
        $primaryKey = $className::primaryKey();
        $primaryValue = $resetPassword->{$primaryKey};
        Application::$app->session->set('user', $primaryValue);
        return true;
    }
}
