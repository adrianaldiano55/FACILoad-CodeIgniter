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
    '/faculty_dashboard',
    'Dashboard::faculty',
    ['filter' => 'auth:faculty']
);
$routes->group('', ['filter' => 'auth:admin'], static function ($routes): void {
    $routes->get('show_faculty', 'Dashboard::show_faculty');
    $routes->get('show_sections', 'Dashboard::show_sections');
    $routes->get('show_room', 'Dashboard::show_room');

// SESSION MANAGEMENT
$routes->get(
    'show_faculty_schedule/(:num)',
    'Dashboard::show_faculty_schedule/$1'
);
$routes->get(
    'show_room_schedule/(:num)',
    'Dashboard::show_room_schedule/$1'
);
$routes->get(
    'show_section_schedule/(:num)',
    'Dashboard::show_section_schedule/$1'
);
    $routes->post('create_session', 'Dashboard::create_session');
    $routes->get('get_session/(:num)', 'Dashboard::get_session/$1');
    $routes->post('update_session/(:num)', 'Dashboard::update_session/$1');
    $routes->post('delete_session/(:num)', 'Dashboard::delete_session/$1');

// SUBJECT MANAGEMENT

$routes->get(
    'show_subjects',
    'Dashboard::show_subjects'
);
$routes->get(
    'get_subject/(:num)',
    'Dashboard::get_subject/$1'
);
$routes->post(
    'create_subject',
    'Dashboard::create_subject'
);
$routes->post(
    'update_subject/(:num)',
    'Dashboard::update_subject/$1'
);
$routes->post(
    'delete_subject/(:num)',
    'Dashboard::delete_subject/$1'
);

// SECTION MANAGEMENT
    $routes->get('get_section/(:num)', 'Dashboard::get_section/$1');
    $routes->post('create_section', 'Dashboard::create_section');
    $routes->post('update_section/(:num)', 'Dashboard::update_section/$1');
    $routes->post('delete_section/(:num)', 'Dashboard::delete_section/$1');

// FACULTY MANAGEMENT 
    $routes->get('get_faculty/(:num)', 'Dashboard::get_faculty/$1');
    $routes->post('create_faculty', 'Dashboard::create_faculty');
    $routes->post('update_faculty/(:num)', 'Dashboard::update_faculty/$1');
    $routes->post('delete_faculty/(:num)', 'Dashboard::delete_faculty/$1');

// ROOM MANAGEMENT
    $routes->get('get_room/(:num)', 'Dashboard::get_room/$1');
    $routes->post('create_room', 'Dashboard::create_room');
    $routes->post('update_room/(:num)', 'Dashboard::update_room/$1');
    $routes->post('delete_room/(:num)', 'Dashboard::delete_room/$1');
});

// FACULTY DASHBOARD
$routes->get(
    'get_my_schedule',
    'Dashboard::get_my_schedule',
    ['filter' => 'auth:faculty']
);
$routes->get(
    'get_my_profile',
    'Dashboard::get_my_profile',
    ['filter' => 'auth:faculty']
);