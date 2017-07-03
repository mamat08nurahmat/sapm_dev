<?php
class _maps_mobile_monitoring extends Model
{
	function _maps_mobile_monitoring()
	{
		parent::Model();
	}

	function get_coordinates()
	{
		 $return = array();
		 $query = $this->db->query("SELECT
						            SAPM_LOCATIONEMPLOYEE.NPP,
								    SAPM_LOCATIONEMPLOYEE.LAT,
								    SAPM_LOCATIONEMPLOYEE.LNG,
								    SAPM_LOCATIONEMPLOYEE.NAMA,
								    SAPM_SALES.ROLE,
								    SAPM_SALES.UNIT
								    FROM SAPM_LOCATIONEMPLOYEE LEFT JOIN SAPM_SALES ON
								    SAPM_LOCATIONEMPLOYEE.NPP = SAPM_SALES.NPP");

		 if ($query->num_rows()>0) {
			 foreach ($query->result() as $row) {
				array_push($return, $row);
			 }
		 }
		 return $return;
	}
}
?>
