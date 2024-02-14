<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengguna extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['kopeg'])) {
            redirect('login');
        }
        $this->load->model('Model_pengguna', 'pengguna');
		$this->load->library('form_validation');
    }

    public function index()
    {
        $data['pagetitle'] = 'Pengguna';
		$data['m_lokasi'] = $this->pengguna->get_m_lokasi();

        $data['javascript'] = 'pengguna/pengguna.js';
        $this->template->load('template', 'pengguna/pengguna', $data);
    }

    public function get_pengguna()
    {
        $list = $this->pengguna->get_data_pengguna();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ls) {
            $no++;
            $row = array();


            $row[] = '<p href="#" class="text-primary text-hover-primary mb-1">' . $ls['full_name'] . '</p><small>' . $ls['kopeg'] . '</small>';
			$row[] = '<p class="text-dark mb-0">' . $ls['nama_lokasi'] . '</p>';
			$row[] = '<p class="text-dark mb-0">' . ($ls['is_aktif'] == '1' ? 'Aktif' : 'Tidak Aktif') . '</p>';
            $row[] = '<p class="text-dark mb-0">' . relative_time(oracle_time($ls['created_at'])) . '</p><small>' . format_time(oracle_time($ls['created_at'])) . '</small>';
            $row[] = '<div class="dropdown  text-end">
                        <a class="btn btn-light btn-active-light-primary btn-sm dropdown-toggle" href="#" role="button" id="actions" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </a>    
                        <ul class="dropdown-menu" aria-labelledby="actions">
                            <li><a class="dropdown-item ubah-pengguna" href="#" data-id="' . $ls['auth_id'] . '">Ubah</a></li>
                            <li><a class="dropdown-item hapus-pengguna" href="#" data-id="' . $ls['auth_id'] . '">Hapus</a></li>
                        </ul>
                    </div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->pengguna->records_total_pengguna(),
            "recordsFiltered" => $this->pengguna->records_filter_pengguna(),
            "data" => $data,
        );
        echo json_encode($output);
    }

	function store()
	{
		$post = $this->security->xss_clean($this->input->post());
		$this->form_validation->set_rules('kopeg', 'Kode Pegawai', 'required|is_unique[tbl_auth.kopeg]', array(
			'is_unique' => '%s telah terdaftar.'
		));

		if ($this->form_validation->run() == FALSE) {
			// Validation failed, handle the errors
			$result = array('status'  => false, 'messages' => validation_errors());
		} else {
			$input = array(
				'auth_id' => last_id('tbl_auth', 'auth_id'),
				'kopeg' => $post['kopeg'],
				'full_name' => $post['nama'],
				'level_id' => $post['level'],
				'is_aktif' => 1,
				'unit_id' => $post['lokasi'],
				'created_at' => $this->timestamp(),
				'updated_at' => $this->timestamp(),
			);

			if (isset($post['is_admin']) && $post['is_admin'] == 'on') {
				$input['is_admin'] = 1;
			}

			if ($this->pengguna->store($input)) {
				$result = array('status'  => true, 'messages' => 'Pengguna baru ditambahkan');
			} else {
				$result = array('status'  => false, 'messages' => 'Pengguna gagal ditambahkan');
			}
		}
		echo json_encode($result);
	}

	function lookup()
	{
		$id_pengguna = $this->security->xss_clean($this->input->post('id_pengguna'));
		$data = $this->pengguna->lookup($id_pengguna);
		echo json_encode(
			array(
				'status' => true,
				'message' => "Berhasil menarik data dengan id $id_pengguna",
				'data' => $data
			)
		);
	}

	public function update()
	{
		$post = $this->security->xss_clean($this->input->post());
		$data = array(
			'auth_id' => $post['edit_id_pengguna'],
			'updated_at' => $this->timestamp(),
		);
		$data['is_aktif'] = 0;
		if (isset($post['edit_is_aktif']) && $post['edit_is_aktif'] == 'on') {
			$data['is_aktif'] = 1;
		}
		if ($this->pengguna->update($data)) {
			$result = array('status'  => true, 'messages' => 'Jenis peralatan diperbarui');
		} else {
			$result = array('status'  => false, 'messages' => 'Jenis peralatan gagal diperbarui');
		}

		echo json_encode($result);
	}
}
