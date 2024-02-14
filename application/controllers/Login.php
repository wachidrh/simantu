<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_login', 'login');
	}

	public function index()
	{
		if (isset($_SESSION['kopeg'])) {
			redirect('dashboard');
		}

		$recaptcha = $this->recaptcha->create_box();
		$this->load->view('login', ['recaptcha' => $recaptcha]);
	}

	public function submit()
	{
		$kopeg = $this->security->xss_clean(strtolower($this->input->post('kopeg')));
		$password =  $this->security->xss_clean($this->input->post('password'));
		$remember_me = isset($_POST['remember-me']) ? true : false;

		if (!empty($kopeg) && !empty($password)) {
			$is_valid = $this->recaptcha->is_valid();
			if ($is_valid['success']) {
				$api_url = HADIR_API . 'login';
				$token = $this->config->item('hadir_token');
				$post_data = array(
					'kopeg' => $kopeg,
					'password' => $password
				);

				$ch = curl_init($api_url);

				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Bearer:' . $token
				));
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));

				$response = curl_exec($ch);

				if ($response === false) {
					$result = array('status'  => false, 'messages' => 'cURL error: ' . curl_error($ch));
				} else {
					if ($remember_me) {
						$cookie_data = [
							'name' => 'remember_me',
							'value' => '1',
							'expire' => 604800, // 7 days in seconds
						];
						$this->input->set_cookie($cookie_data);
					}

					$pegawai = json_decode($response, true);
					if ($pegawai['status'] == false) {
						$result = array('status'  => false, 'messages' => 'Periksa kembali kode pegawai & kata sandi Anda.');
					} else {
						if ($pegawai['data']['personal_data']['flag'] == 1) {
							$result = array('status'  => true, 'messages' => 'Login berhasil. Anda akan diarahkan ke Dashboard.');

							$update_data = [
								'email' => $pegawai['data']['personal_data']['email'],
								'full_name' => $pegawai['data']['personal_data']['full_name'],
							];

							$this->db->update('tbl_auth', $update_data, ['kopeg' => $pegawai['data']['personal_data']['kopeg']]);

							$query = $this->db->query('SELECT * FROM "tbl_auth" WHERE "kopeg" = ? AND "is_aktif" = 1', array($pegawai['data']['personal_data']['kopeg']));
							$auth = $query->result_array();

							if (sizeof($auth) == 0) {
								echo json_encode(
									array(
										'status'  => 'blocked',
										'messages' => 'Akun anda belum terdaftar di aplikasi Simantu. Silahkan hubungi administrator.'
									)
								);
								exit();
							}

							$session = [
								'active_auth' => $auth[0]
							];
							$this->session->set_userdata($pegawai['data']['personal_data']);
							$this->session->set_userdata($session);
						} else {
							$result = array('status' => 'blocked', 'messages' => 'Akun Anda telah di non-aktifkan.');
						}
					}
				}
				curl_close($ch);
			} else {
				$result = array('status'  => 'captcha', 'messages' => 'Captcha belum sesuai.');
			}
		}
		echo json_encode($result);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		delete_cookie('remember_me');
		redirect();
	}
}
