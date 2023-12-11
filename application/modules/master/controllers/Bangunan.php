<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bangunan extends CI_Controller
{
	private $now;
    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['kopeg'])) {
            redirect('login');
        }
        $this->load->model('Model_bangunan', 'bangunan');
		$this->now = date('Y-m-d H:i:s');
    }

    public function index()
    {
        $data['pagetitle'] = 'Master Jenis Bangunan';

        $data['javascript'] = 'master/bangunan/bangunan.js';
        $this->template->load('template', 'master_bangunan/bangunan', $data);
    }

    public function list()
    {
        $list = $this->bangunan->get_data_m_bangunan();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ls) {
            $no++;
            $row = array();


            $row[] = '<p class="text-dark mb-0">' . relative_time(oracle_time($ls['updated_at'])) . '</p><small>' . format_time(oracle_time($ls['updated_at'])) . '</small>';
            $row[] = '<p href="#" class="text-primary text-hover-primary mb-1">' . $ls['nama_bangunan'] . '</p><small>' . $ls['id_jenis_bangunan'] . '</small>';
            $row[] = '<div class="dropdown text-end">
                        <a class="btn btn-light btn-active-light-primary btn-sm dropdown-toggle" href="#" role="button" id="actions" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </a>    
                        <ul class="dropdown-menu" aria-labelledby="actions">
                            <li><a class="dropdown-item ubah-bangunan" href="#" data-id="' . $ls['id_jenis_bangunan'] . '">Ubah</a></li>
                            <li><a class="dropdown-item hapus-bangunan" href="#" data-id="' . $ls['id_jenis_bangunan'] . '">Hapus</a></li>
                        </ul>
                    </div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->bangunan->records_total_m_bangunan(),
            "recordsFiltered" => $this->bangunan->records_filter_m_bangunan(),
            "data" => $data,
        );
        echo json_encode($output);
    }

	public function store() 
	{
		$input = array(
			'id_jenis_bangunan' => last_id('m_jenis_bangunan', 'id_jenis_bangunan'),
			'nama_bangunan' => $this->security->xss_clean($this->input->post('nama_bangunan'))
		);
		$this->db->set('"created_at"', "TO_DATE('$this->now', 'YYYY-MM-DD HH24:MI:SS')", false);
		$this->db->set('"updated_at"', "TO_DATE('$this->now', 'YYYY-MM-DD HH24:MI:SS')", false);
		if($this->bangunan->store($input)){
			$result = array('status'  => true, 'messages' => 'Jenis bangunan baru ditambahkan');
		}else {
			$result = array('status'  => false, 'messages' => 'Jenis bangunan gagal ditambahkan');
		}
		echo json_encode($result);
	}

	public function lookup()
	{
		$id_jenis_bangunan = $this->security->xss_clean($this->input->post('id_jenis_bangunan'));
		$data = $this->bangunan->lookup($id_jenis_bangunan);
		echo json_encode(
			array(
				'status' => true,
				'message' => "Berhasil menarik data dengan id $id_jenis_bangunan",
				'data' => $data
			)
		);
	}

	public function update()
	{
		$data = array(
			'id_jenis_bangunan' => $this->security->xss_clean($this->input->post('edit_id_jenis_bangunan')),
			'nama_bangunan' => $this->security->xss_clean($this->input->post('edit_nama_bangunan')),
		);
		$this->db->set('"updated_at"', "TO_DATE('$this->now', 'YYYY-MM-DD HH24:MI:SS')", false);
		if($this->bangunan->update($data)){
			$result = array('status'  => true, 'messages' => 'Jenis bangunan diperbarui');
		}else{
			$result = array('status'  => false, 'messages' => 'Jenis bangunan gagal diperbarui');
		}

		echo json_encode ($result);
	}

	public function delete()
	{
		$id_jenis_bangunan = $this->security->xss_clean($this->input->post('id_jenis_bangunan'));
		$data = array(
			'is_deleted' => 1,
		);
		$this->db->set('"updated_at"', "TO_DATE('$this->now', 'YYYY-MM-DD HH24:MI:SS')", false);
		if($this->bangunan->delete($id_jenis_bangunan, $data)){
			$result = array('status'  => true, 'messages' => 'Jenis bangunan dihapus');
		}else{
			$result = array('status'  => false, 'messages' => 'Jenis bangunan gagal dihapus');
		}

		echo json_encode ($result);
	}
}
