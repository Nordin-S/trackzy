<?php

namespace app\models;

use app\core\UserModel;

class User extends UserModel
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;
    const ROLE_ADMIN = 0;
    const ROLE_MODERATOR = 1;
    const ROLE_AUTHOR = 2;
    const ROLE_GUEST = 3;


    public int $status = self::STATUS_INACTIVE;
    public int $role = self::ROLE_GUEST;
    public string $passwordConfirmation = '';

    public function insertNew(): bool
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::insertNew();
    }

    public function rules(): array
    {
        return [
            'username' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                self::RULE_UNIQUE, 'class' => self::class
            ]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
            'passwordConfirmation' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];
    }

    public function attributes(): array
    {
//        return ['email', 'username', 'password', 'role', 'avatar', 'status', 'verified'];
        return ['email', 'username', 'password', 'status', 'role'];
    }

    public function labels(): array
    {
        return [
            'username' => 'Username',
            'email' => 'Email',
            'passwordConfirmation' => 'Confirm Password',
            'password' => 'Password',
        ];
    }


}