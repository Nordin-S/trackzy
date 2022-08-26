<?php
/**
 * BY: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/15/2022
 * TIME: 11:20 PM
 * COURSE: Webbprogrammering DT058G
 * SUPERVISOR: Mikael Hasselmalm
 */

namespace app\models;

use app\core\UserModel;

class GetUsers extends UserModel
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
}