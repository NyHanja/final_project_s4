<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->group('client', function ($routes) {
    $routes->get('solde', 'OperationController::VoirSolde');
});