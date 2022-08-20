<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

// Routes
$routes = new RouteCollection;

$routes->add('issue', new Route(constant('URL_SUBFOLDERS') . '/issue/{id}',
    array('controller' => 'IssueController', 'method' => 'showAction'),
    array('id' => '[0-9]+')
));
$routes->add('setup', new Route(constant('URL_SUBFOLDERS') . '/setup',
    array('controller' => 'setupController', 'method' => 'showAction')
));
