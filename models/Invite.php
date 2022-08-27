<?php
/**
 * BY: Nordin Suleimani <nordin.suleimani@gmail.com>
 * DATE: 8/15/2022
 * TIME: 11:20 PM
 * COURSE: Webbprogrammering DT058G
 * SUPERVISOR: Mikael Hasselmalm
 */

namespace app\models;

use app\core\DbModel;

class Invite extends DbModel
{
    public string $email = '';
    public mixed $role = '';
    public string $invitecode = '';

    public function execute()
    {
        $this->role = match ($this->role) {
            'admin' => 0,
            'moderator' => 1,
            'author' => 2,
            default => null,
        };
        $this->invitecode = md5($this->email) . rand(10, 9999);
        return parent::insertNew();
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