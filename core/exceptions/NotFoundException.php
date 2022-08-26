<?php
/**
 * BY: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/15/2022
 * TIME: 11:20 PM
 * COURSE: Webbprogrammering DT058G
 * SUPERVISOR: Mikael Hasselmalm
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