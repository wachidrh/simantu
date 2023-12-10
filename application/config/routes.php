<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['logout'] = 'login/logout';
$route['login'] = 'login/index';


// Pengguna
$route['pengguna/list-pengguna'] = 'pengguna/index';
$route['pengguna/get-pengguna'] = 'pengguna/get_pengguna';

// master peralatan
$route['master/peralatan'] = 'master_peralatan/peralatan/index';
$route['master/peralatan/get-master-peralatan'] = 'master_peralatan/peralatan/get_m_peralatan';
$route['master/peralatan/store'] = 'master_peralatan/peralatan/store';
$route['master/peralatan/lookup'] = 'master_peralatan/peralatan/lookup';
$route['master/peralatan/update'] = 'master_peralatan/peralatan/update';
$route['master/peralatan/delete'] = 'master_peralatan/peralatan/delete';
