<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_basic');
    }

    public function index()
    {
        $this->output->set_output("This is an AJAX endpoint!");
    }

    function getMatkul()
    {
        $kdprodi = $this->input->post('kdprodi');
        $matkul = $this->m_basic->getAllData('rft_matakuliah', array('rft_kdprodi' => $kdprodi, 'aktif' => 1))->result_array();

        echo json_encode($matkul);
    }

    function postKelas($npm)
    {
        $data = array(
            'rft_kelas' => $this->input->post('kelas')
        );

        $this->m_basic->updateData('rft_tkrs', $data, array('rft_npm' => $npm, 'rft_kode_matakuliah' => $this->input->post('kdmatkul')));
    }

    function setsemester($semester, $pass=null)
    {
        if ($pass == 'finsa' && $pass !== null) {
            $isYear = substr($semester,0,4);
            $isTa = $isYear.'/'.++$isYear;

            $data = array(
                'semester' => $semester,
                'rft_tahun_ajaran' => $isTa,
                'kd_semester' => $semester,
                'kd_tahun_akademik' => $isTa
            );

            $this->m_basic->updateData('rft_konfigurasi', $data, array('id' => '1'));
            redirect(base_url(), 'refresh');
        } else {
            $this->output->set_output("This is an AJAX endpoint!");
        }
        
    }

}