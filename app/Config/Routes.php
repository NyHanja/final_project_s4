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

     $routes->get('commissions', 'CommissionControlleur::index');

    $routes->get('commissions/create', 'CommissionControlleur::create');
    $routes->post('commissions/store', 'CommissionControlleur::store');

    $routes->get('commissions/edit/(:num)', 'CommissionControlleur::edit/$1');
    $routes->post('commissions/update/(:num)', 'CommissionControlleur::update/$1');

    $routes->get('commissions/delete/(:num)', 'CommissionControlleur::delete/$1');

});
$routes->group('client', ['filter' => 'role:2'], function ($routes) {
    $routes->get('dashboard', 'ClientControlleur::dashboard');
    $routes->get('operations', 'ClientControlleur::operations');
    $routes->get('solde', 'OperationController::VoirSolde');
    $routes->get('historique', 'OperationController::voirHistorique');

    $routes->get('depot', 'OperationController::depotForm');
    $routes->post('depot', 'OperationController::depot');

    $routes->get('retrait', 'OperationController::retraitForm');
    $routes->post('retrait', 'OperationController::retrait');

    $routes->get('transfert', 'OperationController::transfertForm');
    $routes->post('transfert', 'OperationController::transfert');

    $routes->get('transfert-multiple', 'OperationController::transfertMultipleForm');
    $routes->post('transfert-multiple', 'OperationController::transfertMultiple');

    $routes->get('conf','ConfigEpargnesControlleur::index');
    $routes->post('conf','ConfigEpargnesControlleur::save');
});
