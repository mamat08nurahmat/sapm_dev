<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class _export extends Model 
{
	public function _export()
    {
        parent::Model();
		//$this->CI =& get_instance();
    }
	
	
	function get_all(){
		
		$this->db->get('SAPM_ELO_BOOKING');
		
		
	}
	
}
?>