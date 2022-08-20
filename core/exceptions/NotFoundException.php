<?php
/**
 * Created by PhpStorm
 * USER: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/17/2022
 * TIME: 1:39 PM
 */

namespace app\core\exceptions;

class NotFoundException extends \Exception
{
    protected $code = 404;
    protected $message = 'Page not found';
    protected string $img = "/img/confused-monster.png";

    public function getImg(): string
    {
        return $this->img;
    }
}