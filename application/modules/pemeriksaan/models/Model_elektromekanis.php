<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_elektromekanis extends CI_Model
{
	var $search_periksa = array('LOWER("b"."full_name")', 'LOWER("a"."created_by")', '"c"."nama_lokasi"');
	var $order_m_jadwal  = array('', 'a.updated_at');


	public function __construct()
	{
		parent::__construct();
	}

	// Get Data Asal Aktiva
	public function _get_data_periksa_el()
	{
		$this->db
			->select('a.id_periksa, a.created_at, a.created_by, b.full_name, c.nama_lokasi, d.periode')
			->from('tbl_periksa_elektromekanis a')
			->join('tbl_auth b', 'a.created_by = b.kopeg', 'left')
			->join('m_lokasi c', 'a.m_lokasi_id = c.id_lokasi', 'left')
			->join('m_periode d', 'a.id_periode = d.id_periode', 'left');

		$i = 0;

		if (isset($_POST['search']) and !empty($_POST['search'])) {
			foreach ($this->search_periksa as $item) {
				if (($_POST['search'])) {
					if ($i === 0) {
						$this->db->group_start();
						$this->db->like($item, $this->security->xss_clean(strtolower($this->input->post('search'))));
					} else {
						$this->db->or_like($item, $this->security->xss_clean(strtolower($this->input->post('search'))));
					}

					if (count($this->search_periksa) - 1 == $i)
						$this->db->group_end();
				}
				$i++;
			}
		}
		if (isset($_POST['order'])) {
			$this->db->order_by($this->order_periksa[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else {
			$order = array('id_periksa' => 'desc');
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	public function records_filter_periksa_el()
	{
		$this->_get_data_periksa_el();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function records_total_periksa_el()
	{

		$this->db
			->select('*')
			->from('tbl_periksa_elektromekanis');
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function get_data_periksa_el()
	{
		$this->_get_data_periksa_el();
		if ($_POST['length'] != -1) {
			$this->db->limit(10, $_POST['start']);
		}
		$query = $this->db->get();
		return $query->result_array();
	}

	public function store($input)
	{
		$this->db->trans_start();
		$this->db->insert('tbl_periksa_elektromekanis', $input['insert_periksa']);
		$id_item = last_id('tbl_item_periksa_el', 'id_item_periksa');
		$id_tbl_approval = (int)last_id('tbl_approval', 'id_tbl_approval');
		$id_periksa = (int)last_id('tbl_periksa_elektromekanis', 'id_periksa') - 1;

		$input_penyetujuan = array(
			[
				'id_tbl_approval' => $id_tbl_approval++,
				'reference_table' => 'tbl_periksa_elektromekanis',
				'id_ref_table'	=> $id_periksa,
				'approver_id' => '8702121005',
				'status' => 0
			],
			[
				'id_tbl_approval' => $id_tbl_approval,
				'reference_table' => 'tbl_periksa_elektromekanis',
				'id_ref_table'	=> $id_periksa,
				'approver_id' => '8511110616',
				'status' => 0
			]
		);

		$this->db->insert_batch('tbl_approval', $input_penyetujuan);
		$ib = $input['data_bangunan'];
		$input_item = array();
		for ($i=0; $i < sizeof($input['data_bangunan']['id_item_peralatan']); $i++) { 
			$input_item[] = array(
				'id_item_periksa' => $id_item,
				'id_periksa' => $id_periksa,
				'id_jenis_bangunan' => (int)$ib['id_jenis_bangunan'],
				'id_jenis_peralatan' => (int)$ib['id_jenis_peralatan'],
				'id_item_peralatan' => (int)$ib['id_item_peralatan'][$i],
				'id_kriteria' => (int)$ib['id_kriteria'][$i],
				'id_metode' => (int)$ib['id_metode'][$i],
				'hasil_periksa' => $ib['hasil_periksa'][$i],
				'catatan' => $ib['catatan'][$i]
			);
			$id_item++;
		}

		$query = $this->db->insert_batch('tbl_item_periksa_el', $input_item);
		$this->db->trans_complete();

		return $query;
	}

	public function get_bangunan_by_nfc($id)
	{
		$data['bangunan'] = $this->db
		->select('a.id_peralatan, a.id_m_jenis_bangunan, a.id_m_jenis_peralatan, b.nama as nama_peralatan, c.nama_bangunan, d.nama_lokasi')
		->from('tbl_peralatan a')
		->join('m_jenis_peralatan b', 'a.id_m_jenis_peralatan = b.id_jenis_peralatan', 'left')
		->join('m_jenis_bangunan c', 'a.id_m_jenis_bangunan = c.id_jenis_bangunan', 'left')
		->join('m_lokasi d', 'a.id_m_lokasi = d.id_lokasi', 'left')
		->where('a.nfc_serial_number', $id)
		->get()
		->row_array();
		// $data['item_pemeriksaan'] = $this->db
		// 	->get_where(
		// 		'tbl_item_jadwal',
		// 		[
		// 			'id_jenis_bangunan' => $data['bangunan']['id_m_jenis_bangunan'],
		// 			'tgl_periksa_start' => date('Y-m-d').' 00:00:00.000'
		// 		]
		// 	)
		// 	->result_array();

		// if (sizeof($data['item_pemeriksaan']) == 0) {
		// 	$data['item_pemeriksaan'] = $this->db
		// 		->get_where(
		// 			'tbl_item_jadwal',
		// 			[
		// 				'id_jenis_bangunan' => $data['bangunan']['id_m_jenis_bangunan'],
		// 				'tgl_setiap_bulan' => date('d')
		// 			]
		// 		)
		// 		->result_array();
		// }

		// if (sizeof($data['item_pemeriksaan']) == 0) {
		// 	$data['item_pemeriksaan'] = $this->db
		// 		->get_where(
		// 			'tbl_item_jadwal',
		// 			[
		// 				'id_jenis_bangunan' => $data['bangunan']['id_m_jenis_bangunan'],
		// 				'tgl_setiap_bulan' => date('d')
		// 			]
		// 		)
		// 		->result_array();
		// }

		// if (sizeof($data['item_pemeriksaan']) == 0) {
		// 	$data['item_pemeriksaan'] = $this->db
		// 		->get_where(
		// 			'tbl_item_jadwal',
		// 			[
		// 				'id_jenis_bangunan' => $data['bangunan']['id_m_jenis_bangunan'],
		// 				'hari_setiap_minggu' => date('D')
		// 			]
		// 		)
		// 		->result_array();
		// }

		// if (sizeof($data['item_pemeriksaan']) == 0) {
		// 	$data['item_pemeriksaan'] = $this->db
		// 		->select('a.id_item_jadwal, a.id_jadwal, a.id_jenis_bangunan, b.nama_bangunan, a.id_jenis_peralatan, d.nama, a.id_item_peralatan, e.nama_item, a.id_periode, c.periode, a.tgl_periksa_start')
		// 		->join('m_jenis_bangunan b', 'a.id_jenis_bangunan = b.id_jenis_bangunan', 'left')
		// 		->join('m_periode c', 'a.id_periode = c.id_periode', 'left')
		// 		->join('m_jenis_peralatan d', 'a.id_jenis_peralatan = d.id_jenis_peralatan', 'left')
		// 		->join('m_item_peralatan e', 'a.id_item_peralatan = e.id_item_peralatan', 'left')
		// 		->order_by('a.id_item_jadwal', 'asc')
		// 		->get_where(
		// 			'tbl_item_jadwal a',
		// 			[
		// 				'a.id_jenis_bangunan' => $data['bangunan']['id_m_jenis_bangunan'],
		// 				'a.id_periode' => "2" //SH
		// 			]
		// 		)
		// 		->result_array();
		// }
		return $data;
	}

	public function get_jadwal()
	{
		return $this->db
			->where('is_deleted !=', 1)
			->get('m_jadwal_pemeriksaan')
			->result_array();
	}

	public function get_m_kriteria()
	{
		return $this->db
			->where('is_deleted !=', 1)
			->get('m_kriteria_pemeriksaan')
			->result_array();
	}

	public function get_m_metode()
	{
		return $this->db
			->where('is_deleted !=', 1)
			->get('m_metode_pemeriksaan')
			->result_array();
	}

	public function lookup($id)
	{
		$periksa = $this->db
			->select('a.id_periksa, a.created_at, a.created_by, b.nama_lokasi, keterangan_periode')
			->from('tbl_periksa_elektromekanis a')
			->where('a.id_periksa =', $id)
			->join('m_lokasi b', 'a.m_lokasi_id = b.id_lokasi', 'left')
			->join('m_periode c', 'a.id_periode = c.id_periode', 'left')
			->get()
			->row_array();

		$periksa['penyetuju'] = $this->db
			->from('tbl_approval')
			->where('reference_table =', 'tbl_periksa_elektromekanis')
			->where('id_ref_table =', (int)$periksa['id_periksa'])
			->get()
			->result_array();

		$periksa['item_periksa'] = $this->db
			->select('a.id_item_periksa, a.id_periksa, a.id_jenis_bangunan, b.nama_bangunan, a.id_jenis_peralatan, d.nama, a.id_item_peralatan, e.nama_item, c.kriteria, f.metode, a.hasil_periksa, a.catatan')
			->from('tbl_item_periksa_el a')
			->join('m_jenis_bangunan b', 'a.id_jenis_bangunan = b.id_jenis_bangunan', 'left')
			->join('m_kriteria_pemeriksaan c', 'a.id_kriteria = c.id_kriteria', 'left')
			->join('m_jenis_peralatan d', 'a.id_jenis_peralatan = d.id_jenis_peralatan', 'left')
			->join('m_item_peralatan e', 'a.id_item_peralatan = e.id_item_peralatan', 'left')
			->join('m_metode_pemeriksaan f', 'a.id_metode = f.id_metode', 'left')
			->where('a.id_periksa =', (int)$periksa['id_periksa'])
			->order_by('a.id_item_periksa', 'asc')
			->get()
			->result_array();

		return $periksa;
	}

	public function cek_jadwal($payloads, $jenis_jadwal = 1)
	{
		$result = $this->db
			->join('tbl_jadwal b', 'a.id_jadwal = b.id_jadwal', 'left')
			->join('m_triwulan c', 'b.triwulan = c.triwulan', 'left')
			->where('a.id_jenis_bangunan', $payloads['id_bangunan'])
			->where('a.id_jenis_peralatan', $payloads['id_peralatan'])
			->where('a.id_periode', $payloads['periode'])
			->where('a.jenis_jadwal', $jenis_jadwal)
			->where('b.tahun_jadwal', date('Y'))
			->where('c.nomor_bulan', (int)date('m'))
			->from('tbl_item_jadwal a');
			
		$result = $result->get()
			->num_rows();
		
		return $result;
	}

	public function get_item_periksa($payloads, $jenis_jadwal = 1)
	{
		$result = $this->db
			->select('a.id_item_jadwal, a.id_jenis_bangunan, b.nama_bangunan, a.id_jenis_peralatan, d.nama, a.id_item_peralatan, e.nama_item, c.kriteria, f.metode, a.id_periode, a.id_kriteria, a.id_metode_pemeriksaan')
			->join('m_jenis_bangunan b', 'a.id_jenis_bangunan = b.id_jenis_bangunan', 'left')
			->join('m_kriteria_pemeriksaan c', 'a.id_kriteria = c.id_kriteria', 'left')
			->join('m_jenis_peralatan d', 'a.id_jenis_peralatan = d.id_jenis_peralatan', 'left')
			->join('m_item_peralatan e', 'a.id_item_peralatan = e.id_item_peralatan', 'left')
			->join('m_metode_pemeriksaan f', 'a.id_metode_pemeriksaan = f.id_metode', 'left')
			->join('tbl_jadwal g', 'a.id_jadwal = g.id_jadwal', 'left')
			->join('m_triwulan h', 'g.triwulan = g.triwulan', 'left')
			->where('a.id_jenis_bangunan', $payloads['id_bangunan'])
			->where('a.id_jenis_peralatan', $payloads['id_peralatan'])
			->where('a.id_periode', $payloads['periode'])
			->where('a.jenis_jadwal', $jenis_jadwal)
			->where('g.tahun_jadwal', date('Y'))
			->where('h.nomor_bulan', (int)date('m'))
			->from('tbl_item_jadwal a');
			
		$result = $result->get()
			->result_array();
		
		return $result;
	}
}
