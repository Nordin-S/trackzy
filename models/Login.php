<?php
/**
 * BY: Nordin Suleimani <nordin.suleimani@gmail.com>
 * DATE: 8/15/2022
 * TIME: 11:20 PM
 * COURSE: Webbprogrammering DT058G
 * SUPERVISOR: Mikael Hasselmalm
 */

namespace app\models;

use app\core\Application;

class Login extends User
{
    public function login()
    {
        $user = (new User)->findUser(['email' => $this->email], new User);
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