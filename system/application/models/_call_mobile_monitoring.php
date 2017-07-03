<?php
class _call_mobile_monitoring extends Model
{
	function _call_mobile_monitoring()
	{
		parent::Model();
	}

	function getHasil()
	{
		// $this->db->select('IDCALL,NAMA_SALES,NAMA,WAKTU,TANGGAL,NPP,NOTLP,DURASI,NAMA_HASIL_CALL,KETERANGAN,LAT,LNG');
        // $this->db->from('VW_SAPM_CALLS order by IDCALL DESC');
		$this->db->select('*');
        $this->db->from('VW_SAPM_CALLS');
		return $this->db->get();
	}

	//detail call
	function getCall($idcall)
	{
		$sql = "SELECT * FROM VW_SAPM_CALLS WHERE IDCALL='$idcall'";
		return $this->db->query($sql)->result();
	}


}
?>
