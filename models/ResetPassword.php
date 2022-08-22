<?php
/**
 * Created by PhpStorm
 * USER: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/16/2022
 * TIME: 10:19 PM
 */

namespace app\models;

use app\core\Application;
use app\core\UserModel;

class ResetPassword extends UserModel
{
//    public string $email = '';
//    public string $recovery_token = '';
//    public string $token_expiration = '';
//    public string $password = '';
    public string $passwordConfirmation = '';

    public function updateAttributesWhere($where): bool
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $this->recovery_token = '';
        $this->token_expiration = date('Y-m-d H:i:s');
        return parent::updateAttributesWhere($where);
    }

    public function verifyResetLink(): bool
    {
        $resetPassword = (new ResetPassword)->findUser(['email' => $this->email]);
        $isTrue = true;
        if (!$resetPassword) {
            $this->addError('recovery_token', 'User with given email does not exist');
            $isTrue = false;
        } else {
            if (date('Y-m-d H:i:s', strtotime($resetPassword->token_expiration)) < date('Y-m-d H:i:s')) {
                $this->addError('recovery_token', 'Reset link has expired');
                $isTrue = false;
            }
            if ($resetPassword->recovery_token !== $this->recovery_token) {
                $this->addError('recovery_token', 'Incorrect recovery token');
                $isTrue = false;
            }
        }
        return $isTrue ? Application::$app->resetPassword($resetPassword) : $isTrue;
    }

    public function attributes(): array
    {
        return ['password', 'recovery_token', 'token_expiration'];
    }

    public function rules(): array
    {
        return [
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
            'passwordConfirmation' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
            'email' => [],
            'recovery_token' => [],
        ];
    }

    public function labels(): array
    {
        return [
            'passwordConfirmation' => 'Confirm Password',
            'password' => 'Password',
        ];
    }
}