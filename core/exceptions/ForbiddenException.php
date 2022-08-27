<?php
/**
 * BY: Nordin Suleimani <nordin.suleimani@gmail.com>
 * DATE: 8/15/2022
 * TIME: 11:20 PM
 * COURSE: Webbprogrammering DT058G
 * SUPERVISOR: Mikael Hasselmalm
 * DESCRIPTION: Extending exception class to create custom 403 page
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