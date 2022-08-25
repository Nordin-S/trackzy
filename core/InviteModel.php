<?php
/**
 * Created by PhpStorm
 * USER: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/17/2022
 * TIME: 2:49 AM
 */

namespace app\core;

abstract class InviteModel extends DbModel
{
    public int $id = 1;
    public string $email = '';
    public string $invitecode = '';

    public function tableName(): string
    {
        return 'invitations';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
    public function getInvitecode(): string
    {
        return $this->invitecode;
    }
    public function getRole(): int
    {
        return $this->role;
    }
}