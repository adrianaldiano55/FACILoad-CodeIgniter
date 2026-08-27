<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('/unauthorized', 'Home::unauthorized');

$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attemptLogin');

$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::attemptRegister');

$routes->get('/logout', 'Auth::logout');



$routes->get(
    '/admin_dashboard',
    'Dashboard::admin',
    ['filter' => 'auth:admin']
);
$routes->get(
    '/staff_dashboard',
    'Dashboard::staff',
    ['filter' => 'auth:staff']
);
