<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
	function __construct()
    {
        parent::__construct();
        $this->load->model('m_basic');
        //$this->session->set_userdata('login_in', 'FALSE');
        // $this->session->sess_destroy();
    }
    function index()
    {
        
    }
	public function mahasiswa()
	{
        
        if ($this->session->login_in == FALSE) {
            $this->load->view('login_mhs');
        } else {
            redirect('mahasiswa', 'refresh');
        }
        $rand = rand(1,5);
        $pic = '';
        switch ($rand) {
            case 1:
                $pic = 'spongebob.jpg';
                break;
            case 2:
                $pic = 'patrick.jpg';
                break;
            case 3:
                $pic = 'sandy.jpg';
                break;
            case 4:
                $pic = 'crabs.jpg';
                break;
            case 5:
                $pic = 'plankton.jpg';
                break;
        }
        
        
        $login = $this->input->post('login');
		if (isset($login)) {
			$user = $this->input->post('npm');
			$pass = $this->input->post('pass');
			// check user
			$count = $this->m_basic->getNumRows('tlogin', array('npm' => $user, 'pass' => md5($pass)));
			//set date
			date_default_timezone_set("Asia/Bangkok");
			$date = new DateTime();
			$lastlogin = $date->format('Y-m-d H:i:s');
			//check device
			// if ($this->agent->is_browser())
			// {
			// 	$agent = $this->agent->platform(). ', ' .$this->agent->browser().' '.$this->agent->version();
			// }
			// elseif ($this->agent->is_robot())
			// {
			//     $agent = $this->agent->robot();
			// }
			// elseif ($this->agent->is_mobile())
			// {
		    //     $agent = $this->agent->platform(). ', ' .$this->agent->mobile();
			// }
			// else
			// {
			//     $agent = 'Unidentified User Agent';
			// }
			if ($count == 1) {
            $user_account = array (
              'login_in' => TRUE,
              'npm' => $user,
              'pic' => $pic,
              'role' => '1'
            );
            // $data = array(
            //   'last_login' => $lastlogin,
            //   'device' => $agent
            // );
            $this->session->set_userdata($user_account);
            //$this->m_basic->updateData('user', $data, array('user' => $user));
            redirect('mahasiswa', 'refresh');
				
			} else {
				$this->session->set_flashdata('error', true);
				redirect('login/mahasiswa','refresh');
			}
        }
        
        $sentEmail = $this->input->post('kirimEmail');
        if (isset($sentEmail)) {
            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'smtp.googlemail.com',
                'smtp_port' => 465,
                'smtp_user' => 'no.reply.evdos@gmail.com', // change it to yours
                'smtp_pass' => 'xdzpujqosvhjbehs', // change it to yours,
                'smtp_timeout' => '7',
                'mailtype' => 'html',
                'charset' => 'iso-8859-1',
                'wordwrap' => TRUE,
                'newline' => "\r\n"
              );
            $from_email = "no.reply.evdos@gmail.com"; 
            $to_email = $this->input->post('email'); 
            $npm = $this->input->post('npm');
            $enknpm = $this->encrypt->encode($npm);
              
            $this->load->library('email', $config);
            //$this->email->initialize($config);

            $this->email->from($from_email, 'Evaluasi Dosen Fakultas Teknik'); 
            $this->email->to($to_email);
            $this->email->subject('Reset Password'); 
            $bodyMessage = "Silahkan akses link di bawah ini untuk mengganti password anda. <br/><br/>";
            $bodyMessage .= base_url()."login/reset_password/".$enknpm;
            $bodyMessage .= "<br/><br/>Terima kasih.";
            $this->email->message($bodyMessage); 
    
            //Send mail 
            if($this->email->send()) 
                $this->session->set_flashdata("email_sent","Email sent successfully."); 
            else 
            // $this->session->set_flashdata("email_sent","Error in sending Email."); 
            // redirect($this->uri->uri_string());
            show_error($this->email->print_debugger());
        }
    }
    public function prodi()
	{
        
        if ($this->session->login_in == FALSE) {
            $this->load->view('login_prodi');
        } else {
            redirect('prodi', 'refresh');
        }
        $rand = rand(1,5);
        $pic = '';
        switch ($rand) {
            case 1:
                $pic = 'spongebob.jpg';
                break;
            case 2:
                $pic = 'patrick.jpg';
                break;
            case 3:
                $pic = 'sandy.jpg';
                break;
            case 4:
                $pic = 'crabs.jpg';
                break;
            case 5:
                $pic = 'plankton.jpg';
                break;
        }
        
        
        $login = $this->input->post('login');
		if (isset($login)) {
			$user = $this->input->post('user');
			$pass = $this->input->post('pass');
			// check user
            $count = $this->m_basic->getNumRows('fn_login', array('user' => $user, 'pass' => sha1($pass)));
            $userlogin = $this->m_basic->getAllData('fn_login', array('user' => $user))->result_array();
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
            $user_account = array (
              'login_in' => TRUE,
              'user' => $user,
              'pic' => $pic,
              'kdprodi' => $userlogin[0]['prodi'],
              'role' => '0'
            );
            $data = array(
              'last_login' => $lastlogin,
              'device' => $agent
            );
            $this->session->set_userdata($user_account);
            $this->m_basic->updateData('fn_login', $data, array('user' => $user));
            redirect('prodi', 'refresh');
				
			} else {
				$this->session->set_flashdata('error', true);
				redirect('login/prodi','refresh');
			}
		}
    }
    
    function logout($user)
    {
        $this->session->sess_destroy();
        if ($user == 'mahasiswa') {
            redirect('login/mahasiswa', 'refresh');
        } else {
            redirect('login/prodi', 'refresh');
        }
		
    }

    function reset_password($npm)
    {
        $npm = $this->encrypt->decode($npm);
        $this->load->view('reset_password');
        $kirim = $this->input->post('kirim');
        if (isset($kirim)) {
            $data = array(
                'pass' => md5($this->input->post('pass'))
            );

            $where = array('npm' => $npm);
            $this->m_basic->updateData('tlogin', $data, $where);
            $this->session->set_flashdata('update', true);
            redirect($this->uri->uri_string());
        }
    }
}