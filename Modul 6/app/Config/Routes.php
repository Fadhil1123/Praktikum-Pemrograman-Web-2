<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// router untuk mengatur routing pada aplikasi CodeIgniter 4
$routes->get('/', 'Home::index');
$routes->get('/profile', 'Profile::index');