<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Praktikum extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        //$this->load->model('m_basic');
    }

    function load_view($url, $data = null)
    {
        // $this->input->post('head');
        // $this->input->post('navbar');
        // $this->input->post('sidebar');
        // $this->input->post($url, $data);
        // $this->input->post('footer');
    }

	public function index()
	{
		$this->load->view('praktikum/search');
	}
}
