<?php
/**
 * BY: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/15/2022
 * TIME: 11:20 PM
 * COURSE: Webbprogrammering DT058G
 * SUPERVISOR: Mikael Hasselmalm
 */

namespace app\core;

class Response
{

    public function setStatusCode(int $statusCode): void
    {
       http_response_code($statusCode);
    }

    public function redirect(string $location): void
    {
        header('Location: ' . $location);
    }
}