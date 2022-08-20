<?php
/**
 * Created by PhpStorm
 * USER: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/17/2022
 * TIME: 2:49 AM
 */

namespace app\core;

abstract class UserModel extends DbModel
{
    abstract public function getId(): int;
    abstract public function getUsername(): string;
    abstract public function getEmail(): string;
    abstract public function getPassword(): string;
    abstract public function getAvatar(): string;
    abstract public function getBio(): string;
    abstract public function getRole(): int;
    abstract public function getStatus(): int;
    abstract public function getVerified(): int;
    abstract public function getRecoveryToken(): string;
    abstract public function getTokenExpiration(): string;
    abstract public function getCreatedDate(): string;
}