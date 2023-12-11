<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Itemperalatan extends CI_Controller
{
	private $now;
    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['kopeg'])) {
            redirect('login');
        }
        $this->load->model('Model_item_peralatan', 'item');
		$this->now = date('Y-m-d H:i:s');
    }

    public function index()
    {
        $data['pagetitle'] = 'Master Item Peralatan';

        $data['javascript'] = 'master/item_peralatan/item_peralatan.js';
        $this->template->load('template', 'master_item_peralatan/item_peralatan', $data);
    }

    public function list()
    {
        $list = $this->item->get_data_m_item_peralatan();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ls) {
            $no++;
            $row = array();


            $row[] = '<p href="#" class="text-primary text-hover-primary mb-1">' . $ls['nama_item'] . '</p><small>' . $ls['id_item_peralatan'] . '</small>';
            $row[] = '<p class="text-dark mb-0">' . relative_time(oracle_time($ls['updated_at'])) . '</p><small>' . format_time(oracle_time($ls['updated_at'])) . '</small>';
            $row[] = '<div class="dropdown text-end">
                        <a class="btn btn-light btn-active-light-primary btn-sm dropdown-toggle" href="#" role="button" id="actions" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </a>    
                        <ul class="dropdown-menu" aria-labelledby="actions">
                            <li><a class="dropdown-item ubah-item-peralatan" href="#" data-id="' . $ls['id_item_peralatan'] . '">Ubah</a></li>
                            <li><a class="dropdown-item hapus-item-peralatan" href="#" data-id="' . $ls['id_item_peralatan'] . '">Hapus</a></li>
                        </ul>
                    </div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->item->records_total_m_item_peralatan(),
            "recordsFiltered" => $this->item->records_filter_m_item_peralatan(),
            "data" => $data,
        );
        echo json_encode($output);
    }

	public function store() 
	{
		$input = array(
			'id_item_peralatan' => last_id('m_item_peralatan', 'id_item_peralatan'),
			'nama_item' => $this->security->xss_clean($this->input->post('nama_item_peralatan'))
		);
		$this->db->set('"created_at"', "TO_DATE('$this->now', 'YYYY-MM-DD HH24:MI:SS')", false);
		$this->db->set('"updated_at"', "TO_DATE('$this->now', 'YYYY-MM-DD HH24:MI:SS')", false);
		if($this->item->store($input)){
			$result = array('status'  => true, 'messages' => 'Item peralatan baru ditambahkan');
		}else {
			$result = array('status'  => false, 'messages' => 'Item peralatan gagal ditambahkan');
		}
		echo json_encode($result);
	}

	public function lookup()
	{
		$id_item_peralatan = $this->security->xss_clean($this->input->post('id_item_peralatan'));
		$data = $this->item->lookup($id_item_peralatan);
		echo json_encode(
			array(
				'status' => true,
				'message' => "Berhasil menarik data dengan id $id_item_peralatan",
				'data' => $data
			)
		);
	}

	public function update()
	{
		$data = array(
			'id_item_peralatan' => $this->security->xss_clean($this->input->post('edit_id_item_peralatan')),
			'nama_item' => $this->security->xss_clean($this->input->post('edit_nama_item_peralatan')),
		);
		$this->db->set('"updated_at"', "TO_DATE('$this->now', 'YYYY-MM-DD HH24:MI:SS')", false);
		if($this->item->update($data)){
			$result = array('status'  => true, 'messages' => 'Item peralatan diperbarui');
		}else{
			$result = array('status'  => false, 'messages' => 'Item peralatan gagal diperbarui');
		}

		echo json_encode ($result);
	}

	public function delete()
	{
		$id_item_peralatan = $this->security->xss_clean($this->input->post('id_item_peralatan'));
		$data = array(
			'is_deleted' => 1,
		);
		$this->db->set('"updated_at"', "TO_DATE('$this->now', 'YYYY-MM-DD HH24:MI:SS')", false);
		if($this->item->delete($id_item_peralatan, $data)){
			$result = array('status'  => true, 'messages' => 'Item peralatan dihapus');
		}else{
			$result = array('status'  => false, 'messages' => 'Item peralatan gagal dihapus');
		}

		echo json_encode ($result);
	}
}
