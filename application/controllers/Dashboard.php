<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['kopeg'])) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['pagetitle'] = 'Dashboard';

        $data['javascript'] = 'dashboard/dashboard.js';
        $this->template->load('template', 'dashboard', $data);
    }
}
