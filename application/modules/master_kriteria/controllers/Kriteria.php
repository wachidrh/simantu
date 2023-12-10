<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kriteria extends CI_Controller
{
	private $now;
    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['kopeg'])) {
            redirect('login');
        }
        $this->load->model('Model_kriteria', 'kriteria');
		$this->now = date('Y-m-d H:i:s');
    }

    public function index()
    {
        $data['pagetitle'] = 'Master Kriteria';

        $data['javascript'] = 'master/kriteria/kriteria.js';
        $this->template->load('template', 'master_kriteria/kriteria', $data);
    }

    public function list()
    {
        $list = $this->kriteria->get_data_m_kriteria();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ls) {
            $no++;
            $row = array();


            $row[] = '<p href="#" class="text-primary text-hover-primary mb-1">' . $ls['kriteria'] . '</p><small>' . $ls['id_kriteria'] . '</small>';
            $row[] = '<p class="text-dark mb-0">' . relative_time(oracle_time($ls['updated_at'])) . '</p><small>' . format_time(oracle_time($ls['updated_at'])) . '</small>';
            $row[] = '<div class="dropdown text-end">
                        <a class="btn btn-light btn-active-light-primary btn-sm dropdown-toggle" href="#" role="button" id="actions" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </a>    
                        <ul class="dropdown-menu" aria-labelledby="actions">
                            <li><a class="dropdown-item ubah-kriteria" href="#" data-id="' . $ls['id_kriteria'] . '">Ubah</a></li>
                            <li><a class="dropdown-item hapus-kriteria" href="#" data-id="' . $ls['id_kriteria'] . '">Hapus</a></li>
                        </ul>
                    </div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->kriteria->records_total_m_kriteria(),
            "recordsFiltered" => $this->kriteria->records_filter_m_kriteria(),
            "data" => $data,
        );
        echo json_encode($output);
    }

	public function store() 
	{
		$input = array(
			'id_kriteria' => last_id('m_kriteria_pemeriksaan', 'edit_id_kriteria'),
			'kriteria' => $this->security->xss_clean(strtolower($this->input->post('edit_kriteria')))
		);
		$this->db->set('"created_at"', "TO_DATE('$this->now', 'YYYY-MM-DD HH24:MI:SS')", false);
		$this->db->set('"updated_at"', "TO_DATE('$this->now', 'YYYY-MM-DD HH24:MI:SS')", false);
		if($this->kriteria->store($input)){
			$result = array('status'  => true, 'messages' => 'Kriteria pemeriksaan baru ditambahkan');
		}else {
			$result = array('status'  => false, 'messages' => 'Kriteria pemeriksaan gagal ditambahkan');
		}
		echo json_encode($result);
	}

	public function lookup()
	{
		$id_kriteria = $this->security->xss_clean($this->input->post('id_kriteria'));
		$data = $this->kriteria->lookup($id_kriteria);
		echo json_encode(
			array(
				'status' => true,
				'message' => "Berhasil menarik data dengan id $id_kriteria",
				'data' => $data
			)
		);
	}

	public function update()
	{
		$data = array(
			'id_kriteria' => $this->security->xss_clean($this->input->post('edit_id_kriteria')),
			'kriteria' => $this->security->xss_clean($this->input->post('edit_kriteria')),
		);
		$this->db->set('"updated_at"', "TO_DATE('$this->now', 'YYYY-MM-DD HH24:MI:SS')", false);
		if($this->kriteria->update($data)){
			$result = array('status'  => true, 'messages' => 'Kriteria pemeriksaan diperbarui');
		}else{
			$result = array('status'  => false, 'messages' => 'Kriteria pemeriksaan gagal diperbarui');
		}

		echo json_encode ($result);
	}

	public function delete()
	{
		$id_kriteria = $this->security->xss_clean($this->input->post('id_kriteria'));
		$data = array(
			'is_deleted' => 1,
		);
		$this->db->set('"updated_at"', "TO_DATE('$this->now', 'YYYY-MM-DD HH24:MI:SS')", false);
		if($this->kriteria->delete($id_kriteria, $data)){
			$result = array('status'  => true, 'messages' => 'Kriteria pemeriksaan dihapus');
		}else{
			$result = array('status'  => false, 'messages' => 'Kriteria pemeriksaan gagal dihapus');
		}

		echo json_encode ($result);
	}
}
