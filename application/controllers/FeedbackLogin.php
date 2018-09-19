<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FeedbackLogin extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('m_login');
	}

	function index()
	{
		
		$session = $this->session->userdata('login_in');
		$role = $this->session->userdata('role');

		// check session
		if ($session == FALSE) {
			$this->load->view('login/login_form');
		} else {
			if ($role == 0) {
				redirect('admin', 'refresh');	
			} elseif ($role == 1) {
				redirect('mahasiswa', 'refresh');
			} elseif ($role == 2) {
				redirect('dosen', 'refresh');
			} elseif ($role == 3) {
				redirect('bak', 'refresh');
			} elseif ($role == 4) {
				redirect('baa', 'refresh');
			}
		}

		$login = $this->input->post('login');

		if (isset($login)) {
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			// check user
			$count = $this->m_login->count_user($username, md5($password))->num_rows();
			$cek = $this->m_login->count_user($username, md5($password))->result_array();
			$tahun = $this->m_login->tahun_ajaran();

			//set date
			date_default_timezone_set("Asia/Bangkok");
			$date = new DateTime();
			$lastlogin = $date->format('Y-m-d H:i:s');

			//check device
			if ($this->agent->is_browser())
			{
				$agent = $this->agent->platform(). ', ' .$this->agent->browser().' '.$this->agent->version();
			}
			elseif ($this->agent->is_robot())
			{
			    $agent = $this->agent->robot();
			}
			elseif ($this->agent->is_mobile())
			{
		        $agent = $this->agent->platform(). ', ' .$this->agent->mobile();
			}
			else
			{
			    $agent = 'Unidentified User Agent';
			}

			if ($count == 1) {
				$role = $cek[0]['role'];
				$user_login = array (
						'login_in' => TRUE,
						'username' => $username,
						'pass' => $password,
						'role' => $role,
						'tahun_ajaran' => $tahun[0]['tahun_ajaran']);

				$data = array(
						'last_login' => $lastlogin,
						'device' => $agent
					);

				$this->session->set_userdata($user_login);
				$this->m_login->last_login($username, $data);
				
				if ($role == 0) {
					redirect('admin', 'refresh');	
				} elseif ($role == 1) {
					redirect('mahasiswa', 'refresh');
				} elseif ($role == 2) {
					redirect('dosen', 'refresh');
				} elseif ($role == 3) {
					redirect('bak', 'refresh');
				} elseif ($role == 4) {
					redirect('baa', 'refresh');
				}

			} else {

				$this->session->set_flashdata('error', true);
				redirect('login','refresh');

			}
		}
	
	}
	
	// function do_login()
	// {
	// 	$username = $this->input->post('username');
	// 	$password = $this->input->post('password');

	// 	// $count = $this->m_login->count_user($username, password_hash(md5($password), PASSWORD_BCRYPT))->num_rows();
	// 	// $cek = $this->m_login->count_user($username, password_hash(md5($password), PASSWORD_BCRYPT))->result_array();
	// 	$count = $this->m_login->count_user($username, md5($password))->num_rows();
	// 	$cek = $this->m_login->count_user($username, md5($password))->result_array();
	// 	$tahun = $this->m_login->tahun_ajaran();

	// 	//set date
	// 	date_default_timezone_set("Asia/Bangkok");
	// 	$date = new DateTime();
	// 	$lastlogin = $date->format('Y-m-d H:i:s');

	// 	//check device
	// 	if ($this->agent->is_browser())
	// 	{
	// 		$agent = $this->agent->platform(). ', ' .$this->agent->browser().' '.$this->agent->version();
	// 	}
	// 	elseif ($this->agent->is_robot())
	// 	{
	// 	    $agent = $this->agent->robot();
	// 	}
	// 	elseif ($this->agent->is_mobile())
	// 	{
	//         $agent = $this->agent->platform(). ', ' .$this->agent->mobile();
	// 	}
	// 	else
	// 	{
	// 	    $agent = 'Unidentified User Agent';
	// 	}

	// 	if ($count == 1) {
	// 		$role = $cek[0]['role'];
	// 		$kdprodi = $cek[0]['kode_prodi'];
	// 		$user_login = array (
	// 				'login_in' => TRUE,
	// 				'username' => $username,
	// 				'pass' => $password,
	// 				'role' => $role,
	// 				'kode_prodi' => $kdprodi,
	// 				'mhs_profil' => FALSE,
	// 				'mhs_ortu' => FALSE,
	// 				'mhs_upload' => FALSE,
	// 				'tahun_ajaran' => $tahun[0]['tahun_ajaran']);

	// 		$data = array(
	// 				'last_login' => $lastlogin,
	// 				'device' => $agent
	// 			);

	// 		$this->session->set_userdata($user_login);
	// 		$this->m_login->last_login($username, $data);
			
	// 		if ($role == 0) {
	// 			redirect('admin', 'refresh');	
	// 		} elseif ($role == 1) {
	// 			redirect('mahasiswa', 'refresh');
	// 		} elseif ($role == 2) {
	// 			redirect('dosen', 'refresh');
	// 		} elseif ($role == 3) {
	// 			redirect('operator', 'refresh');
	// 		} elseif ($role == 4) {
	// 			redirect('pimpinan', 'refresh');
	// 		}

	// 	} else {

	// 		$this->session->set_flashdata('error', true);
	// 		redirect('login','refresh');

	// 	}

	// }


	function logout()
	{
		$this->session->sess_destroy();
		redirect('login', 'refresh');
	}
}
