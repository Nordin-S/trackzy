<?php
/**
 * BY: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/15/2022
 * TIME: 11:20 PM
 * COURSE: Webbprogrammering DT058G
 * SUPERVISOR: Mikael Hasselmalm
 */

namespace app\core;

abstract class UserModel extends DbModel
{
    public int $id = 1;
    public string $email = '';
    public string $password = '';
    public string $username = '';
    public int $status = 0;
    public int $role = 3;
    public string $avatar = '';
    public string $bio = '';
    public int $verified = 0;
    public string $recovery_token = '';
    public string $token_expiration = '';
    public string $created_at = '';
    public function tableName(): string
    {
        return 'users';
    }

    public static function primaryKey(): string
    {
        return 'id';
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
    public function setEmail($value): void
    {
        $this->email = $value;
    }
}