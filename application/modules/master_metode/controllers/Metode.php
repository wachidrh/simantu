<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Metode extends CI_Controller
{
	private $now;
    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['kopeg'])) {
            redirect('login');
        }
        $this->load->model('Model_metode', 'metode');
		$this->now = date('Y-m-d H:i:s');
    }

    public function index()
    {
        $data['pagetitle'] = 'Master Metode';

        $data['javascript'] = 'master/metode/metode.js';
        $this->template->load('template', 'master_metode/metode', $data);
    }

    public function list()
    {
        $list = $this->metode->get_data_m_metode();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ls) {
            $no++;
            $row = array();


            $row[] = '<p href="#" class="text-primary text-hover-primary mb-1">' . $ls['metode'] . '</p><small>' . $ls['id_metode'] . '</small>';
            $row[] = '<p class="text-dark mb-0">' . relative_time(oracle_time($ls['updated_at'])) . '</p><small>' . format_time(oracle_time($ls['updated_at'])) . '</small>';
            $row[] = '<div class="dropdown text-end">
                        <a class="btn btn-light btn-active-light-primary btn-sm dropdown-toggle" href="#" role="button" id="actions" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </a>    
                        <ul class="dropdown-menu" aria-labelledby="actions">
                            <li><a class="dropdown-item ubah-metode" href="#" data-id="' . $ls['id_metode'] . '">Ubah</a></li>
                            <li><a class="dropdown-item hapus-metode" href="#" data-id="' . $ls['id_metode'] . '">Hapus</a></li>
                        </ul>
                    </div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->metode->records_total_m_metode(),
            "recordsFiltered" => $this->metode->records_filter_m_metode(),
            "data" => $data,
        );
        echo json_encode($output);
    }

	public function store() 
	{
		$input = array(
			'id_metode' => last_id('m_metode_pemeriksaan', 'id_metode'),
			'metode' => $this->security->xss_clean($this->input->post('metode'))
		);
		$this->db->set('"created_at"', "TO_DATE('$this->now', 'YYYY-MM-DD HH24:MI:SS')", false);
		$this->db->set('"updated_at"', "TO_DATE('$this->now', 'YYYY-MM-DD HH24:MI:SS')", false);
		if($this->metode->store($input)){
			$result = array('status'  => true, 'messages' => 'metode pemeriksaan baru ditambahkan');
		}else {
			$result = array('status'  => false, 'messages' => 'metode pemeriksaan gagal ditambahkan');
		}
		echo json_encode($result);
	}

	public function lookup()
	{
		$id_metode = $this->security->xss_clean($this->input->post('id_metode'));
		$data = $this->metode->lookup($id_metode);
		echo json_encode(
			array(
				'status' => true,
				'message' => "Berhasil menarik data dengan id $id_metode",
				'data' => $data
			)
		);
	}

	public function update()
	{
		$data = array(
			'id_metode' => $this->security->xss_clean($this->input->post('edit_id_metode')),
			'metode' => $this->security->xss_clean($this->input->post('edit_metode')),
		);
		$this->db->set('"updated_at"', "TO_DATE('$this->now', 'YYYY-MM-DD HH24:MI:SS')", false);
		if($this->metode->update($data)){
			$result = array('status'  => true, 'messages' => 'metode pemeriksaan diperbarui');
		}else{
			$result = array('status'  => false, 'messages' => 'metode pemeriksaan gagal diperbarui');
		}

		echo json_encode ($result);
	}

	public function delete()
	{
		$id_metode = $this->security->xss_clean($this->input->post('id_metode'));
		$data = array(
			'is_deleted' => 1,
		);
		$this->db->set('"updated_at"', "TO_DATE('$this->now', 'YYYY-MM-DD HH24:MI:SS')", false);
		if($this->metode->delete($id_metode, $data)){
			$result = array('status'  => true, 'messages' => 'metode pemeriksaan dihapus');
		}else{
			$result = array('status'  => false, 'messages' => 'metode pemeriksaan gagal dihapus');
		}

		echo json_encode ($result);
	}
}
