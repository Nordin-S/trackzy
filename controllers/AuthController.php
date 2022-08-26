<?php
/**
 * BY: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/15/2022
 * TIME: 11:20 PM
 * COURSE: Webbprogrammering DT058G
 * SUPERVISOR: Mikael Hasselmalm
 */

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\form\emails\InviteMsg;
use app\core\form\emails\InviteRevokeMsg;
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


    public function register(Request $request)
    {
        $user = new Login();
        $user->loadData($request->getBody());
        $invitation = new GetInvitations;
        //set role and email from invitation link
        if (isset($user->invitecode) && $invitation = $invitation->findUser(['invitecode' => $user->invitecode], new GetInvitations())) {
            $user->setRole($invitation->getRole());
            $user->setEmail($invitation->getEmail());
            if ($request->isPost()) {
                if ($user->validate() && $user->insertNew()) {
                    // delete invitation from db
                    $invitation->delete(['invitecode' => $invitation->invitecode], new GetInvitations());

                    // login newly created member and redirect to home
                    $user = $user->findUser(['email' => $user->email], new User());
                    Application::$app->login($user);
                    Application::$app->session->setFlash('success', 'Thanks for registering ' . $user->getUserName());
                    Application::$app->response->redirect('/');
                    exit;
                }
                // not validated... try again
                $this->setLayout('auth');
                return $this->render('register', [
                    'model' => $user,
                    'title' => 'Invitation Sign up',
                ]);
            }
            // get, invite token verified
            $this->setLayout('auth');
            return $this->render('register', [
                'model' => $user,
                'title' => 'Sign up for ' . $user->email
            ]);
        }
        // get, no invite token
        $this->setLayout('auth');
        return $this->render('register', [
            'title' => 'Invitation Sign up'
        ]);
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

    public function logout(request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
        exit;
    }

    public function usersList()
    {
        // get all members and invitations and send to view
        $members = (new GetUsers)->execute(new GetUsers);
        $invitations = (new GetInvitations)->execute(new GetInvitations);
        $participants = [
            'members' => $members,
            'invitations' => $invitations
        ];

        return $this->render('users-list',
            ['model' => $participants, 'title' => 'Manage users list',]);
        exit;
    }

    public function deleteUser(Request $request)
    {
        $user = new User();
        $user->loadData($request->getBody());
        if ($user->getId() != Application::$app->user->getId()) {
            if ($user->delete(['id' => $user->id], new User())) {
                Application::$app->session->setFlash('success', 'User was deleted successfully');
            } else {
                Application::$app->session->setFlash('warning', 'Could not delete user');
            }
        } else {
            Application::$app->session->setFlash('danger', 'You are not allowed to delete yourself');
        }
        Application::$app->response->redirect('/users-list');
        exit;
    }

    public function revokeInvitation(Request $request)
    {
        $invitation = new GetInvitations();
        $invitation->loadData($request->getBody());
        $isInvited = (new GetInvitations)->findUser(['id' => $invitation->id], new GetInvitations());
        if ($isInvited && $invitation->delete(['id' => $invitation->id], new GetInvitations())) {
            Application::$app->session->setFlash('success', 'Invitation was revoked successfully');

            // send revoked email
            $domainHref = $_ENV['DOMAIN_ADDRESS'];
            $inviteRevokeMsg = new InviteRevokeMsg($domainHref, $isInvited->email);
            try {
                Application::$app->mail->addAddress($isInvited->email);
                Application::$app->mail->Subject = $inviteRevokeMsg->getSubject();
                Application::$app->mail->MsgHTML($inviteRevokeMsg->getMessage());
                Application::$app->mail->AltBody = $inviteRevokeMsg->getAltBody();
                Application::$app->mail->send();
                Application::$app->session->setFlash('success', "Successfully revoked invitation for $isInvited->email");
            } catch (Exception $e) {
                Application::$app->session->setFlash('email', 'Could not send invitation revoke email.');
            }
        } else {
            Application::$app->session->setFlash('warning', 'Could not revoke invitation');
        }
        Application::$app->response->redirect('/users-list');
        exit;
    }


    public function invite(Request $request)
    {
        $invite = new Invite();
        $invite->loadData($request->getBody());

        $isMember = (new User)->findUser(['email' => $invite->email], new User());
        if ($isMember) {
            Application::$app->session->setFlash('warning', "EMAIL: Entry with this email already a member");
        }
        if ($invite->validate() && !$isMember && $invite->execute()) {
            $registerHref = $_ENV['DOMAIN_ADDRESS'] . "/register?invitecode=" . $invite->invitecode;
            $domainHref = $_ENV['DOMAIN_ADDRESS'];
            $inviteMsg = new InviteMsg($registerHref, $domainHref, $invite->email);
            try {
                Application::$app->mail->addAddress($invite->email);
                Application::$app->mail->Subject = $inviteMsg->getSubject();
                Application::$app->mail->MsgHTML($inviteMsg->getMessage());
                Application::$app->mail->AltBody = $inviteMsg->getAltBody();
                Application::$app->mail->send();
                Application::$app->session->setFlash('success', "successfully invited $invite->email");
            } catch (Exception $e) {
                Application::$app->session->setFlash('email', 'Could not send invitation email. Delete invited user and try again');
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
                $resetHref = $_ENV['DOMAIN_ADDRESS'] . "/reset-password?email=" . $recoverPassword->email . "&recovery_token=" . $recoverPassword->recovery_token;
                $domainHref = $_ENV['DOMAIN_ADDRESS'];
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
                    Application::$app->session->setFlash('email', 'Could not send the password recovery email');
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


    public function profile(Request $request)
    {
        $user = new User();
        $user->loadData($request->getBody());
        $user = $user->findUser(['id' => $user->id], new User());
        if (!$user) {
            Application::$app->session->setFlash('user', 'Could not find specified user');
            Application::$app->response->redirect('/');
            exit;
        }
//        $this->setLayout('auth');
        return $this->render('profile', [
            'model' => $user,
            'title' => 'Profile for ' . $user->username
        ]);


        return $this->render('profile', ['model' => $user, 'title' => 'Profile']);
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
}