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
});
