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
        $data['pagetitle'] = 'Master Peralatan';

        $data['javascript'] = 'master/peralatan/peralatan.js';
        $this->template->load('template', 'master_peralatan/peralatan', $data);
    }

    public function get_m_peralatan()
    {
        $list = $this->peralatan->get_data_m_peralatan();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ls) {
            $no++;
            $row = array();


            $row[] = '<p href="#" class="text-primary text-hover-primary mb-1">' . $ls['nama'] . '</p><small>' . $ls['id_jenis_peralatan'] . '</small>';
            $row[] = '<p class="text-dark mb-0">' . relative_time(oracle_time($ls['updated_at'])) . '</p><small>' . format_time(oracle_time($ls['updated_at'])) . '</small>';
            $row[] = '<div class="dropdown text-end">
                        <a class="btn btn-light btn-active-light-primary btn-sm dropdown-toggle" href="#" role="button" id="actions" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </a>    
                        <ul class="dropdown-menu" aria-labelledby="actions">
                            <li><a class="dropdown-item ubah-jenis-peralatan" href="#" data-id="' . $ls['id_jenis_peralatan'] . '">Ubah</a></li>
                            <li><a class="dropdown-item hapus-jenis-peralatan" href="#" data-id="' . $ls['id_jenis_peralatan'] . '">Hapus</a></li>
                        </ul>
                    </div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->peralatan->records_total_m_peralatan(),
            "recordsFiltered" => $this->peralatan->records_filter_m_peralatan(),
            "data" => $data,
        );
        echo json_encode($output);
    }

	public function store() 
	{
		$input = array(
			'id_jenis_peralatan' => last_id('m_jenis_peralatan', 'id_jenis_peralatan'),
			'nama' => $this->security->xss_clean(strtolower($this->input->post('nama_jenis_peralatan')))
		);
		$this->db->set('"created_at"', "TO_DATE('$this->now', 'YYYY-MM-DD HH24:MI:SS')", false);
		$this->db->set('"updated_at"', "TO_DATE('$this->now', 'YYYY-MM-DD HH24:MI:SS')", false);
		if($this->peralatan->store($input)){
			$result = array('status'  => true, 'messages' => 'Jenis peralatan baru ditambahkan');
		}else {
			$result = array('status'  => false, 'messages' => 'Jenis peralatan gagal ditambahkan');
		}
		echo json_encode($result);
	}

	public function lookup()
	{
		$id_jenis_peralatan = $this->security->xss_clean($this->input->post('id_jenis_peralatan'));
		$data = $this->peralatan->lookup($id_jenis_peralatan);
		echo json_encode(
			array(
				'status' => true,
				'message' => "Berhasil menarik data dengan id $id_jenis_peralatan",
				'data' => $data
			)
		);
	}

	public function update()
	{
		$data = array(
			'id_jenis_peralatan' => $this->security->xss_clean($this->input->post('edit_id_jenis_peralatan')),
			'nama' => $this->security->xss_clean($this->input->post('edit_nama_jenis_peralatan')),
		);
		$this->db->set('"updated_at"', "TO_DATE('$this->now', 'YYYY-MM-DD HH24:MI:SS')", false);
		if($this->peralatan->update($data)){
			$result = array('status'  => true, 'messages' => 'Jenis peralatan diperbarui');
		}else{
			$result = array('status'  => false, 'messages' => 'Jenis peralatan gagal diperbarui');
		}

		echo json_encode ($result);
	}

	public function delete()
	{
		$id_jenis_peralatan = $this->security->xss_clean($this->input->post('id_jenis_peralatan'));
		$data = array(
			'is_deleted' => 1,
		);
		$this->db->set('"updated_at"', "TO_DATE('$this->now', 'YYYY-MM-DD HH24:MI:SS')", false);
		if($this->peralatan->delete($id_jenis_peralatan, $data)){
			$result = array('status'  => true, 'messages' => 'Jenis peralatan dihapus');
		}else{
			$result = array('status'  => false, 'messages' => 'Jenis peralatan gagal dihapus');
		}

		echo json_encode ($result);
	}
}
