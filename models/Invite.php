<?php

namespace app\models;

use app\core\DbModel;

class Invite extends DbModel
{
    public string $email = '';
    public int $role;
    public string $invitecode = '';

    public function execute()
    {
        return parent::invite();
    }

    public function attributes(): array
    {
        return ['email', 'role', 'invitecode'];
    }

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                self::RULE_UNIQUE, 'class' => self::class
            ]],
            'role' => [self::RULE_REQUIRED],
        ];
    }

    public function tableName(): string
    {
        return 'invitations';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }
}