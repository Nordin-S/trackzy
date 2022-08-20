<?php

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