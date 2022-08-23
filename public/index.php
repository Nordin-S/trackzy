<?php


use app\controllers\AuthController;
use app\controllers\SiteController;
use app\core\Application;
use app\models\User;

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'domain' => 'nordin.azurewebsites.net',
    'db' => [
        'host' => $_ENV['DB_HOST'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ],
    'mail' => [
        'email' => $_ENV['MAIL_EMAIL'],
        'password' => $_ENV['MAIL_PASSWORD'],
    ],
    'userClass' => User::class,
];

// if database throws an error for admin to edit env file with db credentials
try {
    $app = new Application(dirname(__DIR__), $config);
    if ($app->db->getAppliedMigrations() == null) {
        $app->db->applyMigrations();
    }
} catch (PDOException $e) {
    $title = 'Database setup';
    ob_start();
    include_once('../views/layouts/setup-layout.php');
    $layoutContent = ob_get_clean();

    ob_start();
    include_once('../views/setup-db.php');
    $viewContent = ob_get_clean();

    echo str_replace('{{content}}', $viewContent, $layoutContent);

    exit;
}
$requestPath = Application::$app->request->getPath();
if ($requestPath !== '/setup' && !Application::$app->db->getAllUsersEmail()) {
    header("Location: /setup");
    exit;
}

if ($requestPath !== '/login' && $requestPath !== '/setup' && $requestPath !== '/recover-password' && $requestPath !== '/reset-password' && Application::isGuest()) {
    header("Location: /login");
    exit;
}

$app->router->get('/setup', [SiteController::class, 'siteSetup']);
$app->router->get('/login', [SiteController::class, 'login']);
$app->router->get('/recover-password', [SiteController::class, 'recoverPassword']);
$app->router->get('/reset-password', [SiteController::class, 'resetPassword']);


$app->router->get('/', [AuthController::class, 'issues']);
$app->router->get('/new-issue', [AuthController::class, 'newIssue']);
$app->router->get('/view-issue', [AuthController::class, 'viewIssue']);
$app->router->get('/profile', [AuthController::class, 'profile']);
$app->router->get('/users-list', [authController::class, 'usersList']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->get('/logout', [AuthController::class, 'logout']);

$app->router->post('/setup', [SiteController::class, 'siteSetup']);
$app->router->post('/reset-password', [SiteController::class, 'resetPassword']);

$app->router->post('/login', [AuthController::class, 'login']);
$app->router->post('/recover-password', [AuthController::class, 'recoverPassword']);
$app->router->post('/profile', [AuthController::class, 'profile']);
$app->router->post('/users-list', [authController::class, 'usersList']);
$app->router->post('/register', [AuthController::class, 'register']);
$app->router->post('/invite', [AuthController::class, 'invite']);

$app->run();
