<?php
/**
 * Created by PhpStorm
 * USER: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/17/2022
 * TIME: 1:10 PM
 */

namespace app\core\middlewares;

abstract class BaseMiddleware
{
    abstract public function execute();
}