<?php
namespace App\Controllers;

use App\Models\Issue;
use Symfony\Component\Routing\RouteCollection;

class SetupController
{
    // Show issue given the id
    public function showAction(RouteCollection $routes)
    {
        $setup = new setup();
//        $issue->read($id);

        require_once APP_ROOT .  '/views/setup.php';
    }
}