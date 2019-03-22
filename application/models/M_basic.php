<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_basic extends CI_Model {

	function __construct()
	{
		parent::__construct();

	}

// GET DATA

	function getAllData($table, $where = null, $order = null)
	{
		if ($where !== null) {
			foreach ($where as $key => $value) {
				$this->db->where($key, $value);
			}
		}

		if ($order !== null) {
			foreach ($order as $key => $value) {
				$this->db->order_by($key, $value);
			}
		}

		$query = $this->db->get($table);

		return $query;
	}

	function getAllDataOr($table, $where = null, $order = null)
	{
		if ($where !== null) {
			foreach ($where as $key => $value) {
				$this->db->or_where($key, $value);
			}
		}

		if ($order !== null) {
			foreach ($order as $key => $value) {
				$this->db->order_by($key, $value);
			}
		}

		$this->db->where('tahun_ajaran', $this->session->tahun_ajaran);
		$query = $this->db->get($table);

		return $query;
	}

	function getNumRows($table, $where = null)
	{
		if ($where !== null) {
			$query = $this->db->get_where($table, $where);
		} else {
			$query = $this->db->get($table);
		}

		return $query->num_rows();
	}

	function getDistinctData($table, $row, $order = null)
	{
		$this->db->distinct();

		$this->db->select($row);

		if ($order !== null) {
			foreach ($order as $key => $value) {
				$this->db->order_by($key, $value);
			}
		}

		$query = $this->db->get($table);

		return $query;
	}

	function getDistinctWhereData($table, $row, $where)
	{
		$this->db->distinct();

		$this->db->select($row);

		$this->db->where($where);

		//$this->db->order_by('semester', 'DESC');

		$query = $this->db->get($table);

		return $query;
	}

	function getDistinctDataOrder($table, $where = null, $row, $order)
	{
		$this->db->distinct();

		$this->db->select($row);

		if ($where !== null) {
			foreach ($where as $key => $value) {
				$this->db->where($key, $value);
			}
		}

		foreach ($order as $key => $value) {
			$this->db->order_by($key, $value);
		}

		$query = $this->db->get($table);

		return $query;
	}

	function getSisaMhs()
	{
		$sql = "SELECT a.* FROM mahasiswa a LEFT JOIN tugas_akhir b ON a.npm = b.npm WHERE b.npm IS null ORDER BY a.npm ASC";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

// INSERT DATA

	function insertData($table, $data)
	{
		$this->db->insert($table, $data);
	}

	function insertAllData($table, $data)
	{
		$this->db->insert_batch($table, $data);
	}

	function insertMultiple($table1, $data1, $table2, $data2)
	{
		$this->db->trans_start();
		$this->db->insert_batch($table1, $data1);
		$this->db->insert($table2, $data2);
		$this->db->trans_complete();
	}

// UPDATE DATA

	function updateData($table, $data, $where){
		$this->db->where($where);
		$this->db->update($table, $data);
	}

	function updateMultipleData($data1, $data2, $where)
	{
		$this->db->trans_start();
		$this->db->where($where);
		$this->db->update('mhs_profil', $data1);
		$this->db->where($where);
		$this->db->update('mhs', $data2);
		$this->db->trans_complete();
	}

	function updateAll($table, $data, $value)
	{
		$this->db->update_batch($table, $data, $value);
	}

// DELETE DATA

	function deleteData($table, $where)
	{
		$this->db->where($where);
		$this->db->delete($table);
	}

// ANOTHER FUNCTION
	function decline($table1, $data1, $table2, $data2, $where)
	{
		$this->db->trans_start();
		$this->db->insert($table1, $data1);
		$this->db->where($where);
		$this->db->update($table2, $data2);
		$this->db->trans_complete();
	}

// UPDATE IMAGE PROFILE
	function updateImage($table1, $table2, $data, $where, $where2)
	{
		$this->db->trans_start();
		$this->updateData($table1, $data, $where);
		$this->updateData($table2, $data, $where2);
		$this->db->trans_complete();
	}


// INSERT INTO TWO TABLES
	function insertTwoTables($table1, $data1, $table2, $data2)
	{
		$this->db->trans_start();
		$this->db->insert($table1, $data1);
		$this->db->insert($table2, $data2);
		$this->db->trans_complete();
	}

// GET DATA FROM TABLE TKRS, TLOGIN, JADWAL, DAN DOSEN
	function getKrs($npm, $semester)
	{
		// $sql = "SELECT rft_tkrs.rft_npm, tlogin.nama AS `nama_mhs`, tlogin.kelas, rft_tkrs.rft_kode_matakuliah, fn_jadwal.rft_nama_matakuliah, rft_tkrs.rft_sks, rft_tkrs.rft_semester, rft_tkrs.rft_thn_ajar, fn_jadwal.rft_nidn, dosen.nama AS `nama_dosen`, dosen.jengped FROM rft_tkrs JOIN tlogin ON rft_tkrs.rft_npm = tlogin.npm JOIN fn_jadwal ON rft_tkrs.rft_kode_matakuliah = fn_jadwal.rft_kode_matakuliah LEFT OUTER JOIN dosen ON fn_jadwal.rft_nidn = dosen.NIDN WHERE rft_tkrs.rft_npm = '".$npm."' AND fn_jadwal.rft_nama_matakuliah != 'KKN'";

		// $sql = "SELECT rft_tkrs.rft_npm, tlogin.nama AS `nama_mhs`, tlogin.kelas, rft_tkrs.rft_kode_matakuliah, fn_jadwal.rft_nama_matakuliah, rft_tkrs.rft_sks, rft_tkrs.rft_semester, rft_tkrs.rft_thn_ajar, fn_jadwal.rft_nidn, dosen.nama AS `nama_dosen`, dosen.jengped FROM rft_tkrs JOIN tlogin ON rft_tkrs.rft_npm = tlogin.npm JOIN fn_jadwal ON rft_tkrs.rft_kode_matakuliah = fn_jadwal.rft_kode_matakuliah LEFT OUTER JOIN dosen ON fn_jadwal.rft_nidn = dosen.NIDN WHERE rft_tkrs.rft_npm = '".$npm."' AND fn_jadwal.rft_nama_matakuliah != 'KKN' AND rft_tkrs.rft_semester = '".$semester."'";

		$sql = "SELECT rft_tkrs.rft_npm, tlogin.nama AS `nama_mhs`, rft_tkrs.rft_kelas, fn_jadwal.rft_kode_jadwal, rft_tkrs.rft_kode_matakuliah, fn_jadwal.rft_nama_matakuliah, rft_tkrs.rft_sks, rft_tkrs.rft_semester, rft_tkrs.rft_thn_ajar, fn_jadwal.rft_nidn, dosen.nama AS `nama_dosen`, dosen.jengped, fn_penilaian.kode_matkul 
		FROM rft_tkrs 
		JOIN tlogin ON rft_tkrs.rft_npm = tlogin.npm 
		JOIN fn_jadwal ON rft_tkrs.rft_kode_matakuliah = fn_jadwal.rft_kode_matakuliah AND rft_tkrs.rft_kelas = fn_jadwal.rft_kelas
		LEFT OUTER JOIN dosen ON fn_jadwal.rft_nidn = dosen.NIDN 
		LEFT JOIN (SELECT DISTINCT kode_matkul FROM fn_penilaian WHERE npm = sha1('".$npm."') AND semester = '".$semester."') fn_penilaian ON rft_tkrs.rft_kode_matakuliah = fn_penilaian.kode_matkul 
		WHERE rft_tkrs.rft_npm = '".$npm."' AND fn_jadwal.rft_nama_matakuliah != 'KKN' AND rft_tkrs.rft_semester = '".$semester."' AND fn_jadwal.rft_nama_matakuliah != 'Seminar TA'";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

// GET ALL SCORE
	function getAllScore($semester, $kdprodi)
	{
		// $sql = "SELECT dosen.NIDN, dosen.nama, dosen.jengped, dosen.basehomedos, fn_penilaian.semester, fn_penilaian.avg FROM dosen LEFT JOIN (SELECT nidn, kode_matkul, semester, AVG(nilai) AS `avg` FROM fn_penilaian WHERE semester = '".$semester."' GROUP BY nidn) fn_penilaian ON dosen.NIDN = fn_penilaian.nidn WHERE dosen.aktif = 'Aktif' GROUP BY dosen.NIDN";

		// $sql = "SELECT dosen.NIDN, dosen.nama, dosen.jengped, dosen.basehomedos, fn_penilaian.semester, MAX(fn_penilaian.avg) AS `avg` FROM dosen LEFT JOIN (SELECT nidn, kode_matkul, semester, AVG(nilai) AS `avg` FROM fn_penilaian WHERE semester = '".$semester."' GROUP BY nidn) fn_penilaian ON dosen.NIDN = fn_penilaian.nidn GROUP BY dosen.NIDN ORDER BY MAX(fn_penilaian.avg) DESC";

		$sql = "SELECT rft_matakuliah.rft_kdprodi, fn_jadwal.rft_nidn, fn_jadwal.rft_nama_dosen, dosen.jengped, fn_penilaian.semester, MAX(fn_penilaian.avg) AS `avg`
		FROM fn_jadwal JOIN rft_matakuliah ON fn_jadwal.rft_kode_matakuliah = rft_matakuliah.rft_kode_matakuliah 
		JOIN dosen ON fn_jadwal.rft_nidn = dosen.NIDN 
		LEFT JOIN (SELECT nidn, kode_matkul, semester, AVG(nilai) AS `avg` FROM fn_penilaian WHERE semester = '".$semester."' AND kdprodi = '".$kdprodi."' GROUP BY nidn) fn_penilaian ON fn_penilaian.nidn = fn_jadwal.rft_nidn 
		WHERE fn_jadwal.rft_semester = '".$semester."' AND rft_matakuliah.rft_kdprodi = '".$kdprodi."' 
		GROUP BY fn_jadwal.rft_nidn 
		ORDER BY MAX(fn_penilaian.avg) DESC";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function getAllAvgPerson($nidn, $kdprodi)
	{
		$sql = "SELECT *, AVG(nilai) AS `avg` FROM `fn_penilaian` WHERE nidn = '".$nidn."' AND kdprodi = '".$kdprodi."' GROUP BY semester";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function getPersonScore($nidn, $semester, $kdprodi)
	{
		// $sql = "SELECT fn_jadwal.rft_kode_matakuliah, fn_jadwal.rft_nama_matakuliah, fn_jadwal.rft_kelas AS `kelas`, fn_penilaian.avg FROM fn_jadwal LEFT JOIN (SELECT nidn, kode_matkul, kelas, AVG(nilai) AS `avg` FROM fn_penilaian WHERE nidn = '".$nidn."' AND semester = '".$semester."' GROUP BY kode_matkul) fn_penilaian ON fn_jadwal.rft_kode_matakuliah = fn_penilaian.kode_matkul WHERE fn_jadwal.rft_nidn = '".$nidn."' GROUP BY fn_jadwal.rft_kode_matakuliah";

		// $sql = "SELECT fn_jadwal.rft_kode_matakuliah, fn_jadwal.rft_nama_matakuliah, fn_jadwal.rft_kelas AS `kelas`, fn_penilaian.avg FROM fn_jadwal LEFT JOIN (SELECT nidn, kode_matkul, kelas, AVG(nilai) AS `avg` FROM fn_penilaian WHERE nidn = '".$nidn."' AND semester = '".$semester."' GROUP BY kode_matkul) fn_penilaian ON fn_jadwal.rft_kode_matakuliah = fn_penilaian.kode_matkul WHERE fn_jadwal.rft_nidn = '".$nidn."' AND fn_jadwal.rft_semester = '".$semester."' GROUP BY fn_jadwal.rft_kode_matakuliah";

		// $sql = "SELECT fn_jadwal.rft_kode_matakuliah, fn_jadwal.rft_nama_matakuliah, fn_jadwal.rft_kelas AS `kelas`, fn_penilaian.avg 
		// FROM fn_jadwal 
		// LEFT JOIN (SELECT nidn, kode_matkul, kelas, AVG(nilai) AS `avg` FROM fn_penilaian WHERE nidn = '".$nidn."' AND semester = '".$semester."' GROUP BY kelas) fn_penilaian 
		// ON fn_jadwal.rft_kode_matakuliah = fn_penilaian.kode_matkul AND fn_jadwal.rft_kelas = fn_penilaian.kelas
		// WHERE fn_jadwal.rft_nidn = '".$nidn."' AND fn_jadwal.rft_semester = '".$semester."'";

		$sql = "SELECT rft_matakuliah.rft_kdprodi, fn_jadwal.rft_kode_matakuliah, fn_jadwal.rft_nama_matakuliah, fn_jadwal.rft_kelas AS `kelas`, fn_penilaian.avg 
		FROM fn_jadwal 
		LEFT JOIN (SELECT nidn, kdprodi, kode_matkul, kelas, AVG(nilai) AS `avg` FROM fn_penilaian WHERE nidn = '".$nidn."' AND semester = '".$semester."' AND kdprodi = '".$kdprodi."' GROUP BY kode_jadwal) fn_penilaian 
		ON fn_jadwal.rft_kode_matakuliah = fn_penilaian.kode_matkul AND fn_jadwal.rft_kelas = fn_penilaian.kelas JOIN rft_matakuliah ON rft_matakuliah.rft_kode_matakuliah = fn_jadwal.rft_kode_matakuliah
		WHERE fn_jadwal.rft_nidn = '".$nidn."' AND fn_jadwal.rft_semester = '".$semester."' AND rft_matakuliah.rft_kdprodi = '".$kdprodi."'";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function getUraianScore($nidn, $kode_matkul, $kelas, $semester)
	{
		$sql = "SELECT fn_kinerja_dosen.kode_kinerja, fn_kinerja_dosen.aspek_penilaian, fn_kinerja_dosen.uraian, fn_penilaian.avg FROM fn_kinerja_dosen LEFT JOIN (SELECT *, AVG(nilai) AS `avg` FROM `fn_penilaian` WHERE kode_matkul='".$kode_matkul."' AND nidn = '".$nidn."' AND semester = '".$semester."' AND kelas = '".$kelas."' GROUP BY kode_kinerja) fn_penilaian ON fn_kinerja_dosen.kode_kinerja = fn_penilaian.kode_kinerja GROUP BY fn_kinerja_dosen.kode_kinerja";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function getTotalMhsMatkul($kode_matkul, $kelas, $semester)
	{
		$sql = "SELECT rft_tkrs.rft_npm, tlogin.nama, tlogin.kelas FROM rft_tkrs LEFT JOIN tlogin ON rft_tkrs.rft_npm = tlogin.npm WHERE rft_tkrs.rft_kode_matakuliah = '".$kode_matkul."' AND tlogin.kelas = '".$kelas."' AND rft_tkrs.rft_semester = '".$semester."'";

		$query = $this->db->query($sql);

		return $query;
	}

	function getJadwal($semester)
	{
		$sql = "SELECT rft_matakuliah.rft_kdprodi, fn_jadwal.rft_kode_matakuliah, fn_jadwal.rft_nama_matakuliah, fn_jadwal.rft_kelas, fn_jadwal.rft_nidn, dosen.jengped, fn_jadwal.rft_nama_dosen, rft_matakuliah.rft_sks, fn_jadwal.rft_hari, fn_jadwal.rft_waktu, fn_jadwal.rft_ruang, fn_jadwal.rft_semester, rft_matakuliah.rft_smtr FROM fn_jadwal JOIN rft_matakuliah ON fn_jadwal.rft_kode_matakuliah = rft_matakuliah.rft_kode_matakuliah JOIN dosen ON fn_jadwal.rft_nidn = dosen.NIDN WHERE fn_jadwal.rft_semester = '".$semester."'";

		$query = $this->db->query($sql);

		return $query;
	}

	function getTingkat($semester, $tk)
	{
		$sql = "SELECT rft_matakuliah.rft_kdprodi, fn_jadwal.rft_kode_matakuliah, fn_jadwal.rft_nama_matakuliah, fn_jadwal.rft_kelas, fn_jadwal.rft_nidn, dosen.jengped, fn_jadwal.rft_nama_dosen, rft_matakuliah.rft_sks, fn_jadwal.rft_hari, fn_jadwal.rft_waktu, fn_jadwal.rft_ruang, fn_jadwal.rft_semester, rft_matakuliah.rft_smtr FROM fn_jadwal JOIN rft_matakuliah ON fn_jadwal.rft_kode_matakuliah = rft_matakuliah.rft_kode_matakuliah JOIN dosen ON fn_jadwal.rft_nidn = dosen.NIDN WHERE fn_jadwal.rft_semester = '".$semester."' AND rft_matakuliah.rft_smtr = '".$tk."'";

		$query = $this->db->query($sql);

		return $query;
	}

	function getJadwalProdiGanjil($semester, $kdprodi)
	{
		$sql = "SELECT rft_matakuliah.rft_kdprodi, fn_jadwal.rft_kode_matakuliah, fn_jadwal.rft_nama_matakuliah, fn_jadwal.rft_kelas, fn_jadwal.rft_nidn, dosen.jengped, fn_jadwal.rft_nama_dosen, rft_matakuliah.rft_sks, fn_jadwal.rft_hari, fn_jadwal.rft_waktu, fn_jadwal.rft_ruang, fn_jadwal.rft_semester, rft_matakuliah.rft_smtr FROM fn_jadwal JOIN rft_matakuliah ON fn_jadwal.rft_kode_matakuliah = rft_matakuliah.rft_kode_matakuliah JOIN dosen ON fn_jadwal.rft_nidn = dosen.NIDN WHERE fn_jadwal.rft_semester = '".$semester."' AND rft_matakuliah.rft_kdprodi='".$kdprodi."' AND rft_matakuliah.rft_semester = 'Ganjil'";

		$query = $this->db->query($sql);

		return $query;
	}

	function getJadwalProdiGenap($semester, $kdprodi)
	{
		$sql = "SELECT rft_matakuliah.rft_kdprodi, fn_jadwal.rft_kode_matakuliah, fn_jadwal.rft_nama_matakuliah, fn_jadwal.rft_kelas, fn_jadwal.rft_nidn, dosen.jengped, fn_jadwal.rft_nama_dosen, rft_matakuliah.rft_sks, fn_jadwal.rft_hari, fn_jadwal.rft_waktu, fn_jadwal.rft_ruang, fn_jadwal.rft_semester, rft_matakuliah.rft_smtr FROM fn_jadwal JOIN rft_matakuliah ON fn_jadwal.rft_kode_matakuliah = rft_matakuliah.rft_kode_matakuliah JOIN dosen ON fn_jadwal.rft_nidn = dosen.NIDN WHERE fn_jadwal.rft_semester = '".$semester."' AND rft_matakuliah.rft_kdprodi='".$kdprodi."' AND rft_matakuliah.rft_semester = 'Genap'";

		$query = $this->db->query($sql);

		return $query;
	}

	function getAllJadwal($semester, $kdprodi)
	{
		$sql = "SELECT fn_jadwal.*, rft_matakuliah.rft_kdprodi FROM `fn_jadwal` LEFT JOIN rft_matakuliah ON fn_jadwal.rft_kode_matakuliah = rft_matakuliah.rft_kode_matakuliah WHERE fn_jadwal.rft_semester = '".$semester."' AND rft_matakuliah.rft_kdprodi = '".$kdprodi."'";
		$query = $this->db->query($sql);

		return $query;
	}

	function getMahasiswa($semester, $kdprodi = null)
	{
		$sql = "SELECT DISTINCT(rft_tkrs.rft_npm), tlogin.nama, tlogin.angkatan, tlogin.kelas FROM `rft_tkrs` JOIN tlogin ON rft_tkrs.rft_npm = tlogin.npm WHERE rft_tkrs.rft_semester = '".$semester."' AND rft_tkrs.rft_npm LIKE '".$kdprodi."%'";

		$query = $this->db->query($sql);

		return $query;
	}

	function getDetailKelasMhs($npm, $semester)
	{
		$sql = "SELECT rft_tkrs.rft_npm, rft_tkrs.rft_kode_matakuliah, rft_matakuliah.rft_nama_matakuliah, rft_tkrs.rft_sks, rft_tkrs.rft_semester, rft_tkrs.smtr, rft_tkrs.rft_thn_ajar, rft_tkrs.rft_kelas FROM `rft_tkrs` JOIN rft_matakuliah ON rft_tkrs.rft_kode_matakuliah = rft_matakuliah.rft_kode_matakuliah WHERE rft_npm = '".$npm."' AND rft_tkrs.rft_semester = '".$semester."'";

		$query = $this->db->query($sql);

		return $query;
	}

	function checkKelas($npm, $semester)
	{
		$sql = "SELECT a.`rft_npm`, b.kelas FROM `rft_tkrs` a LEFT JOIN (SELECT `rft_npm`, COUNT(`rft_kelas`) AS 'kelas' FROM rft_tkrs WHERE rft_npm = '".$npm."' AND rft_semester = '".$semester."' AND rft_kelas = '') b ON a.rft_npm = b.rft_npm WHERE a.rft_npm = '".$npm."' GROUP BY a.rft_npm";

		$query = $this->db->query($sql);

		return $query;
	}

	function getMatakuliahKrs($npm, $semester)
	{
		$sql = "SELECT rft_tkrs.id, rft_tkrs.rft_kode_matakuliah, rft_matakuliah.rft_nama_matakuliah, rft_tkrs.rft_sks FROM rft_tkrs JOIN rft_matakuliah ON rft_tkrs.rft_kode_matakuliah = rft_matakuliah.rft_kode_matakuliah WHERE rft_tkrs.rft_npm = '".$npm."' AND rft_tkrs.rft_semester = '".$semester."'";

		$query = $this->db->query($sql);

		return $query;
	}

	function getTotalMahasiswa($kdprodi, $semester)
	{
		$sql = "SELECT semester, COUNT(npm) as 'total' FROM `fn_status_penilaian` WHERE npm LIKE '".$kdprodi."%' AND semester = '".$semester."'";

		$query = $this->db->query($sql);

		return $query;
	}
}


