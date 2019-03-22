<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Prodi extends CI_Controller {
	function __construct()
    {
        parent::__construct();
        $this->load->model('m_basic');
        // $this->session->set_userdata('kdprodi','55201');
        if ($this->session->login_in == FALSE && $this->session->role !== '0') {
            redirect('login/prodi', 'refresh');
        }
    }
    function load_view($url, $data = null)
    {
        $this->load->view('kd_default/head');
        $this->load->view('kd_default/header');
        $this->load->view('kd_prodi/sidebar');
        if ($data !== null) {
            $this->load->view($url, $data);
        } else {
            $this->load->view($url);
        }
        
        $this->load->view('kd_default/footer');
    }
	function index()
	{
        $setting = $this->m_basic->getAllData('rft_konfigurasi')->result_array();
        // $dosen = $this->m_basic->getAllScore($setting[0]['kd_semester']);
        $home = array('TEKNIK SIPIL', 'TEKNIK INDUSTRI', 'TEKNIK INFORMATIKA', 'MKDU');
        // $AllSemester = $this->m_basic->getDistinctData('fn_penilaian', 'semester')->result_array();
        $AllSemester = $this->m_basic->getDistinctData('fn_jadwal', 'rft_semester')->result_array();
        //submit select semester
        $input_semester = $this->input->post('semester');
        $semester = null;
        if (!isset($input_semester)) {
            $allscore = $this->m_basic->getAllScore($setting[0]['kd_semester'], $this->session->kdprodi);
            // $industri = $this->m_basic->getAllScore($setting[0]['kd_semester'], '26201');
            // $sipil = $this->m_basic->getAllScore($setting[0]['kd_semester'], '22201');
            // $informatika = $this->m_basic->getAllScore($setting[0]['kd_semester'], '55201');
            $semester = $setting[0]['kd_semester'];
        } else {
            $allscore = $this->m_basic->getAllScore($input_semester, $this->session->kdprodi);
            // $industri = $this->m_basic->getAllScore($input_semester, '26201');
            // $sipil = $this->m_basic->getAllScore($input_semester, '22201');
            // $informatika = $this->m_basic->getAllScore($input_semester, '55201');
            $semester = $input_semester;
        }
        // $data['dosen'] = $dosen;
        $data['setting'] = $setting[0];
        $data['home'] = $home;
        $data['allSemester'] = $AllSemester;
        $data['semester'] = $semester;
        // $data['industri'] = $industri;
        // $data['sipil'] = $sipil;
        // $data['informatika'] = $informatika;
        $data['allscore'] = $allscore;
        $data['totalMhs'] = $this->m_basic->getTotalMahasiswa($this->session->kdprodi, $semester)->result_array();
        
        $this->load_view('kd_prodi/data_dosen', $data);
    }
    function detail_penilaian($nidn, $kdprodi)
    {

        $nidn = $this->encrypt->decode($nidn);
        $kdprodi = $this->encrypt->decode($kdprodi);
        $setting = $this->m_basic->getAllData('rft_konfigurasi')->result_array();
        $dosen = $this->m_basic->getAllData('dosen', array('nidn' => $nidn))->result_array();
        $AllSemester = $this->m_basic->getDistinctWhereData('fn_penilaian', 'semester', array('nidn' => $dosen[0]['NIDN']))->result_array();
        $avg = $this->m_basic->getAllAvgPerson($nidn, $kdprodi);
        
        //submit select semester
        $input_semester = $this->input->post('semester');
        $semester = null;
        if (!isset($input_semester)) {
            $matkul = $this->m_basic->getPersonScore($nidn, $setting[0]['kd_semester'], $kdprodi);
            $semester = $setting[0]['kd_semester'];
        } else {
            $matkul = $this->m_basic->getPersonScore($nidn, $input_semester, $kdprodi);
            $semester = $input_semester;
        }
        $data['dosen'] = $dosen;
        $data['setting'] = $setting[0];
        $data['matkul'] = $matkul;
        $data['allSemester'] = $AllSemester;
        $data['semester'] = $semester;
        $data['avg'] = $avg;
        $this->load_view('kd_prodi/detail_penilaian', $data);
        $this->session->set_userdata('url', $this->uri->uri_string());
    }
    function detail_uraian($nidn, $kode_matkul, $kelas, $semester)
    {
        $nidn = $this->encrypt->decode($nidn);
        $kode_matkul = $this->encrypt->decode($kode_matkul);
        $kelas = $this->encrypt->decode($kelas);
        $semester = $this->encrypt->decode($semester);
        $setting = $this->m_basic->getAllData('rft_konfigurasi')->result_array();
        $dosen = $this->m_basic->getAllData('dosen', array('nidn' => $nidn))->result_array();
        $mkul = $this->m_basic->getAllData('fn_jadwal', array('rft_kode_matakuliah' => $kode_matkul, 'rft_kelas' => $kelas))->result_array();
        $uraian = $this->m_basic->getUraianScore($nidn, $kode_matkul, $kelas, $semester);
        // $aspek = array('Kesiapan Mengajar', 'Materi Pengajaran', 'Disiplin Mengajar', 'Evaluasi Mengajar', 'Kepribadian Dosen');
        $aspek = $this->m_basic->getAllData('fn_aspek_penilaian', null, array('urutan' => 'ASC'))->result_array();
        $mhs_done = $this->m_basic->getDistinctWhereData('fn_penilaian', 'npm', array('nidn' => $nidn, 'kode_matkul' => $kode_matkul, 'kelas' => $kelas, 'semester' => $semester))->num_rows();
        $total_mhs = $this->m_basic->getTotalMhsMatkul($kode_matkul, $kelas, $semester)->num_rows();
        $data['dosen'] = $dosen;
        $data['setting'] = $setting[0];
        $data['uraian'] = $uraian;
        $data['aspek'] = $aspek;
        $data['mkul'] = $mkul;
        $data['done'] = $mhs_done;
        $data['total'] = $total_mhs;
        $this->load_view('kd_prodi/detail_uraian', $data);
    }

    function generate_jadwal()
    {
        $setting = $this->m_basic->getAllData('rft_konfigurasi')->result_array();
        $allJadwal = $this->m_basic->getAllJadwal($setting[0]['kd_semester'], $this->session->kdprodi)->result_array();
        $datajadwal = array();

        $num1 = 0;
        $num2 = 0;
        $num3 = 0;
        $num4 = 0;
        $num5 = 0;

        $num11 = $num12 = $num13 = $num13 = $num14 = $num15 = 0;
        $num21 = $num22 = $num23 = $num23 = $num24 = $num25 = 0;
        $num31 = $num32 = $num33 = $num33 = $num34 = $num35 = 0;
        $num41 = $num42 = $num43 = $num43 = $num44 = $num45 = 0;

        $smtr = substr($setting[0]['kd_semester'],-1);

        if ($smtr == '1') {
            $nosmtr = array(1,3,5,7);
        } else {
            $nosmtr = array(2,4,6,8);
        }

        if ($this->session->kdprodi == '26201' || $this->session->kdprodi == '22201') {
            for ($i=0; $i < count($allJadwal); $i++) { 
                if ($allJadwal[$i]['rft_smtr'] == $nosmtr[0]) {
                    $datajadwal[0][0][$num1]['nama'] = $allJadwal[$i]['rft_nama_matakuliah']; 
                    $datajadwal[0][0][$num1]['kode'] = $allJadwal[$i]['rft_kode_matakuliah']; 
                    $datajadwal[0][0][$num1]['dosen'] = $allJadwal[$i]['rft_nama_dosen']; 
                    $datajadwal[0][0][$num1]['hari'] = $allJadwal[$i]['rft_hari']; 
                    $datajadwal[0][0][$num1]['waktu'] = $allJadwal[$i]['rft_waktu']; 
                    $datajadwal[0][0][$num1]['ruang'] = $allJadwal[$i]['rft_ruang']; 
                    $num1++;
                }
                if ($allJadwal[$i]['rft_smtr'] == $nosmtr[1]) {
                    $datajadwal[1][0][$num2]['nama'] = $allJadwal[$i]['rft_nama_matakuliah']; 
                    $datajadwal[1][0][$num2]['kode'] = $allJadwal[$i]['rft_kode_matakuliah']; 
                    $datajadwal[1][0][$num2]['dosen'] = $allJadwal[$i]['rft_nama_dosen']; 
                    $datajadwal[1][0][$num2]['hari'] = $allJadwal[$i]['rft_hari']; 
                    $datajadwal[1][0][$num2]['waktu'] = $allJadwal[$i]['rft_waktu']; 
                    $datajadwal[1][0][$num2]['ruang'] = $allJadwal[$i]['rft_ruang']; 
                    $num2++;
                }
                if ($allJadwal[$i]['rft_smtr'] == $nosmtr[2]) {
                    $datajadwal[2][0][$num3]['nama'] = $allJadwal[$i]['rft_nama_matakuliah']; 
                    $datajadwal[2][0][$num3]['kode'] = $allJadwal[$i]['rft_kode_matakuliah']; 
                    $datajadwal[2][0][$num3]['dosen'] = $allJadwal[$i]['rft_nama_dosen']; 
                    $datajadwal[2][0][$num3]['hari'] = $allJadwal[$i]['rft_hari']; 
                    $datajadwal[2][0][$num3]['waktu'] = $allJadwal[$i]['rft_waktu']; 
                    $datajadwal[2][0][$num3]['ruang'] = $allJadwal[$i]['rft_ruang']; 
                    $num3++;
                }
                if ($allJadwal[$i]['rft_smtr'] == $nosmtr[3]) {
                    $datajadwal[3][0][$num4]['nama'] = $allJadwal[$i]['rft_nama_matakuliah']; 
                    $datajadwal[3][0][$num4]['kode'] = $allJadwal[$i]['rft_kode_matakuliah']; 
                    $datajadwal[3][0][$num4]['dosen'] = $allJadwal[$i]['rft_nama_dosen']; 
                    $datajadwal[3][0][$num4]['hari'] = $allJadwal[$i]['rft_hari']; 
                    $datajadwal[3][0][$num4]['waktu'] = $allJadwal[$i]['rft_waktu']; 
                    $datajadwal[3][0][$num4]['ruang'] = $allJadwal[$i]['rft_ruang']; 
                    $num4++;
                }
            }
        } elseif ($this->session->kdprodi == '55201') {
            
            for ($i=0; $i < count($allJadwal); $i++) { 
                
                if ($allJadwal[$i]['rft_smtr'] == $nosmtr[0]) {
                    if ($allJadwal[$i]['rft_kelas'] == 'A') {
                        $datajadwal[0][0][$num11]['nama'] = $allJadwal[$i]['rft_nama_matakuliah']; 
                        $datajadwal[0][0][$num11]['kode'] = $allJadwal[$i]['rft_kode_matakuliah']; 
                        $datajadwal[0][0][$num11]['dosen'] = $allJadwal[$i]['rft_nama_dosen']; 
                        $datajadwal[0][0][$num11]['hari'] = $allJadwal[$i]['rft_hari']; 
                        $datajadwal[0][0][$num11]['waktu'] = $allJadwal[$i]['rft_waktu']; 
                        $datajadwal[0][0][$num11]['ruang'] = $allJadwal[$i]['rft_ruang']; 
                        $num11++;
                    } elseif ($allJadwal[$i]['rft_kelas'] == 'B') {
                        $datajadwal[0][1][$num12]['nama'] = $allJadwal[$i]['rft_nama_matakuliah']; 
                        $datajadwal[0][1][$num12]['kode'] = $allJadwal[$i]['rft_kode_matakuliah']; 
                        $datajadwal[0][1][$num12]['dosen'] = $allJadwal[$i]['rft_nama_dosen']; 
                        $datajadwal[0][1][$num12]['hari'] = $allJadwal[$i]['rft_hari']; 
                        $datajadwal[0][1][$num12]['waktu'] = $allJadwal[$i]['rft_waktu']; 
                        $datajadwal[0][1][$num12]['ruang'] = $allJadwal[$i]['rft_ruang']; 
                        $num12++;
                    } elseif ($allJadwal[$i]['rft_kelas'] == 'C') {
                        $datajadwal[0][2][$num13]['nama'] = $allJadwal[$i]['rft_nama_matakuliah']; 
                        $datajadwal[0][2][$num13]['kode'] = $allJadwal[$i]['rft_kode_matakuliah']; 
                        $datajadwal[0][2][$num13]['dosen'] = $allJadwal[$i]['rft_nama_dosen']; 
                        $datajadwal[0][2][$num13]['hari'] = $allJadwal[$i]['rft_hari']; 
                        $datajadwal[0][2][$num13]['waktu'] = $allJadwal[$i]['rft_waktu']; 
                        $datajadwal[0][2][$num13]['ruang'] = $allJadwal[$i]['rft_ruang']; 
                        $num13++;
                    } elseif ($allJadwal[$i]['rft_kelas'] == 'D') {
                        $datajadwal[0][3][$num14]['nama'] = $allJadwal[$i]['rft_nama_matakuliah']; 
                        $datajadwal[0][3][$num14]['kode'] = $allJadwal[$i]['rft_kode_matakuliah']; 
                        $datajadwal[0][3][$num14]['dosen'] = $allJadwal[$i]['rft_nama_dosen']; 
                        $datajadwal[0][3][$num14]['hari'] = $allJadwal[$i]['rft_hari']; 
                        $datajadwal[0][3][$num14]['waktu'] = $allJadwal[$i]['rft_waktu']; 
                        $datajadwal[0][3][$num14]['ruang'] = $allJadwal[$i]['rft_ruang']; 
                        $num14++;
                    } elseif ($allJadwal[$i]['rft_kelas'] == 'E') {
                        $datajadwal[0][4][$num15]['nama'] = $allJadwal[$i]['rft_nama_matakuliah']; 
                        $datajadwal[0][4][$num15]['kode'] = $allJadwal[$i]['rft_kode_matakuliah']; 
                        $datajadwal[0][4][$num15]['dosen'] = $allJadwal[$i]['rft_nama_dosen']; 
                        $datajadwal[0][4][$num15]['hari'] = $allJadwal[$i]['rft_hari']; 
                        $datajadwal[0][4][$num15]['waktu'] = $allJadwal[$i]['rft_waktu']; 
                        $datajadwal[0][4][$num15]['ruang'] = $allJadwal[$i]['rft_ruang']; 
                        $num15++;
                    }
                    
                }

                if ($allJadwal[$i]['rft_smtr'] == $nosmtr[1]) {
                    if ($allJadwal[$i]['rft_kelas'] == 'A') {
                        $datajadwal[1][0][$num21]['nama'] = $allJadwal[$i]['rft_nama_matakuliah']; 
                        $datajadwal[1][0][$num21]['kode'] = $allJadwal[$i]['rft_kode_matakuliah']; 
                        $datajadwal[1][0][$num21]['dosen'] = $allJadwal[$i]['rft_nama_dosen']; 
                        $datajadwal[1][0][$num21]['hari'] = $allJadwal[$i]['rft_hari']; 
                        $datajadwal[1][0][$num21]['waktu'] = $allJadwal[$i]['rft_waktu']; 
                        $datajadwal[1][0][$num21]['ruang'] = $allJadwal[$i]['rft_ruang']; 
                        $num21++;
                    } elseif ($allJadwal[$i]['rft_kelas'] == 'B') {
                        $datajadwal[1][1][$num22]['nama'] = $allJadwal[$i]['rft_nama_matakuliah']; 
                        $datajadwal[1][1][$num22]['kode'] = $allJadwal[$i]['rft_kode_matakuliah']; 
                        $datajadwal[1][1][$num22]['dosen'] = $allJadwal[$i]['rft_nama_dosen']; 
                        $datajadwal[1][1][$num22]['hari'] = $allJadwal[$i]['rft_hari']; 
                        $datajadwal[1][1][$num22]['waktu'] = $allJadwal[$i]['rft_waktu']; 
                        $datajadwal[1][1][$num22]['ruang'] = $allJadwal[$i]['rft_ruang']; 
                        $num22++;
                    } elseif ($allJadwal[$i]['rft_kelas'] == 'C') {
                        $datajadwal[1][2][$num23]['nama'] = $allJadwal[$i]['rft_nama_matakuliah']; 
                        $datajadwal[1][2][$num23]['kode'] = $allJadwal[$i]['rft_kode_matakuliah']; 
                        $datajadwal[1][2][$num23]['dosen'] = $allJadwal[$i]['rft_nama_dosen']; 
                        $datajadwal[1][2][$num23]['hari'] = $allJadwal[$i]['rft_hari']; 
                        $datajadwal[1][2][$num23]['waktu'] = $allJadwal[$i]['rft_waktu']; 
                        $datajadwal[1][2][$num23]['ruang'] = $allJadwal[$i]['rft_ruang']; 
                        $num23++;
                    } elseif ($allJadwal[$i]['rft_kelas'] == 'D') {
                        $datajadwal[1][3][$num24]['nama'] = $allJadwal[$i]['rft_nama_matakuliah']; 
                        $datajadwal[1][3][$num24]['kode'] = $allJadwal[$i]['rft_kode_matakuliah']; 
                        $datajadwal[1][3][$num24]['dosen'] = $allJadwal[$i]['rft_nama_dosen']; 
                        $datajadwal[1][3][$num24]['hari'] = $allJadwal[$i]['rft_hari']; 
                        $datajadwal[1][3][$num24]['waktu'] = $allJadwal[$i]['rft_waktu']; 
                        $datajadwal[1][3][$num24]['ruang'] = $allJadwal[$i]['rft_ruang']; 
                        $num24++;
                    } elseif ($allJadwal[$i]['rft_kelas'] == 'E') {
                        $datajadwal[1][4][$num25]['nama'] = $allJadwal[$i]['rft_nama_matakuliah']; 
                        $datajadwal[1][4][$num25]['kode'] = $allJadwal[$i]['rft_kode_matakuliah']; 
                        $datajadwal[1][4][$num25]['dosen'] = $allJadwal[$i]['rft_nama_dosen']; 
                        $datajadwal[1][4][$num25]['hari'] = $allJadwal[$i]['rft_hari']; 
                        $datajadwal[1][4][$num25]['waktu'] = $allJadwal[$i]['rft_waktu']; 
                        $datajadwal[1][4][$num25]['ruang'] = $allJadwal[$i]['rft_ruang']; 
                        $num25++;
                    }
                }

                if ($allJadwal[$i]['rft_smtr'] == $nosmtr[2]) {
                    if ($allJadwal[$i]['rft_kelas'] == 'A') {
                        $datajadwal[2][0][$num31]['nama'] = $allJadwal[$i]['rft_nama_matakuliah']; 
                        $datajadwal[2][0][$num31]['kode'] = $allJadwal[$i]['rft_kode_matakuliah']; 
                        $datajadwal[2][0][$num31]['dosen'] = $allJadwal[$i]['rft_nama_dosen']; 
                        $datajadwal[2][0][$num31]['hari'] = $allJadwal[$i]['rft_hari']; 
                        $datajadwal[2][0][$num31]['waktu'] = $allJadwal[$i]['rft_waktu']; 
                        $datajadwal[2][0][$num31]['ruang'] = $allJadwal[$i]['rft_ruang']; 
                        $num31++;
                    } elseif ($allJadwal[$i]['rft_kelas'] == 'B') {
                        $datajadwal[2][1][$num32]['nama'] = $allJadwal[$i]['rft_nama_matakuliah']; 
                        $datajadwal[2][1][$num32]['kode'] = $allJadwal[$i]['rft_kode_matakuliah']; 
                        $datajadwal[2][1][$num32]['dosen'] = $allJadwal[$i]['rft_nama_dosen']; 
                        $datajadwal[2][1][$num32]['hari'] = $allJadwal[$i]['rft_hari']; 
                        $datajadwal[2][1][$num32]['waktu'] = $allJadwal[$i]['rft_waktu']; 
                        $datajadwal[2][1][$num32]['ruang'] = $allJadwal[$i]['rft_ruang']; 
                        $num32++;
                    } elseif ($allJadwal[$i]['rft_kelas'] == 'C') {
                        $datajadwal[2][2][$num33]['nama'] = $allJadwal[$i]['rft_nama_matakuliah']; 
                        $datajadwal[2][2][$num33]['kode'] = $allJadwal[$i]['rft_kode_matakuliah']; 
                        $datajadwal[2][2][$num33]['dosen'] = $allJadwal[$i]['rft_nama_dosen']; 
                        $datajadwal[2][2][$num33]['hari'] = $allJadwal[$i]['rft_hari']; 
                        $datajadwal[2][2][$num33]['waktu'] = $allJadwal[$i]['rft_waktu']; 
                        $datajadwal[2][2][$num33]['ruang'] = $allJadwal[$i]['rft_ruang']; 
                        $num33++;
                    } elseif ($allJadwal[$i]['rft_kelas'] == 'D') {
                        $datajadwal[2][3][$num34]['nama'] = $allJadwal[$i]['rft_nama_matakuliah']; 
                        $datajadwal[2][3][$num34]['kode'] = $allJadwal[$i]['rft_kode_matakuliah']; 
                        $datajadwal[2][3][$num34]['dosen'] = $allJadwal[$i]['rft_nama_dosen']; 
                        $datajadwal[2][3][$num34]['hari'] = $allJadwal[$i]['rft_hari']; 
                        $datajadwal[2][3][$num34]['waktu'] = $allJadwal[$i]['rft_waktu']; 
                        $datajadwal[2][3][$num34]['ruang'] = $allJadwal[$i]['rft_ruang']; 
                        $num34++;
                    } elseif ($allJadwal[$i]['rft_kelas'] == 'E') {
                        $datajadwal[2][4][$num35]['nama'] = $allJadwal[$i]['rft_nama_matakuliah']; 
                        $datajadwal[2][4][$num35]['kode'] = $allJadwal[$i]['rft_kode_matakuliah']; 
                        $datajadwal[2][4][$num35]['dosen'] = $allJadwal[$i]['rft_nama_dosen']; 
                        $datajadwal[2][4][$num35]['hari'] = $allJadwal[$i]['rft_hari']; 
                        $datajadwal[2][4][$num35]['waktu'] = $allJadwal[$i]['rft_waktu']; 
                        $datajadwal[2][4][$num35]['ruang'] = $allJadwal[$i]['rft_ruang']; 
                        $num35++;
                    }
                }

                if ($allJadwal[$i]['rft_smtr'] == $nosmtr[3]) {
                    if ($allJadwal[$i]['rft_kelas'] == 'A') {
                        $datajadwal[3][0][$num41]['nama'] = $allJadwal[$i]['rft_nama_matakuliah']; 
                        $datajadwal[3][0][$num41]['kode'] = $allJadwal[$i]['rft_kode_matakuliah']; 
                        $datajadwal[3][0][$num41]['dosen'] = $allJadwal[$i]['rft_nama_dosen']; 
                        $datajadwal[3][0][$num41]['hari'] = $allJadwal[$i]['rft_hari']; 
                        $datajadwal[3][0][$num41]['waktu'] = $allJadwal[$i]['rft_waktu']; 
                        $datajadwal[3][0][$num41]['ruang'] = $allJadwal[$i]['rft_ruang']; 
                        $num41++;
                    } elseif ($allJadwal[$i]['rft_kelas'] == 'B') {
                        $datajadwal[3][1][$num42]['nama'] = $allJadwal[$i]['rft_nama_matakuliah']; 
                        $datajadwal[3][1][$num42]['kode'] = $allJadwal[$i]['rft_kode_matakuliah']; 
                        $datajadwal[3][1][$num42]['dosen'] = $allJadwal[$i]['rft_nama_dosen']; 
                        $datajadwal[3][1][$num42]['hari'] = $allJadwal[$i]['rft_hari']; 
                        $datajadwal[3][1][$num42]['waktu'] = $allJadwal[$i]['rft_waktu']; 
                        $datajadwal[3][1][$num42]['ruang'] = $allJadwal[$i]['rft_ruang']; 
                        $num42++;
                    } elseif ($allJadwal[$i]['rft_kelas'] == 'C') {
                        $datajadwal[3][2][$num43]['nama'] = $allJadwal[$i]['rft_nama_matakuliah']; 
                        $datajadwal[3][2][$num43]['kode'] = $allJadwal[$i]['rft_kode_matakuliah']; 
                        $datajadwal[3][2][$num43]['dosen'] = $allJadwal[$i]['rft_nama_dosen']; 
                        $datajadwal[3][2][$num43]['hari'] = $allJadwal[$i]['rft_hari']; 
                        $datajadwal[3][2][$num43]['waktu'] = $allJadwal[$i]['rft_waktu']; 
                        $datajadwal[3][2][$num43]['ruang'] = $allJadwal[$i]['rft_ruang']; 
                        $num43++;
                    } elseif ($allJadwal[$i]['rft_kelas'] == 'D') {
                        $datajadwal[3][3][$num44]['nama'] = $allJadwal[$i]['rft_nama_matakuliah']; 
                        $datajadwal[3][3][$num44]['kode'] = $allJadwal[$i]['rft_kode_matakuliah']; 
                        $datajadwal[3][3][$num44]['dosen'] = $allJadwal[$i]['rft_nama_dosen']; 
                        $datajadwal[3][3][$num44]['hari'] = $allJadwal[$i]['rft_hari']; 
                        $datajadwal[3][3][$num44]['waktu'] = $allJadwal[$i]['rft_waktu']; 
                        $datajadwal[3][3][$num44]['ruang'] = $allJadwal[$i]['rft_ruang']; 
                        $num44++;
                    } elseif ($allJadwal[$i]['rft_kelas'] == 'E') {
                        $datajadwal[3][4][$num45]['nama'] = $allJadwal[$i]['rft_nama_matakuliah']; 
                        $datajadwal[3][4][$num45]['kode'] = $allJadwal[$i]['rft_kode_matakuliah']; 
                        $datajadwal[3][4][$num45]['dosen'] = $allJadwal[$i]['rft_nama_dosen']; 
                        $datajadwal[3][4][$num45]['hari'] = $allJadwal[$i]['rft_hari']; 
                        $datajadwal[3][4][$num45]['waktu'] = $allJadwal[$i]['rft_waktu']; 
                        $datajadwal[3][4][$num45]['ruang'] = $allJadwal[$i]['rft_ruang']; 
                        $num45++;
                    }
                }

            }
        }
        

        // echo "<pre>";
        // print_r($datajadwal);
        // echo "</pre>";
        

        // $data['jadwal'] = $datajadwal;
        // $data['setting'] = $setting[0];

        // $this->load_view('kd_prodi/gn_jadwal', $data);
        return $datajadwal;
    }

    function jadwal()
    {
        $setting = $this->m_basic->getAllData('rft_konfigurasi')->result_array();
        //$jadwal = $this->m_basic->getJadwal($setting[0]['kd_semester'])->result_array();
        $dosen = $this->m_basic->getAllData('dosen')->result_array();
        $kdprodi = $this->m_basic->getAllData('prodi')->result_array();
        $matkul = $this->m_basic->getAllData('rft_matakuliah', array('rft_kdprodi' => $this->session->kdprodi))->result_array();

        $datajadwal = $this->generate_jadwal();

        $data['setting'] = $setting[0];
        $data['jadwal'] = $datajadwal;
        $data['dosen'] = $dosen;
        $data['kdprodi'] = $kdprodi;
        $data['matkul'] = $matkul;
        $this->load_view('kd_prodi/jadwal', $data);

        // ADD JADWAL
        $addJadwal = $this->input->post('addJadwal');
        if (isset($addJadwal)) {
            $matkul = explode(',', $this->input->post('matakuliah'));
            $dosen = explode('-', $this->input->post('dosen'));
            $data = array(
                'rft_kode_matakuliah' => $matkul[0],
                'rft_nama_matakuliah' => $matkul[1],
                'rft_kelas' => $this->input->post('kelas'),
                'rft_nidn' => $dosen[0],
                'rft_nama_dosen' => $dosen[1],
                'rft_hari' => $this->input->post('hari'),
                'rft_waktu' => $this->input->post('waktu'),
                'rft_ruang' => $this->input->post('ruang'),
                'rft_semester' => $setting[0]['kd_semester'],
                'rft_smtr' => $matkul[2]
            );
            $this->m_basic->insertData('fn_jadwal', $data);
            $this->session->set_flashdata('success', true);
            redirect($this->uri->uri_string());
            //print_r($data);
        }
    }

    // function jadwal()
    // {
    //     $setting = $this->m_basic->getAllData('rft_konfigurasi')->result_array();
    //     $jadwal = $this->m_basic->getJadwal($setting[0]['kd_semester'])->result_array();
    //     $dosen = $this->m_basic->getAllData('dosen')->result_array();
    //     $kdprodi = $this->m_basic->getAllData('prodi')->result_array();
    //     $matkul = $this->m_basic->getAllData('rft_matakuliah', array('rft_kdprodi' => $this->session->kdprodi))->result_array();

    //     if (substr($setting[0]['kd_semester'], -1) == 1) {
    //         $if = $this->m_basic->getJadwalProdiGanjil($setting[0]['kd_semester'], '55201')->result_array();
    //         $data['if'] = $if;
    //         $si = $this->m_basic->getJadwalProdiGanjil($setting[0]['kd_semester'], '22201')->result_array();
    //         $data['si'] = $si;
    //         $ti = $this->m_basic->getJadwalProdiGanjil($setting[0]['kd_semester'], '26201')->result_array();
    //         $data['ti'] = $ti;
    //     } else {
    //         $if = $this->m_basic->getJadwalProdiGenap($setting[0]['kd_semester'], '55201')->result_array();
    //         $data['if'] = $if;
    //         $si = $this->m_basic->getJadwalProdiGenap($setting[0]['kd_semester'], '22201')->result_array();
    //         $data['si'] = $si;
    //         $ti = $this->m_basic->getJadwalProdiGenap($setting[0]['kd_semester'], '26201')->result_array();
    //         $data['ti'] = $ti;
    //     }
    //     $data['setting'] = $setting[0];
    //     $data['jadwal'] = $jadwal;
    //     $data['dosen'] = $dosen;
    //     $data['kdprodi'] = $kdprodi;
    //     $data['matkul'] = $matkul;
    //     $this->load_view('kd_prodi/jadwal', $data);

    //     // ADD JADWAL
    //     $addJadwal = $this->input->post('addJadwal');
    //     if (isset($addJadwal)) {
    //         $matkul = explode(',', $this->input->post('matakuliah'));
    //         $dosen = explode('-', $this->input->post('dosen'));
    //         $data = array(
    //             'rft_kode_matakuliah' => $matkul[0],
    //             'rft_nama_matakuliah' => $matkul[1],
    //             'rft_kelas' => $this->input->post('kelas'),
    //             'rft_nidn' => $dosen[0],
    //             'rft_nama_dosen' => $dosen[1],
    //             'rft_hari' => $this->input->post('hari'),
    //             'rft_waktu' => $this->input->post('waktu'),
    //             'rft_ruang' => $this->input->post('ruang'),
    //             'rft_semester' => $setting[0]['kd_semester'],
    //             'rft_smtr' => $matkul[2]
    //         );
    //         $this->m_basic->insertData('fn_jadwal', $data);
    //         $this->session->set_flashdata('success', true);
    //         redirect($this->uri->uri_string());
    //         //print_r($data);
    //     }
    // }
    
    function kelas()
    {
        $setting = $this->m_basic->getAllData('rft_konfigurasi')->result_array();
        $mhs = $this->m_basic->getMahasiswa($setting[0]['kd_semester'])->result_array();
        $data['mhs'] = $mhs;
        $this->load_view('kd_prodi/kelas', $data);
    }
    function detail_kelas($npm)
    {
        $npm = $this->encrypt->decode($npm);
        $setting = $this->m_basic->getAllData('rft_konfigurasi')->result_array();
        $mhs = $this->m_basic->getAllData('tlogin', array('npm' => $npm))->result_array();
        $krs = $this->m_basic->getDetailKelasMhs($npm, $setting[0]['kd_semester'])->result_array();
        $setting = $this->m_basic->getAllData('rft_konfigurasi')->result_array();
        $data['mhs'] = $mhs;
        $data['krs'] = $krs;
        $data['setting'] = $setting[0];
        $data['npm'] = $npm;
        $this->load_view('kd_prodi/detail_kelas', $data);
        $kelas = $this->input->post('kelas');
        if (isset($kelas)) {
            $data = array(
                'rft_kelas' => $this->input->post('kelas')
            );
    
            $this->m_basic->updateData('rft_tkrs', $data, array('rft_npm' => $mhs[0]['npm'], 'rft_kode_matakuliah' => $this->input->post('kdmatkul')));
            redirect($this->uri->uri_string());
        }
    }
    function kategori()
    {
        $kategori = $this->m_basic->getAllData('fn_aspek_penilaian', null, array('urutan' => 'ASC'))->result_array();
        $last = $this->m_basic->getAllData('fn_aspek_penilaian', null, array('urutan' => 'DESC'))->result_array();
        $last_value = (int)$last[0]['urutan'];
        $first_value = (int)$kategori[0]['urutan'];
        $data['kategori'] = $kategori;
        $data['first'] = $first_value;
        $data['last'] = $last_value;
        $this->load_view('kd_prodi/kategori', $data);
        // Add
        $add = $this->input->post('addKategori');
        if (isset($add)) {
            $data = array(
                'aspek_penilaian' => $this->input->post('aspek_penilaian'),
                'urutan' => $last_value+1
            );
            $this->m_basic->insertData('fn_aspek_penilaian', $data);
            redirect($this->uri->uri_string());
        }
        // edit
        $edit = $this->input->post('saveEdit');
        if (isset($edit)) {
            $data = array(
                'aspek_penilaian' => $this->input->post('aspek_penilaian')
            );
            $this->m_basic->updateData('fn_aspek_penilaian', $data, array('urutan' => $this->input->post('urutan')));
            redirect($this->uri->uri_string());
        }
        // delete
        $delete = $this->input->post('deleteKategori');
        if (isset($delete)) {
            $this->m_basic->deleteData('fn_aspek_penilaian', array('urutan' => $this->input->post('urutan')));
            redirect($this->uri->uri_string());
        }
        // down
        $down = $this->input->post('down');
        if (isset($down)) {
            $temp = (int)$this->input->post('urutan');
            $this->m_basic->updateData('fn_aspek_penilaian', array('urutan' => 0), array('aspek_penilaian' => $this->input->post('aspek_penilaian')));
            $row = $this->m_basic->getAllData('fn_aspek_penilaian', array('urutan' => $temp+1))->result_array();
            $this->m_basic->updateData('fn_aspek_penilaian', array('urutan' => (int)$row[0]['urutan']-1), array('aspek_penilaian' => $row[0]['aspek_penilaian']));
            $this->m_basic->updateData('fn_aspek_penilaian', array('urutan' => $temp+1), array('aspek_penilaian' => $this->input->post('aspek_penilaian')));
            redirect($this->uri->uri_string());
        }
        // up
        $up = $this->input->post('up');
        if (isset($up)) {
            $temp = (int)$this->input->post('urutan');
            $this->m_basic->updateData('fn_aspek_penilaian', array('urutan' => 0), array('aspek_penilaian' => $this->input->post('aspek_penilaian')));
            $row = $this->m_basic->getAllData('fn_aspek_penilaian', array('urutan' => $temp-1))->result_array();
            $this->m_basic->updateData('fn_aspek_penilaian', array('urutan' => (int)$row[0]['urutan']+1), array('aspek_penilaian' => $row[0]['aspek_penilaian']));
            $this->m_basic->updateData('fn_aspek_penilaian', array('urutan' => $temp-1), array('aspek_penilaian' => $this->input->post('aspek_penilaian')));
            redirect($this->uri->uri_string());
        }
    }
    function uraian()
    {
        $uraian = $this->m_basic->getAllData('fn_kinerja_dosen')->result_array();
        $kategori = $this->m_basic->getAllData('fn_aspek_penilaian', null, array('urutan' => 'ASC'))->result_array();
        $data['kategori'] = $kategori;
        $data['uraian'] = $uraian;
        $this->load_view('kd_prodi/uraian', $data);
        // Add
        $add = $this->input->post('addUraian');
        if (isset($add)) {
            $data = array(
                'aspek_penilaian' => $this->input->post('aspek_penilaian'),
                'uraian' => $this->input->post('uraian')
            );
            $this->m_basic->insertData('fn_kinerja_dosen', $data);
            redirect($this->uri->uri_string());
        }
        // edit
        $edit = $this->input->post('saveEdit');
        if (isset($edit)) {
            $data = array(
                'aspek_penilaian' => $this->input->post('aspek_penilaian'),
                'uraian' => $this->input->post('uraian')
            );
            $this->m_basic->updateData('fn_kinerja_dosen', $data, array('kode_kinerja' => $this->input->post('kode_kinerja')));
            redirect($this->uri->uri_string());
        }
        // delete
        $delete = $this->input->post('deleteUraian');
        if (isset($delete)) {
            $this->m_basic->deleteData('fn_kinerja_dosen', array('kode_kinerja' => $this->input->post('kode_kinerja')));
            redirect($this->uri->uri_string());
        }
    }

    function ubah_password()
    {
        $user = $this->m_basic->getAllData('fn_login', array('user' => $this->session->user))->result_array();
        $data['user'] = $user;
        $this->load_view('kd_prodi/ubah_password', $data);

        $ubahpass = $this->input->post('ubahpass');
        if (isset($ubahpass)) {
            $pass = $this->input->post('pass');
            $npass = $this->input->post('npass');
            $cpass = $this->input->post('cpass');

            if (sha1($pass) !== $user[0]['pass']) {
                $this->session->set_flashdata('wrongpass', true);
                redirect($this->uri->uri_string());
            } elseif ($npass !== $cpass) {
                $this->session->set_flashdata('wrongconfirm', true);
                redirect($this->uri->uri_string());
            } else {
                $this->m_basic->updateData('fn_login', array('pass' => sha1($npass)), array('user' => $this->session->user));
                $this->session->set_flashdata('success', true);
                redirect($this->uri->uri_string());
            }
        }
    }
    
    
}