<?php
/**
 * Created by PhpStorm
 * USER: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/17/2022
 * TIME: 1:39 PM
 */

namespace app\core\exceptions;

class ForbiddenException extends \Exception
{
    protected $code = 403;
    protected $message = 'You are not authorized to access this page';
    protected string $img = "/img/angry-monster.png";

    public function getImg(): string
    {
        return $this->img;
    }
}