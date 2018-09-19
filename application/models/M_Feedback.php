<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_feedback extends CI_Model {

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
    
    function getLastRecord()
    {
        $sql = "SELECT * FROM ace_perusahaan ORDER BY kd_perusahaan DESC LIMIT 1";

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    function getAlumniOnDetailPerusahaan($kd_perusahaan)
    {
        $sql = "SELECT ace_alumni.*, ace_pegawai.bulan_bekerja, ace_pegawai.tahun_bekerja FROM ace_alumni LEFT OUTER JOIN ace_pegawai ON ace_alumni.kd_perusahaan = ace_pegawai.kd_perusahaan AND ace_alumni.npm = ace_pegawai.npm WHERE ace_alumni.kd_perusahaan = '".$kd_perusahaan."' GROUP BY ace_alumni.npm";

        $query = $this->db->query($sql);

        return $query->result_array();
	}
	
	function getAllJumlahAlumni($kdprodi)
	{
		$sql = "SELECT `tahun_akademik`, SUM(`jumlah`) AS `jumlah`, `kd_prodi` FROM `ace_jumlah_alumni` WHERE kd_prodi = '".$kdprodi."' GROUP BY `tahun_akademik`";

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
    
    function insertTwoTable($table1, $data1, $table2, $data2)
    {
        $this->db->trans_start();
        $this->db->insert($table1, $data1);
        $this->db->insert($table2, $data2);
		$this->db->trans_complete();
	}
	
	function insertThreeTable($table1, $data1, $table2, $data2, $table3, $data3)
    {
        $this->db->trans_start();
        $this->db->insert($table1, $data1);
		$this->db->insert($table2, $data2);
		$this->db->insert($table3, $data3);
		$this->db->trans_complete();
    }

    function insertUpdateTwoTable($table1, $data1, $table2, $data2, $where)
    {
        $this->db->trans_start();
        $this->db->insert($table1, $data1);
        $this->db->update($table2, $data2, $where);
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

// DELETE DATA

	function deleteData($table, $where)
	{
		$this->db->where($where);
		$this->db->delete($table);
	}


}


