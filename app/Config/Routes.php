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

$routes->get('show_faculty', 'Dashboard::show_faculty');
$routes->get('show_sections', 'Dashboard::show_sections');
$routes->get('show_rooms', 'Dashboard::show_rooms');

$routes->get(
    '/admin_dashboard',
    'Dashboard::admin',
    ['filter' => 'auth:admin']
);

$routes->get(
    '/faculty_dashboard',
    'Dashboard::faculty',
    ['filter' => 'auth:faculty']
);

$routes->get(
    'show_faculty_schedule/(:num)',
    'Dashboard::show_faculty_schedule/$1'
);
$routes->get(
    'show_faculty',
    'Dashboard::show_faculty'
);