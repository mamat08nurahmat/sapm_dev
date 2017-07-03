<?php
class _phr_nasabah extends Model
{
	function _phr_nasabah()
	{
		parent::Model();
	}

	/*insert phrnasabahlog*/
	function insertPHR($username, $cif)
	{
		//$create_date = date('d-M-y');
		//$create_date = date('Y-m-d H:i:s');
		$tambah   = $this->db->query("INSERT INTO PHR_NASABAH_LOG (ID,USERNAME,TANGGAL,CIF) VALUES (PHR_SEQ.NEXTVAL, '$username', CURRENT_TIMESTAMP, '$cif')");
	}

	function getDataProgram($cif)
	{
		$hasil = $this->db->query("SELECT DISTINCT
								   a.NAMA_PROGRAM, a.TGL_AWAL, a.TGL_AKHIR, a.PENJELASAN_PROGRAM
								   FROM PHR_PROGRAM a LEFT JOIN PHR_PROGRAM_CIF b
								   ON a.ID_PROGRAM = b.ID_PROGRAM where b.CIF = '$cif'");
		return $hasil->result();
	}




}
?>
