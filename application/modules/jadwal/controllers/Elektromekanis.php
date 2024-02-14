<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Elektromekanis extends CI_Controller
{
	private $now;
	public function __construct()
	{
		parent::__construct();
		if (!isset($_SESSION['kopeg'])) {
			redirect('login');
		}
		$this->load->model('Model_elektromekanis', 'elektromekanis');
		$this->load->library('form_validation');
		$this->now = date('Y-m-d H:i:s');
	}

	public function index()
	{
		$data['pagetitle'] = 'Jadwal Elektromekanis';
		$data['bangunan'] = $this->elektromekanis->get_all_m_bangunan();
		$data['peralatan'] = $this->elektromekanis->get_all_m_peralatan();
		$data['item_peralatan'] = $this->elektromekanis->get_all_m_item_peralatan();
		$data['kriteria'] = $this->elektromekanis->get_all_m_kriteria();
		$data['metode'] = $this->elektromekanis->get_all_m_metode();
		$data['periode'] = $this->elektromekanis->get_all_m_periode();
		$data['lokasi'] = $this->elektromekanis->get_lokasi_by_id((int)$_SESSION['active_auth']['unit_id']);

		$data['javascript'] = 'jadwal/elektromekanis.js';
		$this->template->load('template', 'jadwal/elektromekanis', $data);
	}

	public function list()
	{
		$list = $this->elektromekanis->get_data_m_jadwal();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $ls) {
			$no++;
			$row = array();


			$row[] = '<p class="text-dark mb-0">' . relative_time(oracle_time($ls['created_at'])) . '</p><small>' . format_time(oracle_time($ls['created_at'])) . '</small>';
			$row[] = '<p class="text-dark mb-0">' . $ls['triwulan'] . '</p>';
			$row[] = '<p class="text-dark mb-0">' . $ls['tahun_jadwal'] . '</p>';
			$row[] = '<p href="#" class="text-primary text-hover-primary mb-1">' . $ls['full_name'] . '</p><small>' . $ls['created_by'] . '</small>';
			$row[] = '<div class="dropdown text-end">
                        <a class="btn btn-light btn-active-light-primary btn-sm dropdown-toggle" href="#" role="button" id="actions" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </a>    
                        <ul class="dropdown-menu" aria-labelledby="actions">
                            <li><a class="dropdown-item lihat-jadwal" href="' . base_url('jadwal/elektromekanis/detail/' . $ls['id_jadwal']) . '" data-id="' . $ls['id_jadwal'] . '">Rincian</a></li>
                            <li><a class="dropdown-item hapus-jadwal" href="#" data-id="' . $ls['id_jadwal'] . '">Hapus</a></li>
                        </ul>
                    </div>';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->elektromekanis->records_total_m_jadwal(),
			"recordsFiltered" => $this->elektromekanis->records_filter_m_jadwal(),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function show($id)
	{
		$data['pagetitle'] = 'Jadwal Elektromekanis';
		$data['jadwal'] = $this->elektromekanis->lookup($id);

		$data['javascript'] = 'jadwal/elektromekanis/show.js';
		$this->template->load('template', 'jadwal/elektromekanis/show', $data);
	}

	public function store()
	{
		$tahun_jadwal = $this->security->xss_clean($this->input->post('tahun_jadwal'));
		$triwulan = $this->security->xss_clean($this->input->post('triwulan'));
		$rows = $this->db->from('tbl_jadwal')->where('triwulan', $triwulan)->where('tahun_jadwal', $tahun_jadwal)->get()->num_rows();
		if($rows > 0){
			echo json_encode( array('status'  => false, 'messages' => "Jadwal dengan triwulan $triwulan dan tahun $tahun_jadwal sudah ada"));
			return;
		}
		$data_bangunan = $this->security->xss_clean($this->input->post('repeater_bangunan_outer'));
		$data_rawat_bangunan = $this->security->xss_clean($this->input->post('repeater_rawat_bangunan_outer'));

		$data['insert_jadwal'] = array(
			'id_jadwal' => last_id('tbl_jadwal', 'id_jadwal'),
			'm_lokasi_id' => (int)$_SESSION['active_auth']['unit_id'],
			'created_at' => $this->timestamp(),
			'updated_at' => $this->timestamp(),
			'created_by' => $_SESSION['kopeg'],
			'triwulan' => $triwulan,
			'tahun_jadwal' => $tahun_jadwal,
			'jenis_jadwal' => 1,
		);

		$data['data_bangunan'] = $data_bangunan;
		$data['data_rawat_bangunan'] = $data_rawat_bangunan;


		if ($this->elektromekanis->store($data)) {
			$result = array('status'  => true, 'messages' => 'Jadwal baru berhasil ditambahkan');
		} else {
			$result = array('status'  => false, 'messages' => 'Jadwal baru berhasil ditambahkan');
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
		if ($this->bangunan->update($data)) {
			$result = array('status'  => true, 'messages' => 'Jenis bangunan diperbarui');
		} else {
			$result = array('status'  => false, 'messages' => 'Jenis bangunan gagal diperbarui');
		}

		echo json_encode($result);
	}

	public function delete()
	{
		$id_jadwal	 = $this->security->xss_clean($this->input->post('id_jadwal'));
		if ($this->elektromekanis->delete($id_jadwal)) {
			$result = array('status'  => true, 'messages' => 'Jadwal dihapus');
		} else {
			$result = array('status'  => false, 'messages' => 'Jadwal gagal dihapus');
		}

		echo json_encode($result);
	}

	public function approve()
	{
		$id_jadwal = $this->security->xss_clean($this->input->post('id_jadwal'));
		$data = array('status' => 1, 'approved_at' => $this->timestamp());
		if ($this->elektromekanis->approve($id_jadwal, $data)) {
			$result = array('status'  => true, 'messages' => 'Berhasil menyetujui');
		} else {
			$result = array('status'  => false, 'messages' => 'Gagal menyetujui');
		}

		echo json_encode($result);
	}
}
