<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class _log extends Model 
{
	/**
	* Instanciar o CI
	*/
	public function _log()
    {
        parent::Model();
		$this->CI =& get_instance();
    }
	
	public function logs($data) 
	{
		$field = "";
		$value = "'";
		foreach($data as $row=>$val){
			$field 	.= $row.",";
			$value	.= $val."','"; 
		}
		$row = rtrim($field,",");
		$sql = "INSERT INTO LOG (ID, ".$row.") VALUES (SEQ_LOG.NEXTVAL, ".rtrim($value,",'")."')";
		$this->db->query($sql);
	}
	
}
?>