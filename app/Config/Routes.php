<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'UtilisateursControlleur::index');
$routes->post('/login', 'UtilisateursControlleur::login');

$routes->group('admin', ['filter' => 'role:1'], function ($routes) {
    $routes->get('dashboard', 'AdminControlleur::dashboard');
    $routes->get('operations', 'AdminControlleur::operations');
    $routes->get('frais', 'AdminControlleur::frais');
    $routes->get('types-operations', 'AdminControlleur::typesOperations');

    $routes->get('prefixes', 'PrefixeControlleur::index');

    $routes->get('prefixes/create', 'PrefixeControlleur::create');
    $routes->post('prefixes/store', 'PrefixeControlleur::store');

    $routes->get('prefixes/edit/(:num)', 'PrefixeControlleur::edit/$1');
    $routes->post('prefixes/update/(:num)', 'PrefixeControlleur::update/$1');

    $routes->get('prefixes/delete/(:num)', 'PrefixeControlleur::delete/$1');

});
$routes->group('client', ['filter' => 'role:2'], function ($routes) {
    $routes->get('dashboard', 'ClientControlleur::dashboard');
    $routes->get('operations', 'ClientControlleur::operations');
});
