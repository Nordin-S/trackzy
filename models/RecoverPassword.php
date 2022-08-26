<?php
/**
 * Created by PhpStorm
 * USER: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/16/2022
 * TIME: 10:19 PM
 */

namespace app\models;

use app\core\DbModel;
use DateTime;

class RecoverPassword extends DbModel
{
    public string $email = '';
    public string $recovery_token = '';
    public string $token_expiration = '';
    public string $username = '';

    public function updateAttributesWhere($where): bool
    {
        $this->recovery_token = md5($this->email) . rand(10, 9999);
        $this->token_expiration = date("Y-m-d H:i:s", strtotime("+3 hours"));
        return parent::updateAttributesWhere($where);
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function tableName(): string
    {
        return 'users';
    }

    public function attributes(): array
    {
        return ['email', 'recovery_token', 'token_expiration', 'phrase'];
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'email' => [self::RULE_REQUIRED],
        ];
    }

    public function labels(): array
    {
        return [
            'email' => 'Your Email',
        ];
    }
}