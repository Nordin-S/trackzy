<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\Login;
use app\models\RecoverPassword;
use app\models\User;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class AuthController extends Controller
{
    public PHPMailer $mail;
    public string $email = 'trackzy.tracks@gmail.com';

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(
            ['profile', 'usersList', 'issues', 'newIssue', 'viewIssue'],
            ['usersList'],
            ['usersList']
        ));
    }

    public function login(Request $request, Response $response)
    {
        $loginForm = new Login();
        if($request->isPost()){
            $loginForm->loadData($request->getBody());
            if($loginForm->validate() && $loginForm->login()){
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

            if ($user->validate() && $user->newUser()) {
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
        return $this->render('users-list', ['title' => 'Registered users list']);
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


    public function recoverPassword(Request $request, Response $response)
    {
        $recoverPassword = new RecoverPassword();
        if ($request->isPost()) {
            $recoverPassword->loadData($request->getBody());
            $foundUser = $recoverPassword->findUser(['email' => $recoverPassword->email]);
            if (!$foundUser) {
                $recoverPassword->addError('email', 'User with given email does not exist');
                Application::$app->response->redirect('/recover-password');
                exit;
            }
            if ($recoverPassword->validate() && $recoverPassword->createTokenInDb()) {
                $resetHref = Application::$app->config['domain'] . "/reset-password.php?key=" . $recoverPassword->email . "&token=" . $recoverPassword->recovery_token;
                $domainHref = "http://" . Application::$app->config['domain'];
                try {
                    $this->mail = new PHPMailer();
//        $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
                    $this->mail->SMTPDebug = 0;
                    $this->mail->isSMTP();
                    $this->mail->Host = 'smtp.gmail.com';
                    $this->mail->SMTPAuth = true;
//                    $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $this->mail->SMTPSecure = 'tls';
                    $this->mail->Port = 587;
                    $this->mail->Username = Application::$app->config['mail']['email'];
                    $this->mail->Password = Application::$app->config['mail']['password'];
                    $this->mail->setFrom(Application::$app->config['mail']['email'], 'Trackzy Tracks');
                    $this->mail->addAddress($recoverPassword->email);
                    $this->mail->isHtml(true);
                    $this->mail->Subject = 'Trackzy password reset';
//                    $this->mail->CharSet = PHPMailer::CHARSET_UTF8;
                    $this->mail->MsgHTML('
<!doctype html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title></title>
    <meta name="description" content="Reset Password Email Template.">
    <style type="text/css">
        a:hover {text-decoration: underline !important;}
    </style>
</head>

<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0; background-color: #f2f3f8;" leftmargin="0">
    <!--100% body table-->
    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"">
        <tr>
            <td>
                <table style="background-color: #f2f3f8; max-width:670px;  margin:0 auto;" width="100%" border="0"
                    align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">
                          <a href="http://' . $domainHref . '" title="logo" target="_blank">
                            <img width="60" src="http://' . $domainHref . '/img/trackzy-logo.png" title="logo" alt="logo">
                          </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                style="max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="padding:0 35px;">
                                        <h1 style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;">Trackzy password reset</h1>
                                        <span
                                            style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span>
                                    </td> 
                                </tr>
                                <tr>
                                    <td style="padding:0 35px; text-align:left;">
                                        <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">
                                            Hello ' . $recoverPassword->getUsername() . ', we heard that you lost password. sorry about that!
                                        </p>
                                        <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">
                                            You can use the follwing button to reset your password:
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:0 35px; text-align:center;">
                                        <a href="http://' . $resetHref . '"
                                            style="background:#007bff;text-decoration:none !important; font-weight:500; margin-top:35px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Reset
                                            Password</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:0 35px; text-align:left;">
                                        <p style="color:#455056; font-size:15px;line-height:24px; margin-top:20px;">
                                            If you don’t use this link within 3 hours, it will expire. To get a new password reset link, visit: ' . $domainHref . '/password_reset
                                        </p>
                                        <p style="color:#455056; font-size:15px;line-height:24px; margin-top:10px;">
                                            Thanks. <br>
                                            The Trackzy Team
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!--/100% body table-->
</body>
</html>');
                    $this->mail->AltBody = 'Hello ' . $recoverPassword->username . ', visit ' . $resetHref . ' to reset your password. Disregard this email if you did not request an password reset. The password reset link will expire soon. Thanks from The Trackzy Team';
                    $this->mail->send();
                    Application::$app->session->setFlash('success', 'Password recovery mail was sent successfully.');
                    Application::$app->response->redirect('/login');
                } catch (Exception $e) {
                    echo $e->getCode() . ' - ' . $e->getMessage();
                    echo "Message could not be sent. Mailer Error: {" . $this->mail->ErrorInfo . "}";
                    $recoverPassword->addError('email', 'Could not send the password recovery email');
                    Application::$app->response->redirect('/recover-password');
                }
                exit;
            }
        }
        Application::$app->response->redirect('/recover-password');
        exit;
    }

}