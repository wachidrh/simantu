<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Elektromekanis extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!isset($_SESSION['kopeg'])) {
			redirect('login');
		}
		$this->load->model('Model_elektromekanis', 'elektromekanis');
		$this->load->library('encryption');
	}

	public function index()
	{
		$data['pagetitle'] = 'Pemeriksaan Elektromekanis';

		$data['javascript'] = 'pemeriksaan/elektromekanis/elektromekanis.js';
		$this->template->load('template', 'pemeriksaan/elektromekanis/elektromekanis', $data);
	}

	public function list()
	{
		$list = $this->elektromekanis->get_data_periksa_el();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $ls) {
			$no++;
			$row = array();


			$row[] = '<p class="text-dark mb-0">' . relative_time(oracle_time($ls['created_at'])) . '</p><small>' . format_time(oracle_time($ls['created_at'])) . '</small>';
			$row[] = '<p href="#" class="text-primary text-hover-primary mb-1">' . $ls['full_name'] . '</p><small>' . $ls['created_by'] . '</small>';
			$row[] = '<p class="text-dark mb-0">' . $ls['nama_lokasi'] . '</p>';
			$row[] = '<p class="text-dark mb-0">' . $ls['periode'] . '</p>';
			$row[] = '<div class="dropdown text-end">
                        <a class="btn btn-light btn-active-light-primary btn-sm dropdown-toggle" href="#" role="button" id="actions" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </a>    
                        <ul class="dropdown-menu" aria-labelledby="actions">
                            <li><a class="dropdown-item lihat-jadwal" href="' . base_url('pemeriksaan/elektromekanis/detail/' . $ls['id_periksa']) . '" data-id="' . $ls['id_periksa'] . '">Rincian</a></li>
                            <li><a class="dropdown-item hapus-jadwal" href="#" data-id="' . $ls['id_periksa'] . '">Hapus</a></li>
                        </ul>
                    </div>';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->elektromekanis->records_total_periksa_el(),
			"recordsFiltered" => $this->elektromekanis->records_filter_periksa_el(),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function show($id)
	{
		$data['pagetitle'] = 'Rincian Laporan Pemeriksaan Elektromekanis';
		$data['periksa'] = $this->elektromekanis->lookup($id);

		$data['javascript'] = 'pemeriksaan/elektromekanis/show.js';
		$this->template->load('template', 'pemeriksaan/elektromekanis/show', $data);
	}

	public function store()
	{
		$bangunan = $this->security->xss_clean($this->input->post());
		$id_periode = $this->security->xss_clean($this->input->post('id_periode'));

		$data['insert_periksa'] = array(
			'id_periksa' => last_id('tbl_periksa_elektromekanis', 'id_periksa'),
			'm_lokasi_id' => (int)$_SESSION['active_auth']['unit_id'],
			'created_at' => $this->timestamp(),
			'updated_at' => $this->timestamp(),
			'created_by' => $_SESSION['kopeg'],
			'id_periode' => $id_periode,
			'id_jenis_bangunan' => (int)$bangunan['id_jenis_bangunan']
		);

		$data['data_bangunan'] = $bangunan;

		if ($this->elektromekanis->store($data)) {
			$result = array('status'  => true, 'messages' => 'Hasil pemeriksaan berhasil diinput');
		} else {
			$result = array('status'  => false, 'messages' => 'Hasil pemeriksaan berhasil diinput');
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
		$id_jenis_bangunan = $this->security->xss_clean($this->input->post('id_jenis_bangunan'));
		$data = array(
			'is_deleted' => 1,
		);
		$this->db->set('"updated_at"', "TO_DATE('$this->now', 'YYYY-MM-DD HH24:MI:SS')", false);
		if ($this->bangunan->delete($id_jenis_bangunan, $data)) {
			$result = array('status'  => true, 'messages' => 'Jenis bangunan dihapus');
		} else {
			$result = array('status'  => false, 'messages' => 'Jenis bangunan gagal dihapus');
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

	public function form($id)
	{
		$data['pagetitle'] = 'Form Pemeriksaan Elektromekanis';
		$data['bangunan'] = $this->elektromekanis->get_bangunan_by_nfc($id);

		$data['javascript'] = 'pemeriksaan/elektromekanis/form.js';
		$this->template->load('template', 'pemeriksaan/elektromekanis/form', $data);
	}

	public function cek_jadwal()
	{
		$payloads = $this->security->xss_clean($this->input->post());
		$periode = encrypt_url($payloads['periode']);
		$id_bangunan = encrypt_url($payloads['id_bangunan']);
		$id_peralatan = encrypt_url($payloads['id_peralatan']);
		$available = $this->elektromekanis->cek_jadwal($payloads);
		if ($available > 0) {
			$result = array('status'  => true, 'messages' => 'pemeriksaan/elektromekanis/form-input/' . $periode . '/' . $id_bangunan . '/' . $id_peralatan);
		} else {
			$result = array('status'  => false, 'messages' => 'Jadwal tidak tersedia');
		}

		echo json_encode($result);
	}

	public function form_input($periode, $id_bangunan, $id_peralatan)
	{
		$payloads['periode'] = decrypt_url($periode);
		$payloads['id_bangunan'] = decrypt_url($id_bangunan);
		$payloads['id_peralatan'] = decrypt_url($id_peralatan);

		$data['pagetitle'] = 'Form Pemeriksaan Elektromekanis';
		$data['item_periksa'] = $this->elektromekanis->get_item_periksa($payloads);
		$data['m_kriteria'] = $this->elektromekanis->get_m_kriteria();
		$data['m_metode'] = $this->elektromekanis->get_m_metode();

		$data['javascript'] = 'pemeriksaan/elektromekanis/form-input.js';
		$this->template->load('template', 'pemeriksaan/elektromekanis/form-input', $data);
	}
}
