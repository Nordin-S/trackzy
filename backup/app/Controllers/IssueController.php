<?php
namespace App\Controllers;

use App\Models\Issue;
use Symfony\Component\Routing\RouteCollection;

class IssueController
{
    // Show issue given the id
    public function showAction($id, RouteCollection $routes)
    {
        $issue = new Issue();
        $issue->read($id);

        require_once APP_ROOT .  '/views/issue.php';
    }
}