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
