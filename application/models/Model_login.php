<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_login extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function auth($kopeg, $password)
    {
        $this->db->select('*');
        $this->db->from('tbl_auth');
        $this->db->where('LOWER("kopeg")', $kopeg);
        $query = $this->db->get();
        $hasil = $query->row_array();

        if ($query->num_rows() > 0) {
            if (password_verify($password, $hasil['password'])) {
                goto success;
            } else {
                return false;
            }

            success:
            if ($hasil['flag'] == 1) {
                $this->session->set_userdata($hasil);
                return 'success';
            } else {
                return 'blocked';
            }
        } else {
            return false;
        }
    }
}
