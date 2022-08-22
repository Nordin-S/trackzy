<?php
/**
 * Created by PhpStorm
 * USER: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/16/2022
 * TIME: 10:19 PM
 */

namespace app\models;

use app\core\Application;

class Login extends User
{
//    public string $email = '';
//    public string $password = '';

    public function login()
    {
        $user = (new User)->findUser(['email' => $this->email]);
        if (!$user) {
            $this->addError('email', 'User with given email does not exist');
            return false;
        }
        if (!password_verify($this->password, $user->password)) {
            $this->addError('password', 'Incorrect password');
            return false;
        }
        return Application::$app->login($user);
    }

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED]
        ];
    }

    public function labels(): array
    {
        return [
            'email' => 'Your Email',
            'password' => 'Password',
        ];
    }

}