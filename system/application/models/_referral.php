<?php 
class _referral extends Model 
{
	function _referral()
	{
		parent::Model();
	}
	
	/*query referal kartu kredit*/
	function getKartuKredit($npp,$start,$end)
	{
		$cari = $this->db->query("SELECT * FROM REFERRAL_KARTU_KREDIT WHERE NPP='$npp'  
		                          AND (INPUT_DATA  BETWEEN  '$start' AND '$end' 
								  OR VERIFIKASI  BETWEEN  '$start' AND '$end' 
								  OR ANALISA BETWEEN  '$start' AND '$end'
								  OR APP BETWEEN  '$start' AND '$end' 
								  OR DECLINE BETWEEN  '$start' AND '$end')");
		return $cari->result();
		
	}
	
	/*query cek npp
	function getHits($npp) 
	{
		$sql = $this->db->query("SELECT NPP FROM HISTORY_KARTU_KREDIT WHERE NPP = '$npp'");
		return $sql->result();
	}
	*/
	
	/*tambah data*/
	function insertHits($npp)
	{
		//$datetime = date('Y-m-d H:i:s');
		$tambah   = $this->db->query("INSERT INTO HISTORY_KARTU_KREDIT (ID,NPP,DATE_TIME) VALUES (HISTORY_SEQ.NEXTVAL, $npp, CURRENT_TIMESTAMP)");
	}
	
	/*update data
	function updateHits($hits,$npp)
	{
		$update = $this->db->query("UPDATE  HITS_KARTU_KREDIT SET HITS=$hits+1 WHERE NPP=$npp ");
	}
	*/
	
	/*select hits by npp
	function selectHits($npp)
	{
		$sql = $this->db->query("SELECT HITS FROM HITS_KARTU_KREDIT WHERE NPP = '$npp'");
		$result = $sql->row();
		return $result->HITS;

	}
	*/
}
?>

