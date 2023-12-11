<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengguna extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['kopeg'])) {
            redirect('login');
        }
        $this->load->model('Model_pengguna', 'pengguna');
    }

    public function index()
    {
        $data['pagetitle'] = 'Pengguna';

        $data['javascript'] = 'pengguna/pengguna.js';
        $this->template->load('template', 'pengguna/pengguna', $data);
    }

    public function get_pengguna()
    {
        $list = $this->pengguna->get_data_pengguna();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ls) {
            $no++;
            $row = array();


            $row[] = '<p href="#" class="text-primary text-hover-primary mb-1">' . $ls['full_name'] . '</p><small>' . $ls['kopeg'] . '</small>';
            $row[] = '<p class="text-dark mb-0">' . relative_time(oracle_time($ls['created_at'])) . '</p><small>' . format_time(oracle_time($ls['created_at'])) . '</small>';
            $row[] = '<div class="dropdown  text-end">
                        <a class="btn btn-light btn-active-light-primary btn-sm dropdown-toggle" href="#" role="button" id="actions" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </a>    
                        <ul class="dropdown-menu" aria-labelledby="actions">
                            <li><a class="dropdown-item ubah-pengguna" href="#" data-id="' . $ls['auth_id'] . '">Ubah</a></li>
                            <li><a class="dropdown-item hapus-pengguna" href="#" data-id="' . $ls['auth_id'] . '">Hapus</a></li>
                        </ul>
                    </div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->pengguna->records_total_pengguna(),
            "recordsFiltered" => $this->pengguna->records_filter_pengguna(),
            "data" => $data,
        );
        echo json_encode($output);
    }
}
