<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::registerPost');

$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::loginPost');

$routes->get('/logout', 'Auth::logout');

$routes->get('/products', 'Products::index');
$routes->get('/products/create', 'Products::create');
$routes->post('/products/store', 'Products::store');
$routes->get('/products/show/(:num)', 'Products::show/$1');