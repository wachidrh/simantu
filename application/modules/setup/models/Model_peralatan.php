<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_peralatan extends CI_Model
{
	var $search_peralatan = array('LOWER("nama")', 'id_jenis_peralatan');
	var $order_peralatan  = array('nama', 'updated_at');


	public function __construct()
	{
		parent::__construct();
	}

	// Get Data Asal Aktiva
	public function _get_data_peralatan()
	{
		$this->db
			->select('a.id_peralatan, a.nfc_serial_number, b.nama, c.nama_bangunan, a.created_at, a.updated_at, d.nama_lokasi')
			->from('tbl_peralatan a')
			->join('m_jenis_peralatan b', 'a.id_m_jenis_peralatan = b.id_jenis_peralatan', 'left')
			->join('m_jenis_bangunan c', 'a.id_m_jenis_bangunan = c.id_jenis_bangunan', 'left')
			->join('m_lokasi d', 'a.id_m_lokasi = d.id_lokasi', 'left')
			->where('a.is_deleted !=', 1);

		$i = 0;

		if (isset($_POST['search']) and !empty($_POST['search'])) {
			foreach ($this->search_peralatan as $item) {
				if (($_POST['search'])) {
					if ($i === 0) {
						$this->db->group_start();
						$this->db->like($item, $this->security->xss_clean(strtolower($this->input->post('search'))));
					} else {
						$this->db->or_like($item, $this->security->xss_clean(strtolower($this->input->post('search'))));
					}

					if (count($this->search_peralatan) - 1 == $i)
						$this->db->group_end();
				}
				$i++;
			}
		}
		if (isset($_POST['order'])) {
			$this->db->order_by($this->order_peralatan[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else {
			$order = array('id_peralatan' => 'desc');
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	public function records_filter_peralatan()
	{
		$this->_get_data_peralatan();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function records_total_peralatan()
	{

		$this->db
			->select('*')
			->from('tbl_peralatan');
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function get_data_peralatan()
	{
		$this->_get_data_peralatan();
		if ($_POST['length'] != -1) {
			$this->db->limit(10, $_POST['start']);
		}
		$query = $this->db->get();
		return $query->result_array();
	}

	public function store($input)
	{
		return $this->db->insert('tbl_peralatan', $input);
	}

	public function lookup($id)
	{
		return $this->db
			->get_where('tbl_peralatan', ['id_peralatan' => $id])
			->row_array();
	}

	public function update($data)
	{
		return $this->db
			->where('id_peralatan', $data['id_peralatan'])
			->update('tbl_peralatan', $data);
	}

	public function delete($ids, $data)
	{
		return $this->db
			->where_in('id_peralatan', $ids)
			->update('tbl_peralatan', $data);
	}

	public function get_all_m_peralatan()
	{
		return $this->db
			->where('is_deleted !=', 1)
			->get('m_jenis_peralatan')
			->result();
	}

	public function get_all_m_bangunan()
	{
		return $this->db
			->where('is_deleted !=', 1)
			->get('m_jenis_bangunan')
			->result();
	}

	public function get_all_m_lokasi()
	{
		return $this->db
			->get('m_lokasi')
			->result();
	}
}
