<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->get('/test-db', function () {

    $db = \Config\Database::connect();

    if ($db) {
        echo "Koneksi database berhasil";
    } else {
        echo "Koneksi database gagal";
    }
});

$routes->get('/login', 'AuthController::login');

$routes->post('/login/process', 'AuthController::processLogin');

$routes->get('/logout', 'AuthController::logout');

$routes->get(
    '/buku',
    'BukuController::index',
    ['filter' => 'auth']
);

$routes->get('/buku', 'BukuController::index', ['filter' => 'auth']);

$routes->get('/buku/create', 'BukuController::create', ['filter' => 'auth']);

$routes->post('/buku/store', 'BukuController::store', ['filter' => 'auth']);

$routes->get('/buku/edit/(:num)', 'BukuController::edit/$1', ['filter' => 'auth']);

$routes->post('/buku/update/(:num)', 'BukuController::update/$1', ['filter' => 'auth']);

$routes->get('/buku/delete/(:num)', 'BukuController::delete/$1', ['filter' => 'auth']);