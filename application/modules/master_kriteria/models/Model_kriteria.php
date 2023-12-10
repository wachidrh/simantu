<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_kriteria extends CI_Model
{
	var $search_m_kriteria = array('LOWER("kriteria")', 'id_kriteria');
	var $order_m_kriteria  = array('kriteria', 'updated_at');


	public function __construct()
	{
		parent::__construct();
	}

	// Get Data Asal Aktiva
	public function _get_data_m_kriteria()
	{
		$this->db
			->select('*')
			->from('m_kriteria_pemeriksaan')
			->where('is_deleted !=', 1);

		$i = 0;

		if (isset($_POST['search']) and !empty($_POST['search'])) {
			foreach ($this->search_m_kriteria as $item) {
				if (($_POST['search'])) {
					if ($i === 0) {
						$this->db->group_start();
						$this->db->like($item, $this->security->xss_clean(strtolower($this->input->post('search'))));
					} else {
						$this->db->or_like($item, $this->security->xss_clean(strtolower($this->input->post('search'))));
					}

					if (count($this->search_m_kriteria) - 1 == $i)
						$this->db->group_end();
				}
				$i++;
			}
		}
		if (isset($_POST['order'])) {
			$this->db->order_by($this->order_m_kriteria[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else {
			$order = array('id_kriteria' => 'desc');
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	public function records_filter_m_kriteria()
	{
		$this->_get_data_m_kriteria();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function records_total_m_kriteria()
	{

		$this->db
			->select('*')
			->from('m_kriteria_pemeriksaan');
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function get_data_m_kriteria()
	{
		$this->_get_data_m_kriteria();
		if ($_POST['length'] != -1) {
			$this->db->limit(10, $_POST['start']);
		}
		$query = $this->db->get();
		return $query->result_array();
	}

	public function store($input)
	{
		return $this->db->insert('m_kriteria_pemeriksaan', $input);
	}

	public function lookup($id)
	{
		return $this->db
			->get_where('m_kriteria_pemeriksaan', ['id_kriteria' => $id])
			->row_array();
	}

	public function update($data)
	{
		return $this->db
			->where('id_kriteria', $data['id_kriteria'])
			->update('m_kriteria_pemeriksaan', $data);
	}

	public function delete($ids, $data)
	{
		return $this->db
			->where_in('id_kriteria', $ids)
			->update('m_kriteria_pemeriksaan', $data);
	}
}
