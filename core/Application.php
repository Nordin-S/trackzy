<?php

namespace app\core;

use app\models\User;
use PHPMailer\PHPMailer\PHPMailer;

date_default_timezone_set('Etc/UTC');

/**
 * Class Application
 *
 * @package app\core
 * @author Nordin Suleimani <nordin.suleimani@email.com>
 */
class Application
{
    public static Application $app;
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
    public PHPMailer $mail;

    public function __construct()
    {
        $this->userClass = $_ENV['userClass'] ?? null;
        $this->db = new Database();
        $this->session = new Session();
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->view = new View();
        $this->user = null;
        self::$app = $this;


        $this->mail = new PHPMailer();
//        $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $this->mail->SMTPDebug = 0;
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->SMTPSecure = 'tls';
        $this->mail->Port = 587;
        $this->mail->Username = $_ENV['MAIL_EMAIL'];
        $this->mail->Password = $_ENV['MAIL_PASSWORD'];
        $this->mail->setFrom($_ENV['MAIL_EMAIL'], $_ENV['MAIL_SENDER']);
        $this->mail->isHtml();

        $primaryValue = Application::$app->session->get('user');
        $hasAppliedMigrations = $this->db->getAppliedMigrations() != null;
        if ($primaryValue && $this->userClass != null && $hasAppliedMigrations && $this->userClass::findUser([$this->userClass::primaryKey() => $primaryValue], new User) != null) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findUser([$primaryKey => $primaryValue], new User);
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
                'exception' => $e,
                'title' => 'Error: ' . $e->getMessage()
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
