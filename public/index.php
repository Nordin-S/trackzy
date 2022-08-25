<?php

use app\controllers\AuthController;
use app\controllers\SiteController;
use app\core\Application;
use app\models\User;

// set project root path
$_ENV['ROOT_DIR'] = dirname(__DIR__) . '/';

// Start autoloading package
require_once $_ENV['ROOT_DIR'] . 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

//additional env variables that needs to be set from here
$_ENV['userClass'] = User::class;

// if database throws an error for admin to edit env file with db credentials
try {
    $app = new Application();
    if ($app->db->getAppliedMigrations() == null) {
        $app->db->applyMigrations();
    }
} catch (PDOException $e) {
    //could not connect to db, edit .env file
    $title = 'Database setup';
    include_once($_ENV['ROOT_DIR'] . 'views/layouts/baseHeader.php');
    include_once($_ENV['ROOT_DIR'] . 'views/setup-db.php');
    include_once($_ENV['ROOT_DIR'] . 'views/layouts/footerBase.php');

    exit;
}
// if there are no users in database, lets create admin
$requestPath = Application::$app->request->getPath();
if ($requestPath !== '/setup-admin' && !Application::$app->db->getAllUsersEmail()) {
    header("Location: /setup-admin");
    exit;
}

// login page
//if ($requestPath !== '/login'
//    && $requestPath !== '/setup-admin'
//    && $requestPath !== '/recover-password'
//    && $requestPath !== '/reset-password'
//    && Application::isGuest()) {
//    header("Location: /login");
//    exit;
//}

// route to controllers
$app->router->get('/', [SiteController::class, 'welcome']);
$app->router->get('/setup-admin', [SiteController::class, 'setupAdmin']);
$app->router->get('/login', [SiteController::class, 'login']);
$app->router->get('/recover-password', [SiteController::class, 'recoverPassword']);
$app->router->get('/reset-password', [SiteController::class, 'resetPassword']);

$app->router->get('/issues', [AuthController::class, 'issues']);
$app->router->get('/new-issue', [AuthController::class, 'newIssue']);
$app->router->get('/view-issue', [AuthController::class, 'viewIssue']);
$app->router->get('/profile', [AuthController::class, 'profile']);
$app->router->get('/users-list', [authController::class, 'usersList']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->get('/logout', [AuthController::class, 'logout']);

$app->router->post('/setup-admin', [SiteController::class, 'setupAdmin']);
$app->router->post('/reset-password', [SiteController::class, 'resetPassword']);

$app->router->post('/login', [AuthController::class, 'login']);
$app->router->post('/recover-password', [AuthController::class, 'recoverPassword']);
$app->router->post('/profile', [AuthController::class, 'profile']);
$app->router->post('/users-list', [authController::class, 'usersList']);
$app->router->post('/register', [AuthController::class, 'register']);
$app->router->post('/invite', [AuthController::class, 'invite']);

$app->run();
