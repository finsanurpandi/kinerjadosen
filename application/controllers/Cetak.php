<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cetak extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('m_basic');
    }

    public function index()
    {
        $this->output->set_output("This is an AJAX endpoint!");
    }

    function cetak_penilaian($nidn, $kode_matkul, $kelas, $semester)
    {
        $nidn = $this->encrypt->decode($nidn);
        $kode_matkul = $this->encrypt->decode($kode_matkul);
        $kelas = $this->encrypt->decode($kelas);
        $semester = $this->encrypt->decode($semester);

        $kdprodi = substr($kode_matkul, 0,2);

        if ($kdprodi == 'IF') {
            $kdprodi = '55201';
        } elseif ($kdprodi == 'TI') {
            $kdprodi = '26201';
        } elseif ($kdprodi == 'SI') {
            $kdprodi = '22201';
        }

        $setting = $this->m_basic->getAllData('rft_konfigurasi')->result_array();
        $dosen = $this->m_basic->getAllData('dosen', array('nidn' => $nidn))->result_array();
        $mkul = $this->m_basic->getAllData('fn_jadwal', array('rft_kode_matakuliah' => $kode_matkul, 'rft_kelas' => $kelas))->result_array();
        $uraian = $this->m_basic->getUraianScore($nidn, $kode_matkul, $kelas, $semester);
        // $aspek = array('Kesiapan Mengajar', 'Materi Pengajaran', 'Disiplin Mengajar', 'Evaluasi Mengajar', 'Kepribadian Dosen');
        $aspek = $this->m_basic->getAllData('fn_aspek_penilaian', null, array('urutan' => 'ASC'))->result_array();
        $mhs_done = $this->m_basic->getDistinctWhereData('fn_penilaian', 'npm', array('nidn' => $nidn, 'kode_matkul' => $kode_matkul, 'kelas' => $kelas, 'semester' => $semester))->num_rows();
        $total_mhs = $this->m_basic->getTotalMhsMatkul($kode_matkul, $kelas, $semester)->num_rows();
        $prodi = $this->m_basic->getAllData('prodi', array('KodeProdi' => $kdprodi))->result_array();

        $data['dosen'] = $dosen;
        $data['setting'] = $setting[0];
        $data['uraian'] = $uraian;
        $data['aspek'] = $aspek;
        $data['mkul'] = $mkul;
        $data['done'] = $mhs_done;
        $data['total'] = $total_mhs;
        $data['prodi'] = $prodi;

        $this->load->view('kd_cetak/cetak_penilaian', $data);
    }

    function cetak_rekap_semua_dosen($semester, $kdprodi, $thn_ajaran, $smtr)
    {
        $thn_ajaran = $this->encrypt->decode($thn_ajaran);

        $allscore = $this->m_basic->getAllScore($semester, $kdprodi);
        $prodi = $this->m_basic->getAllData('prodi', array('KodeProdi' => $kdprodi))->result_array();

        $data['allscore'] = $allscore;
        $data['semester'] = $semester;
        $data['kdprodi'] = $kdprodi;
        $data['thn_ajaran'] = $thn_ajaran;
        $data['smtr'] = $smtr;
        $data['prodi'] = $prodi;

        $this->load->view('kd_cetak/cetak_rekap_semua_dosen', $data);
    }

    function cetak_rekap_dosen($nidn, $semester, $kdprodi, $thn_ajaran, $smtr)
    {
        $nidn = $this->encrypt->decode($nidn);
        $semester = $this->encrypt->decode($semester);
        $kdprodi = $this->encrypt->decode($kdprodi);
        $thn_ajaran = $this->encrypt->decode($thn_ajaran);
        $smtr = $this->encrypt->decode($smtr);

        $matkul = $this->m_basic->getPersonScore($nidn, $semester, $kdprodi);
        $prodi = $this->m_basic->getAllData('prodi', array('KodeProdi' => $kdprodi))->result_array();
        $dosen = $this->m_basic->getAllData('dosen', array('nidn' => $nidn))->result_array();

        $data['matkul'] = $matkul;
        $data['kdprodi'] = $kdprodi;
        $data['thn_ajaran'] = $thn_ajaran;
        $data['smtr'] = $smtr;
        $data['prodi'] = $prodi;
        $data['dosen'] = $dosen;

        $this->load->view('kd_cetak/cetak_rekap_dosen', $data);
    }

}