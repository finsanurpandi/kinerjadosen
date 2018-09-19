<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prodi extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('m_basic');
        // $this->session->set_userdata('kdprodi','55201');

        if ($this->session->login_in == FALSE) {
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

    function jadwal()
    {
        $setting = $this->m_basic->getAllData('rft_konfigurasi')->result_array();
        $jadwal = $this->m_basic->getJadwal($setting[0]['kd_semester'])->result_array();
        $dosen = $this->m_basic->getAllData('dosen')->result_array();
        $kdprodi = $this->m_basic->getAllData('prodi')->result_array();

        // print_r($jadwal);

        if (substr($setting[0]['kd_semester'], -1) == 1) {
            $if = $this->m_basic->getJadwalProdiGanjil($setting[0]['kd_semester'], '55201')->result_array();
            $data['if'] = $if;
            $si = $this->m_basic->getJadwalProdiGanjil($setting[0]['kd_semester'], '22201')->result_array();
            $data['si'] = $si;
            $ti = $this->m_basic->getJadwalProdiGanjil($setting[0]['kd_semester'], '26201')->result_array();
            $data['ti'] = $ti;
        } else {
            $if = $this->m_basic->getJadwalProdiGenap($setting[0]['kd_semester'], '55201')->result_array();
            $data['if'] = $if;
            $si = $this->m_basic->getJadwalProdiGenap($setting[0]['kd_semester'], '22201')->result_array();
            $data['si'] = $si;
            $ti = $this->m_basic->getJadwalProdiGenap($setting[0]['kd_semester'], '26201')->result_array();
            $data['ti'] = $ti;
        }

        $data['setting'] = $setting[0];
        $data['jadwal'] = $jadwal;
        $data['dosen'] = $dosen;
        $data['kdprodi'] = $kdprodi;

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
        }
    }

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

        $mhs = $this->m_basic->getAllData('tlogin', array('npm' => $npm))->result_array();
        $krs = $this->m_basic->getDetailKelasMhs($npm)->result_array();
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
    
    
}
