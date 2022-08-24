<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\form\emails\InviteMsg;
use app\core\form\emails\PasswordResetMsg;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\GetInvitations;
use app\models\GetUsers;
use app\models\Invite;
use app\models\Login;
use app\models\RecoverPassword;
use app\models\User;
use PHPMailer\PHPMailer\Exception;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(
            ['profile', 'usersList', 'issues', 'newIssue', 'viewIssue', 'delete-user', 'delete-post', 'invite', 'revoke-invitation'],
            ['usersList', 'delete-user', 'delete-post', 'invite', 'revoke-invitation'],
            ['usersList', 'delete-user', 'invite', 'revoke-invitation']
        ));
    }

    public function login(Request $request, Response $response)
    {
        $loginForm = new Login();
        if ($request->isPost()) {
            $loginForm->loadData($request->getBody());
            if ($loginForm->validate() && $loginForm->login()) {
                Application::$app->response->redirect('/');
                exit;
            }
        }
        $this->setLayout('auth');
        return $this->render('login', [
            'model' => $loginForm,
            'title' => 'Sign in'
        ]);
    }

    public function register(Request $request)
    {
        $user = new User();
        if ($request->isPost()) {
            $user->loadData($request->getBody());

            if ($user->validate() && $user->insertNew()) {
                Application::$app->session->setFlash('success', 'Thanks for registering');
                Application::$app->response->redirect('/');
                exit;
            }
            $this->setLayout('auth');
            return $this->render('register', [
                'model' => $user,
                'title' => 'Invitation Signup',
            ]);
        }
        $this->setLayout('auth');
        return $this->render('register', [
            'model' => $user,
            'title' => 'Invitation Signup'
        ]);
    }

    public function logout(request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
        exit;
    }

    public function usersList()
    {
        $members = (new GetUsers)->execute(new GetUsers);
        $invitatioons = (new GetInvitations)->execute(new GetInvitations);
        $partisipants = [
            'members' => $members,
            'invitations' => $invitatioons
        ];

        return $this->render('users-list',
            ['model' => $partisipants, 'title' => 'Manage users list',]);
        exit;
    }

    public function profile()
    {
        return $this->render('profile', ['title' => 'Profile']);
    }

    public function viewIssue()
    {
        return $this->render('view-issue', ['title' => 'View Issue']);
    }

    public function newIssue()
    {
        return $this->render('new-issue', ['title' => 'Create Issue']);
    }

    public function issues()
    {
        return $this->render('issues', ['title' => 'View Issues']);
    }

    public function invite(Request $request)
    {
        $invite = new Invite();
        $invite->loadData($request->getBody());

        $isMember = (new User)->findUser(['email' => $invite->email], new User());
        if ($isMember) {
            Application::$app->session->setFlash('danger', "EMAIL: Entry with this email already a member");
        }
        if ($invite->validate() && !$isMember && $invite->execute()) {
            $registerHref = Application::$app->config['domain'] . "/register?email=" . $invite->email . "&invite_token=" . $invite->invitecode;
            $domainHref = "https://" . Application::$app->config['domain'];
            $inviteMsg = new InviteMsg($registerHref, $domainHref, $invite->email);
            try {
                Application::$app->mail->addAddress($invite->email);
                Application::$app->mail->Subject = $inviteMsg->getSubject();
                Application::$app->mail->MsgHTML($inviteMsg->getMessage());
                Application::$app->mail->AltBody = $inviteMsg->getAltBody();
                Application::$app->mail->send();
                Application::$app->session->setFlash('success', "successfully invited $invite->email");
            } catch (Exception $e) {
                $invite->addError('email', 'Could not send invitation mail email. Delete invited user and try again');
            }
        }
        foreach ($invite->errors as $errorTag => $error) {
            foreach ($error as $errorMsg) {
                Application::$app->session->setFlash('danger', strtoupper($errorTag) . ': ' . $errorMsg);
            }
        }
        Application::$app->response->redirect('/users-list');
        exit;
    }

    public function recoverPassword(Request $request, Response $response)
    {
        $recoverPassword = new RecoverPassword();
        if ($request->isPost()) {
            $recoverPassword->loadData($request->getBody());
            $foundUser = $recoverPassword->findUser(['email' => $recoverPassword->email], new RecoverPassword);

            if (!$foundUser) {
                $recoverPassword->addError('email', 'User with given email does not exist');
            }

            if ($recoverPassword->validate() && $foundUser && $recoverPassword->updateAttributesWhere('email')) {
                    $recoverPassword->setUsername($foundUser->username) ?? '';
                $resetHref = Application::$app->config['domain'] . "/reset-password?email=" . $recoverPassword->email . "&recovery_token=" . $recoverPassword->recovery_token;
                $domainHref = "https://" . Application::$app->config['domain'];
                $passwordResetMsg = new PasswordResetMsg($resetHref, $domainHref, $recoverPassword->username);
                try {
                    Application::$app->mail->addAddress($recoverPassword->email);
                    Application::$app->mail->Subject = $passwordResetMsg->getSubject();
                    Application::$app->mail->MsgHTML($passwordResetMsg->getMessage());
                    Application::$app->mail->AltBody = $passwordResetMsg->getAltBody();
                    Application::$app->mail->send();
                    Application::$app->session->setFlash('success', 'Password recovery mail was sent successfully.');
                    Application::$app->response->redirect('/login');
                } catch (Exception $e) {
                    $recoverPassword->addError('email', 'Could not send the password recovery email');
                    Application::$app->response->redirect('/recover-password');
                }
                exit;
            }
        }
        $this->setLayout('auth');
        return $this->render('recover-password', ['model' => $recoverPassword,
            'title' => 'Password recovery',]);
        exit;
    }

}