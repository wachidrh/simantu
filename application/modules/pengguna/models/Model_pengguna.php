<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_pengguna extends CI_Model
{
    var $search_pengguna = array('LOWER("kopeg")', 'LOWER("full_name")');
    var $order_pengguna  = array('', 'created_at');


    public function __construct()
    {
        parent::__construct();
    }

    // Get Data Asal Aktiva
    public function _get_data_pengguna()
    {
		$this->db->select('a.*, b.nama_lokasi');
		$this->db->join('m_lokasi b', 'a.unit_id = b.id_lokasi', 'left');
		$this->db->from('tbl_auth a');

        $i = 0;

        if (isset($_POST['search']) and !empty($_POST['search'])) {
            foreach ($this->search_pengguna as $item) {
                if (($_POST['search'])) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, $this->security->xss_clean(strtolower($this->input->post('search'))));
                    } else {
                        $this->db->or_like($item, $this->security->xss_clean(strtolower($this->input->post('search'))));
                    }

                    if (count($this->search_pengguna) - 1 == $i)
                        $this->db->group_end();
                }
                $i++;
            }
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_pengguna[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $order = array('auth_id' => 'desc');
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function records_filter_pengguna()
    {
        $this->_get_data_pengguna();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function records_total_pengguna()
    {

        $this->db->select('*');
        $this->db->from('tbl_auth');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_data_pengguna()
    {
        $this->_get_data_pengguna();
        if ($_POST['length'] != -1) {
            $this->db->limit(10, $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

	function get_m_lokasi()
	{
		$this->db->select('*');
		$this->db->from('m_lokasi');
		$query = $this->db->get();
		return $query->result_array();
	}

	function store($input)
	{
		return $this->db->insert('tbl_auth', $input);
	}

	function lookup($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_auth');
		$this->db->where('auth_id', $id);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function update($data)
	{
		return $this->db
		->where('auth_id', $data['auth_id'])
		->update('tbl_auth', $data);
	}
}
