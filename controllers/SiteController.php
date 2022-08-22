<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\RecoverPassword;
use app\models\ResetPassword;
use app\models\User;

/**
 * Class SiteController
 *
 * @package app\controllers
 * @author Nordin Suleimani <nordin.suleimani@email.com>
 */
class SiteController extends Controller
{
    public function siteSetup(Request $request)
    {
        // if a user already exists block visit to this page
        if (Application::$app->db->getAllUsersEmail()) {
            header("Location: /");
        }
        $user = new User();
        $user->setRole(0);
        if ($request->isPost()) {
            $user->loadData($request->getBody());

            if ($user->validate() && $user->newUser()) {
                Application::$app->session->setFlash('success', 'Thanks for registering');
                Application::$app->response->redirect('/');
                exit;
            }
        }
        $this->setLayout('auth');
        return $this->render('setup', [
            'model' => $user,
            'title' => 'Site Setup'
        ]);
    }

    public function login()
    {
        $loginForm = new User();
        $this->setLayout('auth');
        return $this->render('login', [
            'model' => $loginForm,
            'title' => 'Sign In'
        ]);
    }

    public function recoverPassword()
    {
        $recoverPassword = new RecoverPassword();
        $this->setLayout('auth');
        return $this->render('recover-password', [
            'model' => $recoverPassword,
            'title' => 'Password recovery'
        ]);
    }

    public function resetPassword(Request $request, Response $response)
    {
        $resetPassword = new ResetPassword();
        $resetPassword->loadData($request->getBody());
        $_POST['email'] = $_GET['email'];
        $_POST['recovery_token'] = $_GET['recovery_token'];
        if ($request->isPost() &&
            $resetPassword->validate() &&
            $resetPassword->verifyResetLink() &&
            $resetPassword->updateAttributesWhere('email')) {

            Application::$app->session->setFlash('success', 'Your password was reset successfully.');
            Application::$app->response->redirect('/');
            exit;
        }
        $this->setLayout('auth');
        return $this->render('reset-password', [
            'model' => $resetPassword,
            'title' => 'Reset Password',
        ]);
    }
}