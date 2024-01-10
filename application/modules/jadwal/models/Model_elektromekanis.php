<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_elektromekanis extends CI_Model
{
	var $search_m_jadwal = array('LOWER("b"."full_name")', 'LOWER("a"."created_by")', '"a"."id_jadwal"');
	var $order_m_jadwal  = array('', 'a.updated_at');


	public function __construct()
	{
		parent::__construct();
	}

	// Get Data Asal Aktiva
	public function _get_data_m_jadwal()
	{
		$this->db
			->select('a.id_jadwal, a.created_at, a.triwulan, a.tahun_jadwal, a.created_by, b.full_name')
			->from('tbl_jadwal a')
			->where('jenis_jadwal =', 1)
			->join('tbl_auth b', 'a.created_by = b.kopeg', 'left');

		$i = 0;

		if (isset($_POST['search']) and !empty($_POST['search'])) {
			foreach ($this->search_m_jadwal as $item) {
				if (($_POST['search'])) {
					if ($i === 0) {
						$this->db->group_start();
						$this->db->like($item, $this->security->xss_clean(strtolower($this->input->post('search'))));
					} else {
						$this->db->or_like($item, $this->security->xss_clean(strtolower($this->input->post('search'))));
					}

					if (count($this->search_m_jadwal) - 1 == $i)
						$this->db->group_end();
				}
				$i++;
			}
		}
		if (isset($_POST['order'])) {
			$this->db->order_by($this->order_m_jadwal[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else {
			$order = array('id_jadwal' => 'desc');
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	public function records_filter_m_jadwal()
	{
		$this->_get_data_m_jadwal();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function records_total_m_jadwal()
	{

		$this->db
			->select('*')
			->from('tbl_jadwal');
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function get_data_m_jadwal()
	{
		$this->_get_data_m_jadwal();
		if ($_POST['length'] != -1) {
			$this->db->limit(10, $_POST['start']);
		}
		$query = $this->db->get();
		return $query->result_array();
	}

	public function store($input)
	{
		$this->db->trans_start();
		$this->db->insert('tbl_jadwal', $input['insert_jadwal']);
		$id_item_jadwal = last_id('tbl_item_jadwal', 'id_item_jadwal');
		$id_tbl_approval = (int)last_id('tbl_approval', 'id_tbl_approval');
		$id_jadwal = (int)last_id('tbl_jadwal', 'id_jadwal') - 1;

		$input_penyetujuan = array(
			[
				'id_tbl_approval' => $id_tbl_approval++,
				'reference_table' => 'tbl_jadwal',
				'id_ref_table'	=> $id_jadwal,
				'approver_id' => '8702121005',
				'status' => 0
			],
			[
				'id_tbl_approval' => $id_tbl_approval,
				'reference_table' => 'tbl_jadwal',
				'id_ref_table'	=> $id_jadwal,
				'approver_id' => '8511110616',
				'status' => 0
			]
		);

		$this->db->insert_batch('tbl_approval', $input_penyetujuan);

		$input_item_jadwal = array();
		foreach ($input['data_bangunan'] as $outer) {
			foreach ($outer['repeater_peralatan'] as $peralatan) {
				foreach ($peralatan['repeater_item'] as $item) {
					switch ($item['tgl_periksa']) {
						case null:
							$item['tgl_periksa'] = '0000-00-00';
							break;
						default:
							$item['tgl_periksa'];
							break;
					}
					$input_item_jadwal[] = array(
						'id_item_jadwal' => $id_item_jadwal,
						'id_jadwal' => $id_jadwal,
						'id_jenis_bangunan' => (int)$outer['id_jenis_bangunan'],
						'id_jenis_peralatan' => (int)$peralatan['id_jenis_peralatan'],
						'id_item_peralatan' => (int)$item['id_item_peralatan'],
						'id_periode'	=> (int)$item['id_periode'],
						'tgl_periksa' => $item['tgl_periksa'],
					);
					$id_item_jadwal++;
				}
			}
		}

		$query = $this->db->insert_batch('tbl_item_jadwal', $input_item_jadwal);
		$this->db->trans_complete();

		return $query;
	}

	public function lookup($id)
	{
		$jadwal = $this->db
			->select('a.id_jadwal, a.created_at, a.triwulan, a.tahun_jadwal, a.created_by, b.nama_lokasi')
			->from('tbl_jadwal a')
			->where('a.id_jadwal =', $id)
			->join('m_lokasi b', 'a.m_lokasi_id = b.id_lokasi', 'left')
			->get()
			->row_array();

		$jadwal['bulan_triwulan'] = $this->db
			->select('bulan, nomor_bulan')
			->from('m_triwulan')
			->where('triwulan', $jadwal['triwulan'])
			->get()
			->result_array();

		$jadwal['penyetuju'] = $this->db
			->from('tbl_approval')
			->where('reference_table =', 'tbl_jadwal')
			->where('id_ref_table =', (int)$jadwal['id_jadwal'])
			->get()
			->result_array();

		$jadwal['item_jadwal'] = $this->db
			->select('a.id_item_jadwal, a.id_jadwal, a.id_jenis_bangunan, b.nama_bangunan, a.id_jenis_peralatan, d.nama, a.id_item_peralatan, e.nama_item, a.id_periode, c.periode, a.tgl_periksa')
			->from('tbl_item_jadwal a')
			->join('m_jenis_bangunan b', 'a.id_jenis_bangunan = b.id_jenis_bangunan', 'left')
			->join('m_periode c', 'a.id_periode = c.id_periode', 'left')
			->join('m_jenis_peralatan d', 'a.id_jenis_peralatan = d.id_jenis_peralatan', 'left')
			->join('m_item_peralatan e', 'a.id_item_peralatan = e.id_item_peralatan', 'left')
			->where('a.id_jadwal =', (int)$jadwal['id_jadwal'])
			->get()
			->result_array();

		return $jadwal;
	}

	public function update($data)
	{
		return $this->db
			->where('id_jenis_bangunan', $data['id_jenis_bangunan'])
			->update('m_jenis_bangunan', $data);
	}

	public function delete($ids, $data)
	{
		return $this->db
			->where_in('id_jenis_bangunan', $ids)
			->update('m_jenis_bangunan', $data);
	}

	public function get_all_m_peralatan()
	{
		return $this->db
			->where('is_deleted !=', 1)
			->order_by('nama', 'asc')
			->get('m_jenis_peralatan')
			->result();
	}

	public function get_all_m_item_peralatan()
	{
		return $this->db
			->where('is_deleted !=', 1)
			->order_by('nama_item', 'asc')
			->get('m_item_peralatan')
			->result();
	}

	public function get_all_m_periode()
	{
		return $this->db
			->get('m_periode')
			->result();
	}

	public function get_all_m_bangunan()
	{
		return $this->db
			->where('is_deleted !=', 1)
			->order_by('nama_bangunan', 'asc')
			->get('m_jenis_bangunan')
			->result();
	}

	public function get_lokasi_by_id($id)
	{
		return $this->db
			->where('id_lokasi', $id)
			->get('m_lokasi')
			->row_array();
	}

	public function approve($id_jadwal, $data)
	{
		return $this->db
			->where('reference_table =', 'tbl_jadwal')
			->where('id_ref_table =', $id_jadwal)
			->where('approver_id =', $_SESSION['kopeg'])
			->update('tbl_approval', $data);
	}
}
