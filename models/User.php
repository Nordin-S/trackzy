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


    public string $username = '';
    public string $email = '';
    public string $password = '';
    public int $status = self::STATUS_INACTIVE;
    public int $role = self::ROLE_GUEST;
    public string $passwordConfirmation;
    public int $id;
    public string $avatar;
    public string $bio;
    private int $verified;
    private string $recovery_token;
    private string $token_expiration;
    private string $created_at;

    public function tableName(): string
    {
        return 'users';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function newUser(): bool
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::newUser();
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


    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }

    public function getBio(): string
    {
        return $this->bio;
    }

    public function getRole(): int
    {
        return $this->role;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getVerified(): int
    {
        return $this->verified;
    }

    public function getRecoveryToken(): string
    {
        return $this->recovery_token;
    }

    public function getTokenExpiration(): string
    {
        return $this->token_expiration;
    }

    public function getCreatedDate(): string
    {
        return $this->created_at;
    }
    public function setRole($value): void
    {
        $this->role = $value;
    }
}