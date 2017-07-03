<?php
class _logtax extends Model
{
	function _logtax()
	{
		parent::Model();
	}

	function insertLog($create_by, $action)
	{
		$create_date = date('d-M-y');
		$this->db->query(" INSERT INTO TAX_LOG(ID, TANGGAL, ID_USER, ACTION) VALUES (TAX_LOG_SEQ.nextval,  '$create_date', '$create_by', '$action') ");
	}




}
