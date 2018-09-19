<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('m_basic');

        $this->session->set_userdata('pic', 'plankton.jpg');
        $this->session->set_userdata('npm', '5520116003');
        $this->session->set_userdata('login_in', 'TRUE');

        // if ($this->session->login_in == FALSE) {
        //     redirect('login/mahasiswa', 'refresh');
        // }
    }

    function load_view($url, $data = null)
    {
        $this->load->view('kd_default/head');
        $this->load->view('kd_mahasiswa/header', $data);
        $this->load->view('kd_mahasiswa/sidebar', $data);

        if ($data !== null) {
            $this->load->view($url, $data);
        } else {
            $this->load->view($url);
        }
        
        $this->load->view('kd_default/footer');
    }

    function check_login()
    {
        if ($this->session->login_in == FALSE) {
            redirect('login/mahasiswa', 'refresh');
        }
    }

	function index()
	{
        //$this->session->set_userdata('npm', '000');
        
        //add npm
        $npm = $this->input->post('npm');
        if(isset($npm))
        {
            $this->session->set_userdata('npm', $npm);
        } 
        
        $this->check_login();

        $setting = $this->m_basic->getAllData('rft_konfigurasi')->result_array();
        $krs = $this->m_basic->getKrs($this->session->npm, $setting[0]['kd_semester']);
        $penilaian = $this->m_basic->getDistinctWhereData('fn_penilaian', 'kode_matkul', array('semester' => $setting[0]['kd_semester'], 'npm' => sha1($this->session->npm)))->result_array();
        $mhs_nilai = $this->m_basic->getAllData('fn_status_penilaian', array('npm' => $this->session->npm))->num_rows();
        $mhs = $this->m_basic->getAllData('tlogin', array('npm' => $this->session->npm))->result_array();
        $kelas = $this->m_basic->checkKelas($this->session->npm, $setting[0]['kd_semester'])->result_array();
        $matakuliah = $this->m_basic->getMatakuliahKrs($this->session->npm, $setting[0]['kd_semester'])->result_array();
        // $count = 8;

        // print_r($kelas);

        // print_r($krs);

        $data['krs'] = $krs;
        $data['setting'] = $setting[0];
        $data['penilaian'] = $penilaian;
        $data['mhs'] = $mhs[0];
        $data['kelas'] = $kelas;
        $data['matakuliah'] = $matakuliah;

        if ( count($penilaian) == count($krs) && $mhs_nilai == 0) {
            $input = array(
                'npm' => $this->session->npm,
                'semester' => $setting[0]['kd_semester'],
                'status' => 1
            );

            $this->m_basic->insertData('fn_status_penilaian', $input);
        }

        $this->load_view('kd_mahasiswa/data_mahasiswa', $data);

        // add class
        $addclass = $this->input->post('addClass');
        if (isset($addclass)) {

            for ($i=0; $i < count($this->input->post('kelas')); $i++) { 
                $nilai[$i] = array(
                    'id' => $this->input->post('id')[$i],
                    'rft_kelas' => $this->input->post('kelas')[$i]
                );
            }

            //print_r($nilai);

            $this->m_basic->updateAll('rft_tkrs', $nilai, 'id');

            redirect('mahasiswa', 'refresh');
        }

        
    }
    
    function penilaian($npm, $kode_matkul, $nidn, $kelas, $kode_jadwal)
    {
        //$this->session->set_userdata('npm', '5520116109');

        $npm = $this->encrypt->decode($npm);
        $kode_matkul = $this->encrypt->decode($kode_matkul);
        $nidn = $this->encrypt->decode($nidn);
        $kelas = $this->encrypt->decode($kelas);
        $kode_jadwal = $this->encrypt->decode($kode_jadwal);

        $setting = $this->m_basic->getAllData('rft_konfigurasi')->result_array();
        $uraian = $this->m_basic->getAllData('fn_kinerja_dosen', null, array('kode_kinerja' => 'ASC'))->result_array();
        // $aspek = array('Kesiapan Mengajar', 'Materi Pengajaran', 'Disiplin Mengajar', 'Evaluasi Mengajar', 'Kepribadian Dosen');
        $aspek = $this->m_basic->getAllData('fn_aspek_penilaian', null, array('urutan' => 'ASC'))->result_array();
        $mhs = $this->m_basic->getAllData('tlogin', array('npm' => $npm))->result_array();
        $dosen = $this->m_basic->getAllData('dosen', array('nidn' => $nidn))->result_array();
        $mkul = $this->m_basic->getAllData('rft_matakuliah', array('rft_kode_matakuliah' => $kode_matkul))->result_array();
        $check = $this->m_basic->getAllData('fn_penilaian', array('npm' => sha1($npm), 'kode_matkul' => $kode_matkul, 'nidn' => $nidn))->num_rows();
        
        $data['uraian'] = $uraian;
        $data['aspek'] = $aspek;
        $data['setting'] = $setting[0];
        $data['mhs'] = $mhs[0];
        $data['dosen'] = $dosen[0];
        $data['mkul'] = $mkul[0];
        $data['check'] = $check;

        $this->load_view('kd_mahasiswa/penilaian', $data);

        $kdprodi = '';

        if (substr($kode_matkul, 0,2) == 'IF') {
            $kdprodi = '55201';
        } elseif (substr($kode_matkul, 0,2) == 'SI') {
            $kdprodi = '22201';
        } elseif (substr($kode_matkul, 0,2) == 'TI') {
            $kdprodi = '26201';
        }

        // Add penilaian
        $penilaian = $this->input->post('sbmtPenilaian');

        if (isset($penilaian)) {
            for ($i=0; $i < count($this->input->post('nilai')); $i++) { 
                $penilaian[$i] = array(
                    'npm' => sha1($npm),
                    'kdprodi' => $kdprodi,
                    'kode_matkul' => $kode_matkul,
                    'kode_jadwal' => $kode_jadwal,
                    'kelas' => $kelas,
                    'nidn' => $nidn,
                    'kode_kinerja' => $this->input->post('kode_kinerja')[$i],
                    'semester' => $setting[0]['kd_semester'],
                    'nilai' => $this->input->post('nilai')[$i]
                );
            }

            // $catatan = array(
            //     'npm' => sha1($npm),
            //     'kode_matkul' => $kode_matkul,
            //     'kelas' => $kelas,
            //     'nidn' => $nidn,
            //     'semester' => $setting[0]['kd_semester'],
            //     'catatan' => $this->input->post('catatan')
            // );

            // if (empty($this->input->post('catatan'))) {
            //     $this->m_basic->insertAllData('penilaian', $penilaian);
            // } else {
            //     $this->m_basic->insertMultiple('penilaian', $penilaian, 'catatan_penilaian', $catatan);
            // }

            $this->m_basic->insertAllData('fn_penilaian', $penilaian);
            
            redirect('mahasiswa', 'refresh');
            
            
        }
    }

    function hasil_penilaian()
	{
        $this->load_view('kd_mahasiswa/hasil_penilaian');
    }
}
