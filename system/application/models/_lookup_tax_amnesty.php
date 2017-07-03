<?php
class _lookup_tax_amnesty extends Model
{
	function _lookup_tax_amnesty()
	{
		parent::Model();
	}

    function getLookupKomitmen()
    {
        $query = $this->db->query("SELECT * FROM TAX_LOOKUP_KOMITMEN ORDER BY ID ASC");
        return $query->result();
    }

    function getLookupJenisClosing()
    {
        $query = $this->db->query("SELECT * FROM tax_lookup_jenis_closing ORDER BY ID ASC");
        return $query->result();
    }

    function getLookupJenisProduk()
    {
    	$query = $this->db->query("SELECT * FROM tax_lookup_produk ORDER BY ID ASC");
        return $query->result();
    }

	function getLookupRole($id_user)
	{
		$role_id = $_SESSION['ROLE_ID'];
		if ($role_id == 1) {
			$hasil = $this->db->query("SELECT * FROM tax_role WHERE id !=1");
		}
		elseif ($role_id == 2) {
			$hasil = $this->db->query("SELECT * FROM tax_role WHERE id !=1 AND id !=2");
		}
		return $hasil->result();
	}






}
?>
