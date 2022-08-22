<?php

namespace app\models;

use app\core\UserModel;

class GetUsers extends UserModel
{
    public function execute()
    {
        return parent::getAllUsers();
    }

    public function attributes(): array
    {
        return [];
    }

    public function rules(): array
    {
        return [];
    }
}