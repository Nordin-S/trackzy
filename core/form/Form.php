<?php
/**
 * BY: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/15/2022
 * TIME: 11:20 PM
 * COURSE: Webbprogrammering DT058G
 * SUPERVISOR: Mikael Hasselmalm
 */

namespace app\core\form;

use app\core\Model;

class Form
{
    public static function begin(string $action, string $method)
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();
    }
    public static function end()
    {
        echo '</form>';
    }

    public function field(Model $model, $attr)
    {
       return new Field($model, $attr);
    }
}