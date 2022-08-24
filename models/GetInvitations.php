<?php

namespace app\models;

use app\core\DbModel;

class GetInvitations extends DbModel
{
    public function execute($classType)
    {
        return parent::getAllRows($classType);
    }

    public function attributes(): array
    {
        return [];
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
}