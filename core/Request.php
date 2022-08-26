<?php
/**
 * BY: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/15/2022
 * TIME: 11:20 PM
 * COURSE: Webbprogrammering DT058G
 * SUPERVISOR: Mikael Hasselmalm
 */

namespace app\core;

class Request
{
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if ($position === false) {
            return $path;
        }
        return substr($path, 0, $position);
    }

    public function method(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isGet(): bool
    {
        return $this->method() === 'get';
    }

    public function isPost(): bool
    {
        return $this->method() === 'post';
    }

    public function getBody()
    {
        $body = [];
        if ($this->method() === 'get' || $this->method() === 'post') {
            foreach ($_GET as $key => $value) {
                try {
                    $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                } catch (\InvalidArgumentException $e) {
                    echo $e->getMessage();
                }
            }
            foreach ($_POST as $key => $value) {
                try {
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                } catch (\InvalidArgumentException $e) {
                    echo $e->getMessage();
                }
            }
        }
        return $body;
    }
}