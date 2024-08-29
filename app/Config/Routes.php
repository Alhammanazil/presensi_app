<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Login::index');
$routes->post('login', 'Login::login_action');
$routes->get('/logout', 'Login::logout');

// Admin
$routes->get('admin/home','Admin\Home::index', ['filter' => 'adminfilter']);
$routes->get('admin/jabatan','Admin\Jabatan::index', ['filter' => 'adminfilter']);
$routes->get('admin/jabatan/create', 'Admin\Jabatan::create', ['filter' => 'adminfilter']);
$routes->post('admin/jabatan/store', 'Admin\Jabatan::store', ['filter' => 'adminfilter']);
$routes->get('admin/jabatan/edit/(:segment)', 'Admin\Jabatan::edit/$1', ['filter' => 'adminfilter']);
$routes->post('admin/jabatan/update/(:segment)', 'Admin\Jabatan::update/$1', ['filter' => 'adminfilter']);
$routes->get('admin/jabatan/delete/(:segment)', 'Admin\Jabatan::delete/$1', ['filter' => 'adminfilter']);

// Pegawai
$routes->get('pegawai/home','Pegawai\Home::index', ['filter'=> 'pegawaifilter']);
