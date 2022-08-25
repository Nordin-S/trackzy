<?php

namespace app\models;

use app\core\DbModel;

class GetInvitations extends DbModel
{
    public int $id;
    public string $email;
    public string $role;
    public function execute($classType)
    {
        return parent::getAllRows($classType);
    }

    public function attributes(): array
    {
        return ['id', 'email', 'role'];
    }

    public function rules(): array
    {
        return [];
    }

    public function tableName(): string
    {
        return 'invitations';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function getId()
    {
        return $this->id;
    }
    public function getRole()
    {
        return $this->role;
    }
    public function getEmail()
    {
        return $this->email;
    }
}