<?php
class _visit_mobile_monitoring extends Model
{
	function _visit_mobile_monitoring()
	{
		parent::Model();
	}

	function getHasil()
	{
		$this->db->select('*');
        $this->db->from('VW_SAPM_VISIT');
		return $this->db->get();
	}

	//detail visit
	function getVisit($idvisit)
	{
		$sql = "SELECT * FROM VW_SAPM_VISIT WHERE IDVISIT='$idvisit'";
		return $this->db->query($sql)->result();
	}


}
?>
