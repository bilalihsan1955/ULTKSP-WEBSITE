<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Authentication Routes
$routes->get('SignIn', 'Auth::index');
$routes->post('SignIn', 'Auth::login');

// $routes->post('/SignIn', 'Auth::login'); // Remove duplication here
$routes->get('SignOut', 'Auth::logout');

$routes->get('Register', 'Auth::form_register');
// $routes->post('/register', 'Auth::register'); // Remove duplication here?
$routes->post('Register', 'Auth::proses_register_user');

$routes->get('activate/(:any)', 'Auth::activate/$1');

$routes->get('forgot-password', 'Auth::forgot_password');

$routes->post('process_forgot_password', 'Auth::process_forgot_password');

$routes->get('reset-password/(:any)', 'Auth::reset_password/$1');

$routes->post('process_reset_password', 'Auth::process_reset_password');

$routes->get('/', 'Index::index');

// Public Routes
// Home route protected by user role

$routes->group('/Dashboard', ['filter' => 'auth:user'], function ($routes) {
    $routes->get('', 'Home::index');

    $routes->get('Profile/(:segment)', 'Home::profile'); // Route untuk menampilkan halaman profil
    $routes->post('Profile', 'Home::updateProfile'); // Route untuk memproses pembaruan profil

    $routes->get('Add-Report', 'Report::index');
    $routes->post('Add-Report', 'Report::addReport');
    $routes->get('Delete/(:segment)/(:any)', 'Post::delete/$2');

    $routes->get('Edit-Report/(:segment)/(:any)', 'Report::editpost/$2');
    $routes->post('Edit-Report/(:segment)/(:any)', 'Report::updatepost/$2');

    $routes->get('Detail-Laporan/(:any)/(:any)', 'Post::index/$2');
    $routes->post('Post-Comment/(:any)', 'Post::addComment/$1');
    $routes->get('Delete-Comment/(:any)', 'Post::deleteComment/$1');
});

$routes->group('Admin', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('', 'Admin::index');
    
    $routes->get('Profile/(:segment)', 'Admin::profile'); // Menampilkan halaman profil
    $routes->post('Profile', 'Admin::updateProfile'); // Memproses pembaruan profil
    
    $routes->get('Detail-Laporan/(:segment)/(:any)', 'Admin::report_post/$2');
    
    $routes->get('User-Management', 'Admin::user');
    $routes->get('Detail-User/(:segment)/(:any)', 'Admin::Users/$2');

    $routes->post('Post-Comment/(:any)', 'Admin::addComment/$1');
    $routes->get('Delete-Comment/(:any)', 'Admin::deleteComment/$1');
});
