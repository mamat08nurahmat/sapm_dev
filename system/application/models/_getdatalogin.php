<?php 
class _getdatalogin extends Model 
{
	function _getdatalogin()
	{
		parent::Model();
	}
	
	//query slider
	function getHeader()
	{
		$header = "SELECT * FROM slider ORDER BY ID DESC";
		return $this->db->query($header)->result();
	}
	
	function getCountHeader()
	{
		$sql = "SELECT COUNT(*) as JUMLAH FROM SLIDER";
		return $this->db->query($sql)->result();
	}
	
	//tampil banner
	function getBanner()
	{
		$banner = "SELECT * FROM BANNER ORDER BY ID DESC";
		return $this->db->query($banner)->result();
	}
	
	//tampil bni.co.id
	function getHelpdesk()
	{
		$wizard = "SELECT * FROM GALLLERY_LOGIN WHERE URUTAN='1'";
		return $this->db->query($wizard)->result();
	}
	
	//tampil gallery sapmqrcode
	function getCrcode()
	{
		$barbarian = "SELECT * FROM GALLLERY_LOGIN WHERE URUTAN='2'";
		return $this->db->query($barbarian)->result();
	}
	
	//tampil bni.co.id
	function getBni()
	{
		$builder = "SELECT * FROM GALLLERY_LOGIN WHERE URUTAN='3'";
		return $this->db->query($builder)->result();
	}
	
	
	
}
?>