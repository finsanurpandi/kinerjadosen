<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FeedbackAjax extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_feedback');
    }

    public function index()
    {
        $this->output->set_output("This is an AJAX endpoint!");
    }

    function checkNpm()
    {
        $npm = $this->input->post('npm');

        $row = $this->m_feedback->getAllData('ace_alumni', array('npm' => $npm))->num_rows();

        echo $row;
    }

    function getPerusahaan()
    {
        $kd_perusahaan = $this->input->post('kd_perusahaan');
        $data = $this->m_feedback->getAllData('ace_perusahaan', array('kd_perusahaan' => $kd_perusahaan))->result_array();
        echo json_encode($data);
    }

    function getAlumni()
    {
        $npm = $this->input->post('npm');
        $data = $this->m_feedback->getAllData('ace_alumni', array('npm' => $npm))->result_array();
        echo json_encode($data);
    }

}