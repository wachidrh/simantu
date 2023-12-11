<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peralatan extends CI_Controller
{
	private $now;
    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['kopeg'])) {
            redirect('login');
        }
        $this->load->model('Model_peralatan', 'peralatan');
		$this->now = date('Y-m-d H:i:s');
    }

    public function index()
    {
        $data['pagetitle'] = 'Setup Peralatan';
		$data['m_peralatan'] = $this->peralatan->get_all_m_peralatan();
		$data['m_bangunan'] = $this->peralatan->get_all_m_bangunan();

        $data['javascript'] = 'setup/peralatan/peralatan.js';
		// var_dump($data['m_peralatan']);
		// exit;
        $this->template->load('template', 'setup_peralatan/peralatan', $data);
    }

    public function list()
    {
        $list = $this->peralatan->get_data_peralatan();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ls) {
            $no++;
            $row = array();


            $row[] = '<p href="#" class="text-primary text-hover-primary mb-1">' . $ls['nama_bangunan'] . '</p>';
            $row[] = '<p href="#" class="text-primary text-hover-primary mb-1">' . $ls['nama'] . '</p>';
            $row[] = '<p href="#" class="text-primary text-hover-primary mb-1">' . $ls['nfc_serial_number'] . '</p>';
            $row[] = '<p class="text-dark mb-0">' . relative_time(oracle_time($ls['updated_at'])) . '</p><small>' . format_time(oracle_time($ls['updated_at'])) . '</small>';
            $row[] = '<div class="dropdown text-end">
                        <a class="btn btn-light btn-active-light-primary btn-sm dropdown-toggle" href="#" role="button" id="actions" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </a>    
                        <ul class="dropdown-menu" aria-labelledby="actions">
                            <li><a class="dropdown-item ubah-peralatan" href="#" data-id="' . $ls['id_peralatan'] . '">Ubah</a></li>
                            <li><a class="dropdown-item hapus-peralatan" href="#" data-id="' . $ls['id_peralatan'] . '">Hapus</a></li>
                        </ul>
                    </div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->peralatan->records_total_peralatan(),
            "recordsFiltered" => $this->peralatan->records_filter_peralatan(),
            "data" => $data,
        );
        echo json_encode($output);
    }

	public function store() 
	{
		$input = array(
			'id_peralatan' => last_id('tbl_peralatan', 'id_peralatan'),
			'id_m_jenis_peralatan' => $this->security->xss_clean($this->input->post('id_jenis_peralatan')),
			'id_m_jenis_bangunan' => $this->security->xss_clean($this->input->post('id_jenis_bangunan')),
			'nfc_serial_number' => $this->security->xss_clean($this->input->post('nfc_serial_number')),
			'created_at' => $this->timestamp(),
			'updated_at' => $this->timestamp()
		);
		if($this->peralatan->store($input)){
			$result = array('status'  => true, 'messages' => 'data peralatan baru ditambahkan');
		}else {
			$result = array('status'  => false, 'messages' => 'data peralatan gagal ditambahkan');
		}
		echo json_encode($result);
	}

	public function lookup()
	{
		$id_peralatan = $this->security->xss_clean($this->input->post('id_peralatan'));
		$data = $this->peralatan->lookup($id_peralatan);
		echo json_encode(
			array(
				'status' => true,
				'message' => "Berhasil menarik data dengan id $id_peralatan",
				'data' => $data
			)
		);
	}

	public function update()
	{
		$data = array(
			'id_peralatan' => $this->security->xss_clean($this->input->post('edit_id_peralatan')),
			'id_m_jenis_peralatan' => $this->security->xss_clean($this->input->post('edit_id_jenis_peralatan')),
			'id_m_jenis_bangunan' => $this->security->xss_clean($this->input->post('edit_id_jenis_bangunan')),
			'nfc_serial_number' => $this->security->xss_clean($this->input->post('edit_nfc_serial_number')),
			'updated_at' => $this->timestamp()
		);
		if($this->peralatan->update($data)){
			$result = array('status'  => true, 'messages' => 'Jenis peralatan diperbarui');
		}else{
			$result = array('status'  => false, 'messages' => 'Jenis peralatan gagal diperbarui');
		}

		echo json_encode ($result);
	}

	public function delete()
	{
		$id_peralatan = $this->security->xss_clean($this->input->post('id_peralatan'));
		$data = array(
			'is_deleted' => 1,
			'updated_at' => $this->timestamp()
		);
		if($this->peralatan->delete($id_peralatan, $data)){
			$result = array('status'  => true, 'messages' => 'Jenis peralatan dihapus');
		}else{
			$result = array('status'  => false, 'messages' => 'Jenis peralatan gagal dihapus');
		}

		echo json_encode ($result);
	}
}
