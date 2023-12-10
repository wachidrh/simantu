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

// master item peralatan
$route['master/item-peralatan'] = 'master_item_peralatan/itemperalatan/index';
$route['master/item-peralatan/list'] = 'master_item_peralatan/itemperalatan/list';
$route['master/item-peralatan/store'] = 'master_item_peralatan/itemperalatan/store';
$route['master/item-peralatan/lookup'] = 'master_item_peralatan/itemperalatan/lookup';
$route['master/item-peralatan/update'] = 'master_item_peralatan/itemperalatan/update';
$route['master/item-peralatan/delete'] = 'master_item_peralatan/itemperalatan/delete';

// master kriteria
$route['master/kriteria'] = 'master_kriteria/kriteria/index';
$route['master/kriteria/list'] = 'master_kriteria/kriteria/list';
$route['master/kriteria/store'] = 'master_kriteria/kriteria/store';
$route['master/kriteria/lookup'] = 'master_kriteria/kriteria/lookup';
$route['master/kriteria/update'] = 'master_kriteria/kriteria/update';
$route['master/kriteria/delete'] = 'master_kriteria/kriteria/delete';

// master metode
$route['master/metode'] = 'master_metode/metode/index';
$route['master/metode/list'] = 'master_metode/metode/list';
$route['master/metode/store'] = 'master_metode/metode/store';
$route['master/metode/lookup'] = 'master_metode/metode/lookup';
$route['master/metode/update'] = 'master_metode/metode/update';
$route['master/metode/delete'] = 'master_metode/metode/delete';
