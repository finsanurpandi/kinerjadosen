<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FeedbackPerusahaan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_feedback');
    }

    public function index()
    {
        
    }


}