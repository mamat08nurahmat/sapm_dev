<?php
class _aktivitas extends Model
{
	function _aktivitas()
	{
		parent::Model();
	}

	function getAll($id_user)
	{
		//session leveling
		$role_id = $_SESSION['ROLE_ID'];
		// SUPER_ADMIN || ADMIN || LEVEL KANTOR_BESAR
		if ($role_id == 1 || $role_id == 2 || $role_id == 3) {
			$hasil = $this->db->query("SELECT
										c.JENIS_NASABAH,
										b.ID_NASABAH, b.NAMA_NASABAH, b.POTENSI,
										d.KETERANGAN AS AKTIVITAS_TERAKHIR,
										a.ID_PROSPEK, a.TANGGAL_AKTIVITAS, a.NOMINAL,
										e.KETERANGAN AS KOMITMEN,
										f.ID AS ID_PIC, f.USERNAME AS NAMA_PIC,
										g.BRANCH_NAME,
										i.REGION_NAME AS WILAYAH
										FROM TAX_AKTIVITAS a
										INNER JOIN TAX_PROSPEK b ON a.ID_PROSPEK = b.ID
										INNER JOIN TAX_LOOKUP_JENIS_NASABAH c ON c.ID = b.JENIS_NASABAH
										INNER JOIN TAX_LOOKUP_AKTIVITAS d ON d.ID = a.ID_AKTIVITAS
										INNER JOIN TAX_LOOKUP_KOMITMEN e ON e.ID = a.ID_KOMITMEN
										INNER JOIN TAX_USER f ON f.ID =  a.CREATED_BY
										INNER JOIN TAX_BRANCH g ON g.BRANCH_CODE = f.UNIT_ID
										INNER JOIN TAX_BRANCH_REGION i ON i.REGION_CODE = g.REGION
										ORDER BY a.TANGGAL_AKTIVITAS DESC");
		}
		elseif ($role_id == 4) { //HCR ATAU WILAYAH
			$hasil = $this->db->query("SELECT
										c.JENIS_NASABAH,
										b.ID_NASABAH, b.NAMA_NASABAH, b.POTENSI,
										d.KETERANGAN AS AKTIVITAS_TERAKHIR,
										a.ID_PROSPEK, a.TANGGAL_AKTIVITAS, a.NOMINAL,
										e.KETERANGAN AS KOMITMEN,
										f.ID AS ID_PIC, f.USERNAME AS NAMA_PIC,
										g.BRANCH_NAME
										FROM TAX_AKTIVITAS a
										INNER JOIN TAX_PROSPEK b ON a.ID_PROSPEK = b.ID
										INNER JOIN TAX_LOOKUP_JENIS_NASABAH c ON c.ID = b.JENIS_NASABAH
										INNER JOIN TAX_LOOKUP_AKTIVITAS d ON d.ID = a.ID_AKTIVITAS
										INNER JOIN TAX_LOOKUP_KOMITMEN e ON e.ID = a.ID_KOMITMEN
										INNER JOIN TAX_USER f ON f.ID =  a.CREATED_BY
										INNER JOIN TAX_BRANCH g ON g.BRANCH_CODE = f.UNIT_ID
										INNER JOIN TAX_BRANCH_REGION i ON i.REGION_CODE = g.REGION
										INNER JOIN TAX_USER h ON f.unit_id = h.unit_id WHERE h.id = '$id_user'
										ORDER BY a.TANGGAL_AKTIVITAS DESC");
		}
		elseif ($role_id == 5) { //BM ATAU PEMIMPIN CABANG
			$hasil = $this->db->query("SELECT
										c.JENIS_NASABAH,
										b.ID_NASABAH, b.NAMA_NASABAH, b.POTENSI,
										d.KETERANGAN AS AKTIVITAS_TERAKHIR,
										a.ID_PROSPEK, a.TANGGAL_AKTIVITAS, a.NOMINAL,
										e.KETERANGAN AS KOMITMEN,
										f.ID AS ID_PIC, f.USERNAME AS NAMA_PIC
										FROM TAX_AKTIVITAS a
										INNER JOIN TAX_PROSPEK b ON a.ID_PROSPEK = b.ID
										INNER JOIN TAX_LOOKUP_JENIS_NASABAH c ON c.ID = b.JENIS_NASABAH
										INNER JOIN TAX_LOOKUP_AKTIVITAS d ON d.ID = a.ID_AKTIVITAS
										INNER JOIN TAX_LOOKUP_KOMITMEN e ON e.ID = a.ID_KOMITMEN
										INNER JOIN TAX_USER f ON f.ID =  a.CREATED_BY
										INNER JOIN TAX_BRANCH g ON g.BRANCH_CODE = f.UNIT_ID
										INNER JOIN TAX_USER h ON f.unit_id = h.unit_id WHERE h.id = '$id_user'
										ORDER BY a.TANGGAL_AKTIVITAS DESC");
		}
		elseif ($role_id == 6) { // PIC
			$hasil = $this->db->query("SELECT
										c.JENIS_NASABAH,
										b.ID_NASABAH, b.NAMA_NASABAH, b.POTENSI,
										d.KETERANGAN AS AKTIVITAS_TERAKHIR,
										a.ID_PROSPEK, a.TANGGAL_AKTIVITAS, a.NOMINAL,
										E.KETERANGAN AS KOMITMEN
										FROM TAX_AKTIVITAS a
										INNER JOIN TAX_PROSPEK b ON a.ID_PROSPEK = b.ID
										INNER JOIN TAX_LOOKUP_JENIS_NASABAH c ON c.ID = b.JENIS_NASABAH
										INNER JOIN TAX_LOOKUP_AKTIVITAS d ON d.ID = a.ID_AKTIVITAS
										INNER JOIN TAX_LOOKUP_KOMITMEN e ON e.ID = A.ID_KOMITMEN
										INNER JOIN TAX_USER f ON f.ID =  a.CREATED_BY
										WHERE f.ID = '$id_user'
										ORDER BY a.TANGGAL_AKTIVITAS DESC");
		}

		return $hasil->result();
	}

	function insertAktivitas($id_prospek, $jenis_aktivitas, $tanggal, $komitmen, $nominal, $keterangan, $create_by)//CREATED_BY
	{
		$create_date = date('d-M-y');
		$this->db->query("INSERT INTO TAX_AKTIVITAS(ID, ID_PROSPEK, ID_AKTIVITAS, TANGGAL_AKTIVITAS, ID_KOMITMEN, NOMINAL, KETERANGAN, CREATED_DATE, CREATED_BY) VALUES
        (TAX_AKTIVITAS_SEQ.nextval, '$id_prospek', '$jenis_aktivitas', '$tanggal', '$komitmen', '$nominal', '$keterangan', '$create_date', '$create_by')");
	}

	function insertHistory($id_prospek, $jenis_aktivitas, $tanggal, $keterangan, $create_by)
	{
		$create_date = date('d-M-y');
		$this->db->query("INSERT INTO TAX_HISTORY(ID, ID_PROSPEK, ID_AKTIVITAS, TANGGAL_AKTIVITAS, KETERANGAN, CREATED_DATE, CREATED_BY)VALUES
        (TAX_HISTORY_SEQ.nextval, '$id_prospek', '$jenis_aktivitas', '$tanggal', '$keterangan', '$create_date', '$create_by')");

	}

	function cekAktivitas($id_prospek)
	{
		$hasil = $this->db->query("SELECT * FROM TAX_AKTIVITAS WHERE ID_PROSPEK = '$id_prospek'");
		return $hasil;
	}

	function updateAktivitasTerakhir($id_prospek, $id_aktivitas, $tanggal, $komitmen, $keterangan, $modified_by)
	{
		$modified_date = date('d-M-y');
		$this->db->query("UPDATE TAX_AKTIVITAS SET ID_AKTIVITAS      = '$id_aktivitas',
		                                            TANGGAL_AKTIVITAS = '$tanggal',
													ID_KOMITMEN       = '$komitmen',
													MODIFIED_DATE     = '$modified_date',
													KETERANGAN        = '$keterangan',
													MODIFIED_BY       = '$modified_by'
													WHERE  ID_PROSPEK = '$id_prospek'");
	}

	function searchProspek($cari, $id_user)
	{
		$role_id = $_SESSION['ROLE_ID'];
		if ($role_id == '1') { //SUPER ADMIN
			$hasil = $this->db->query("SELECT * FROM TAX_PROSPEK WHERE ROWNUM <=10 and (ID_NASABAH  LIKE '%$cari%' OR LOWER(NAMA_NASABAH) LIKE '%$cari%')");

		} elseif($role_id == '6') { //SALES_ADMIN atau PIC
			$hasil = $this->db->query("SELECT
										a.ID, a.ID_NASABAH, a.NAMA_NASABAH, b.ID_PROSPEK
										FROM TAX_PROSPEK a
										LEFT JOIN TAX_CLOSING b ON b.ID_PROSPEK = a.ID
										WHERE ROWNUM <=10 AND(b.ID_PROSPEK IS NULL AND (a.CREATED_BY = '$id_user' AND (a.ID_NASABAH LIKE '%$cari%' OR LOWER(a.NAMA_NASABAH) LIKE '%$cari%')))");
		}
		return $hasil->result();
		//

	}

	function getHistory($id_prospek)
	{
		$hasil = $this->db->query("SELECT
									a.TANGGAL_AKTIVITAS AS TANGGAL,
									b.KETERANGAN AS AKTIVITAS,
									d.KETERANGAN AS STATUS,
									a.KETERANGAN,
									c.NAMA_NASABAH
									FROM TAX_HISTORY a
									INNER JOIN TAX_LOOKUP_AKTIVITAS b ON b.ID = a.ID_AKTIVITAS
									INNER JOIN TAX_PROSPEK c ON c.ID = a.ID_PROSPEK
									INNER JOIN TAX_LOOKUP_STATUS d ON d.ID = c.STATUS
									WHERE a.ID_PROSPEK = '$id_prospek'  ORDER BY  a.TANGGAL_AKTIVITAS ASC");
		return $hasil->result();
	}

	function getHistory2($id_prospek)
	{
		$hasil = $this->db->query("SELECT
									a.TANGGAL_AKTIVITAS AS TANGGAL,
									b.KETERANGAN AS AKTIVITAS,
									d.KETERANGAN AS STATUS,
									a.KETERANGAN,
									c.NAMA_NASABAH
									FROM TAX_HISTORY a
									INNER JOIN TAX_LOOKUP_AKTIVITAS b ON b.ID = a.ID_AKTIVITAS
									INNER JOIN TAX_PROSPEK c ON c.ID = a.ID_PROSPEK
									INNER JOIN TAX_LOOKUP_STATUS d ON d.ID = c.STATUS
									WHERE a.ID_PROSPEK = '$id_prospek'  ORDER BY  a.TANGGAL_AKTIVITAS ASC");
		return $hasil;
	}

	function selectByClosing($id_prospek)
	{
		$hasil = $this->db->query("SELECT
									a.ID_PROSPEK AS ID_PROSPEK,
									b.NAMA_NASABAH AS NAMA_NASABAH
									FROM TAX_PROSPEK b INNER JOIN TAX_AKTIVITAS a ON b.ID = a.ID_PROSPEK
									AND a.ID_PROSPEK = '$id_prospek'");
		return $hasil->row();
	}

	function insertClosing($id_prospek, $nama_nasabah, $tanggal, $id_produk, $id_aktivitas, $no_rekening, $nominal, $keterangan, $create_by, $skpp)
	{
		$create_date = date('d-M-y');
		$this->db->query("INSERT INTO TAX_CLOSING(ID, ID_PROSPEK, NAMA_NASABAH, TANGGAL_AKTIVITAS, ID_PRODUK, ID_AKTIVITAS, NO_REKENING, NOMINAL, KETERANGAN, CREATED_DATE, CREATED_BY, ID_SKPP)VALUES
        (TAX_CLOSING_SEQ.nextval, '$id_prospek', '$nama_nasabah', '$tanggal', '$id_produk', '$id_aktivitas', '$no_rekening', '$nominal', '$keterangan','$create_date', '$create_by', '$skpp')");
	}

	function getClosing($id_user, $id_aktivitas, $tanggal2, $tanggal3)
	{
		$role_id = $_SESSION['ROLE_ID'];
		// SUPER_ADMIN || ADMIN || LEVEL KANTOR_BESAR
		if ($role_id == 1 || $role_id == 2 || $role_id == 3) {
			$hasil = $this->db->query("SELECT
										DISTINCT
										c.JENIS_NASABAH AS JENIS_NASABAH,
										a.NO_REKENING , a.NAMA_NASABAH, a.NOMINAL,
										d.KETERANGAN AS JENIS_CLOSING,
										a.TANGGAL_AKTIVITAS AS TANGGAL_CLOSING,
										e.KETERANGAN AS PRODUK,
										j.KETERANGAN AS SKPP,
										a.KETERANGAN,
										f.ID AS NPP, f.USERNAME AS NAMA_PIC,
										g.BRANCH_NAME AS UNIT,
										i.REGION_NAME AS WILAYAH
										FROM TAX_CLOSING a
										INNER JOIN TAX_PROSPEK b ON a.ID_PROSPEK = b.ID
										INNER JOIN TAX_LOOKUP_JENIS_NASABAH c ON b.JENIS_NASABAH = c.ID
										INNER JOIN TAX_LOOKUP_JENIS_CLOSING d ON a.ID_AKTIVITAS = d.ID
										INNER JOIN TAX_LOOKUP_PRODUK e ON a.ID_PRODUK = e.ID
										INNER JOIN TAX_USER f ON f.ID =  a.CREATED_BY
										INNER JOIN TAX_BRANCH g ON g.BRANCH_CODE = f.UNIT_ID
										INNER JOIN TAX_USER h ON f.unit_id = h.unit_id
										INNER JOIN TAX_BRANCH_REGION i ON i.REGION_CODE = g.REGION
										INNER JOIN TAX_LOOKUP_SKPP j ON a.ID_SKPP = j.ID
										WHERE a.ID_AKTIVITAS = '$id_aktivitas' AND a.TANGGAL_AKTIVITAS BETWEEN '$tanggal2' AND '$tanggal3'
										ORDER BY a.TANGGAL_AKTIVITAS ASC");
		}
		elseif ($role_id == 4) { // LEVEL HCR ATAU WILAYAH
			$hasil = $this->db->query("SELECT
										c.JENIS_NASABAH AS JENIS_NASABAH,
										a.NO_REKENING , a.NAMA_NASABAH, a.NOMINAL,
										d.KETERANGAN AS JENIS_CLOSING,
										a.TANGGAL_AKTIVITAS AS TANGGAL_CLOSING,
										e.KETERANGAN AS PRODUK,
										j.KETERANGAN AS SKPP,
										a.KETERANGAN,
										f.ID AS NPP, f.USERNAME AS NAMA_PIC,
										g.BRANCH_NAME AS UNIT
										FROM TAX_CLOSING a
										INNER JOIN TAX_PROSPEK b ON a.ID_PROSPEK = b.ID
										INNER JOIN TAX_LOOKUP_JENIS_NASABAH c ON b.JENIS_NASABAH = c.ID
										INNER JOIN TAX_LOOKUP_JENIS_CLOSING d ON a.ID_AKTIVITAS = d.ID
										INNER JOIN TAX_LOOKUP_PRODUK e ON a.ID_PRODUK = e.ID
										INNER JOIN TAX_USER f ON f.ID =  a.CREATED_BY
										INNER JOIN TAX_BRANCH g ON g.BRANCH_CODE = f.UNIT_ID
										INNER JOIN TAX_USER h ON f.unit_id = h.unit_id
										INNER JOIN TAX_BRANCH_REGION i ON i.REGION_CODE = g.REGION
										INNER JOIN TAX_LOOKUP_SKPP j ON a.ID_SKPP = j.ID
										WHERE h.ID = '$id_user' AND (a.ID_AKTIVITAS = '$id_aktivitas' AND a.TANGGAL_AKTIVITAS BETWEEN '$tanggal2' AND '$tanggal3')
										ORDER BY a.TANGGAL_AKTIVITAS ASC");
		}
		elseif ($role_id == 5) { //LEVEL BM ATAU PEMIMPIN_CABANG
			$hasil = $this->db->query("SELECT
										c.JENIS_NASABAH AS JENIS_NASABAH,
										a.NO_REKENING , a.NAMA_NASABAH, a.NOMINAL,
										d.KETERANGAN AS JENIS_CLOSING,
										a.TANGGAL_AKTIVITAS AS TANGGAL_CLOSING,
										e.KETERANGAN AS PRODUK,
										i.KETERANGAN AS SKPP,
										a.KETERANGAN,
										f.ID AS NPP, f.USERNAME AS NAMA_PIC
										FROM TAX_CLOSING a
										INNER JOIN TAX_PROSPEK b ON a.ID_PROSPEK = b.ID
										INNER JOIN TAX_LOOKUP_JENIS_NASABAH c ON b.JENIS_NASABAH = c.ID
										INNER JOIN TAX_LOOKUP_JENIS_CLOSING d ON a.ID_AKTIVITAS = d.ID
										INNER JOIN TAX_LOOKUP_PRODUK e ON a.ID_PRODUK = e.ID
										INNER JOIN TAX_USER f ON f.ID =  a.CREATED_BY
										INNER JOIN TAX_BRANCH g ON g.BRANCH_CODE = f.UNIT_ID
										INNER JOIN TAX_USER h ON f.unit_id = h.unit_id
										INNER JOIN TAX_LOOKUP_SKPP i ON a.ID_SKPP = i.ID
										WHERE h.ID = '$id_user' AND (a.ID_AKTIVITAS = '$id_aktivitas' AND a.TANGGAL_AKTIVITAS BETWEEN '$tanggal2' AND '$tanggal3')
										ORDER BY a.TANGGAL_AKTIVITAS ASC");
		}
		elseif ($role_id == 6) { //LEVEL PIC
			$hasil = $this->db->query("SELECT
										c.JENIS_NASABAH AS JENIS_NASABAH,
										a.NO_REKENING , a.NAMA_NASABAH, a.NOMINAL,
										d.KETERANGAN AS JENIS_CLOSING,
										a.TANGGAL_AKTIVITAS AS TANGGAL_CLOSING,
										e.KETERANGAN AS PRODUK,
										g.KETERANGAN AS SKPP,
										a.KETERANGAN
										FROM TAX_CLOSING a
										INNER JOIN TAX_PROSPEK b ON a.ID_PROSPEK = b.ID
										INNER JOIN TAX_LOOKUP_JENIS_NASABAH c ON b.JENIS_NASABAH = c.ID
										INNER JOIN TAX_LOOKUP_JENIS_CLOSING d ON a.ID_AKTIVITAS = d.ID
										INNER JOIN TAX_LOOKUP_PRODUK e ON a.ID_PRODUK = e.ID
										INNER JOIN TAX_USER f ON f.ID =  a.CREATED_BY
										INNER JOIN TAX_LOOKUP_SKPP g ON a.ID_SKPP = g.ID
										WHERE f.ID = '$id_user' AND (a.ID_AKTIVITAS = '$id_aktivitas' AND a.TANGGAL_AKTIVITAS BETWEEN '$tanggal2' AND '$tanggal3')
										ORDER BY a.TANGGAL_AKTIVITAS ASC");
		}


		return $hasil->result();
	}

	function getReportClosing($id_user, $id_aktivitas, $tanggal2, $tanggal3)
	{
		$role_id = $_SESSION['ROLE_ID'];
		// SUPER_ADMIN || ADMIN || LEVEL KANTOR_BESAR
		if ($role_id == 1 || $role_id == 2 || $role_id == 3) {
			$hasil = $this->db->query("SELECT
										DISTINCT
										c.JENIS_NASABAH AS JENIS_NASABAH,
										a.NO_REKENING , a.NAMA_NASABAH, a.NOMINAL,
										d.KETERANGAN AS JENIS_CLOSING,
										a.TANGGAL_AKTIVITAS AS TANGGAL_CLOSING,
										e.KETERANGAN AS PRODUK,
										j.KETERANGAN AS SKPP,
										a.KETERANGAN,
										f.ID AS NPP, f.USERNAME AS NAMA_PIC,
										g.BRANCH_NAME AS UNIT,
										i.REGION_NAME AS WILAYAH
										FROM TAX_CLOSING a
										INNER JOIN TAX_PROSPEK b ON a.ID_PROSPEK = b.ID
										INNER JOIN TAX_LOOKUP_JENIS_NASABAH c ON b.JENIS_NASABAH = c.ID
										INNER JOIN TAX_LOOKUP_JENIS_CLOSING d ON a.ID_AKTIVITAS = d.ID
										INNER JOIN TAX_LOOKUP_PRODUK e ON a.ID_PRODUK = e.ID
										INNER JOIN TAX_USER f ON f.ID =  a.CREATED_BY
										INNER JOIN TAX_BRANCH g ON g.BRANCH_CODE = f.UNIT_ID
										INNER JOIN TAX_USER h ON f.unit_id = h.unit_id
										INNER JOIN TAX_BRANCH_REGION i ON i.REGION_CODE = g.REGION
										INNER JOIN TAX_LOOKUP_SKPP j ON a.ID_SKPP = j.ID
										WHERE a.ID_AKTIVITAS = '$id_aktivitas' AND a.TANGGAL_AKTIVITAS BETWEEN '$tanggal2' AND '$tanggal3'
										ORDER BY a.TANGGAL_AKTIVITAS ASC");
		}
		elseif ($role_id == 4) { // LEVEL HCR ATAU WILAYAH
			$hasil = $this->db->query("SELECT
										c.JENIS_NASABAH AS JENIS_NASABAH,
										a.NO_REKENING , a.NAMA_NASABAH, a.NOMINAL,
										d.KETERANGAN AS JENIS_CLOSING,
										a.TANGGAL_AKTIVITAS AS TANGGAL_CLOSING,
										e.KETERANGAN AS PRODUK,
										j.KETERANGAN AS SKPP,
										a.KETERANGAN,
										f.ID AS NPP, f.USERNAME AS NAMA_PIC,
										g.BRANCH_NAME AS UNIT
										FROM TAX_CLOSING a
										INNER JOIN TAX_PROSPEK b ON a.ID_PROSPEK = b.ID
										INNER JOIN TAX_LOOKUP_JENIS_NASABAH c ON b.JENIS_NASABAH = c.ID
										INNER JOIN TAX_LOOKUP_JENIS_CLOSING d ON a.ID_AKTIVITAS = d.ID
										INNER JOIN TAX_LOOKUP_PRODUK e ON a.ID_PRODUK = e.ID
										INNER JOIN TAX_USER f ON f.ID =  a.CREATED_BY
										INNER JOIN TAX_BRANCH g ON g.BRANCH_CODE = f.UNIT_ID
										INNER JOIN TAX_USER h ON f.unit_id = h.unit_id
										INNER JOIN TAX_BRANCH_REGION i ON i.REGION_CODE = g.REGION
										INNER JOIN TAX_LOOKUP_SKPP j ON a.ID_SKPP = j.ID
										WHERE h.ID = '$id_user' AND (a.ID_AKTIVITAS = '$id_aktivitas' AND a.TANGGAL_AKTIVITAS BETWEEN '$tanggal2' AND '$tanggal3')
										ORDER BY a.TANGGAL_AKTIVITAS ASC");
		}
		elseif ($role_id == 5) { //LEVEL BM
			$hasil = $this->db->query("SELECT
										c.JENIS_NASABAH AS JENIS_NASABAH,
										a.NO_REKENING , a.NAMA_NASABAH, a.NOMINAL,
										d.KETERANGAN AS JENIS_CLOSING,
										a.TANGGAL_AKTIVITAS AS TANGGAL_CLOSING,
										e.KETERANGAN AS PRODUK,
										i.KETERANGAN AS SKPP,
										a.KETERANGAN,
										f.ID AS NPP, f.USERNAME AS NAMA_PIC
										FROM TAX_CLOSING a
										INNER JOIN TAX_PROSPEK b ON a.ID_PROSPEK = b.ID
										INNER JOIN TAX_LOOKUP_JENIS_NASABAH c ON b.JENIS_NASABAH = c.ID
										INNER JOIN TAX_LOOKUP_JENIS_CLOSING d ON a.ID_AKTIVITAS = d.ID
										INNER JOIN TAX_LOOKUP_PRODUK e ON a.ID_PRODUK = e.ID
										INNER JOIN TAX_USER f ON f.ID =  a.CREATED_BY
										INNER JOIN TAX_BRANCH g ON g.BRANCH_CODE = f.UNIT_ID
										INNER JOIN TAX_USER h ON f.unit_id = h.unit_id
										INNER JOIN TAX_LOOKUP_SKPP i ON a.ID_SKPP = i.ID
										WHERE h.ID = '$id_user' AND (a.ID_AKTIVITAS = '$id_aktivitas' AND a.TANGGAL_AKTIVITAS BETWEEN '$tanggal2' AND '$tanggal3')
										ORDER BY a.TANGGAL_AKTIVITAS ASC");
		}
		elseif ($role_id == 6) { //LEVEL PIC
			$hasil = $this->db->query("SELECT
										c.JENIS_NASABAH AS JENIS_NASABAH,
										a.NO_REKENING , a.NAMA_NASABAH, a.NOMINAL,
										d.KETERANGAN AS JENIS_CLOSING,
										a.TANGGAL_AKTIVITAS AS TANGGAL_CLOSING,
										e.KETERANGAN AS PRODUK,
										g.KETERANGAN AS SKPP,
										a.KETERANGAN
										FROM TAX_CLOSING a
										INNER JOIN TAX_PROSPEK b ON a.ID_PROSPEK = b.ID
										INNER JOIN TAX_LOOKUP_JENIS_NASABAH c ON b.JENIS_NASABAH = c.ID
										INNER JOIN TAX_LOOKUP_JENIS_CLOSING d ON a.ID_AKTIVITAS = d.ID
										INNER JOIN TAX_LOOKUP_PRODUK e ON a.ID_PRODUK = e.ID
										INNER JOIN TAX_USER f ON f.ID =  a.CREATED_BY
										INNER JOIN TAX_LOOKUP_SKPP g ON a.ID_SKPP = g.ID
										WHERE f.ID = '$id_user' AND (a.ID_AKTIVITAS = '$id_aktivitas' AND a.TANGGAL_AKTIVITAS BETWEEN '$tanggal2' AND '$tanggal3')
										ORDER BY a.TANGGAL_AKTIVITAS ASC");
		}

		return $hasil;
	}

	function cekClosing($id_prospek)
	{
		$hasil = $this->db->query("SELECT * FROM TAX_CLOSING WHERE ID_PROSPEK = '$id_prospek'");
		return $hasil;
	}

	function cekStatusClosing($id_user)
	{
		$hasil = $this->db->query("SELECT * FROM TAX_CLOSING WHERE CREATED_BY = '$id_user'");
		return $hasil;
		// $hasil = $this->db->query(" SELECT * FROM TAX_CLOSING a
									// INNER JOIN TAX_PROSPEK b ON a.ID_PROSPEK = b.ID
									// INNER JOIN TAX_AKTIVITAS c ON c.ID_PROSPEK = b.ID ");
		// return $hasil;
	}

	// function deleteAktivitas($id)
	// {
		// $this->db->query(" DELETE FROM TAX_AKTIVITAS WHERE ID_PROSPEK = '$id' ");
	// }

	// function deleteHistory($id)
	// {
		// $this->db->query(" DELETE FROM TAX_HISTORY WHERE ID_PROSPEK = '$id' ");
	// }

	//FUNCTION VIEW REPORT DATA AKTIVITAS
	function getAktivitas($id_user, $id_komitmen, $tanggal2, $tanggal3)
	{
		$role_id = $_SESSION['ROLE_ID'];
		// SUPER_ADMIN || ADMIN || LEVEL KANTOR_BESAR
		if ($role_id == 1 || $role_id == 2 || $role_id == 3) {
			$hasil = $this->db->query("SELECT
										c.JENIS_NASABAH,
										b.ID_NASABAH, b.NAMA_NASABAH, b.POTENSI,
										d.KETERANGAN AS AKTIVITAS_TERAKHIR,
										a.ID_PROSPEK, a.TANGGAL_AKTIVITAS, a.NOMINAL,
										e.KETERANGAN AS KOMITMEN,
										f.ID AS NPP, f.USERNAME AS NAMA_PIC,
										g.BRANCH_NAME AS CABANG,
										i.REGION_NAME AS WILAYAH
										FROM TAX_AKTIVITAS a
										INNER JOIN TAX_PROSPEK b ON a.ID_PROSPEK = b.ID
										INNER JOIN TAX_LOOKUP_JENIS_NASABAH c ON c.ID = b.JENIS_NASABAH
										INNER JOIN TAX_LOOKUP_AKTIVITAS d ON d.ID = a.ID_AKTIVITAS
										INNER JOIN TAX_LOOKUP_KOMITMEN e ON e.ID = A.ID_KOMITMEN
										INNER JOIN TAX_USER f ON f.ID =  a.CREATED_BY
										INNER JOIN TAX_BRANCH g ON g.BRANCH_CODE = f.UNIT_ID
										INNER JOIN TAX_BRANCH_REGION i ON i.REGION_CODE = g.REGION
										WHERE a.ID_KOMITMEN = '$id_komitmen' AND a.TANGGAL_AKTIVITAS BETWEEN '$tanggal2' AND '$tanggal3'
										ORDER BY a.TANGGAL_AKTIVITAS ASC");
		}

		elseif ($role_id == 4) { //LEVEL HCR ATAU PIMPINAN WILAYAH
			$hasil = $this->db->query("SELECT
										c.JENIS_NASABAH,
										b.ID_NASABAH, b.NAMA_NASABAH, b.POTENSI,
										d.KETERANGAN AS AKTIVITAS_TERAKHIR,
										a.ID_PROSPEK, a.TANGGAL_AKTIVITAS, a.NOMINAL,
										e.KETERANGAN AS KOMITMEN,
										f.ID AS NPP, f.USERNAME AS NAMA_PIC,
										g.BRANCH_NAME AS CABANG
										FROM TAX_AKTIVITAS a
										INNER JOIN TAX_PROSPEK b ON a.ID_PROSPEK = b.ID
										INNER JOIN TAX_LOOKUP_JENIS_NASABAH c ON c.ID = b.JENIS_NASABAH
										INNER JOIN TAX_LOOKUP_AKTIVITAS d ON d.ID = a.ID_AKTIVITAS
										INNER JOIN TAX_LOOKUP_KOMITMEN e ON e.ID = A.ID_KOMITMEN
										INNER JOIN TAX_USER f ON f.ID =  a.CREATED_BY
										INNER JOIN TAX_BRANCH g ON g.BRANCH_CODE = f.UNIT_ID
										INNER JOIN TAX_BRANCH_REGION i ON i.REGION_CODE = g.REGION
										INNER JOIN TAX_USER h ON f.unit_id = h.unit_id  WHERE h.ID = '$id_user' AND (a.ID_KOMITMEN = '$id_komitmen' AND a.TANGGAL_AKTIVITAS BETWEEN '$tanggal2' AND '$tanggal3')
										ORDER BY a.TANGGAL_AKTIVITAS ASC");
		}
		elseif ($role_id == 5) { //LEVEL BM ATAU PEMIMPIN_CABANG
			$hasil = $this->db->query("SELECT
										c.JENIS_NASABAH,
										b.ID_NASABAH, b.NAMA_NASABAH, b.POTENSI,
										d.KETERANGAN AS AKTIVITAS_TERAKHIR,
										a.ID_PROSPEK, a.TANGGAL_AKTIVITAS, a.NOMINAL,
										e.KETERANGAN AS KOMITMEN,
										f.ID AS NPP, f.USERNAME AS NAMA_PIC
										FROM TAX_AKTIVITAS a
										INNER JOIN TAX_PROSPEK b ON a.ID_PROSPEK = b.ID
										INNER JOIN TAX_LOOKUP_JENIS_NASABAH c ON c.ID = b.JENIS_NASABAH
										INNER JOIN TAX_LOOKUP_AKTIVITAS d ON d.ID = a.ID_AKTIVITAS
										INNER JOIN TAX_LOOKUP_KOMITMEN e ON e.ID = A.ID_KOMITMEN
										INNER JOIN TAX_USER f ON f.ID =  a.CREATED_BY
										INNER JOIN TAX_BRANCH g ON g.BRANCH_CODE = f.UNIT_ID
										INNER JOIN TAX_USER h ON f.unit_id = h.unit_id
										WHERE h.ID = '$id_user' AND (a.ID_KOMITMEN = '$id_komitmen' AND a.TANGGAL_AKTIVITAS BETWEEN '$tanggal2' AND '$tanggal3')
										ORDER BY a.TANGGAL_AKTIVITAS ASC");
		}

		elseif ($role_id == 6) { //LEVEL PIC

			$hasil = $this->db->query("SELECT
										c.JENIS_NASABAH,
										b.ID_NASABAH, b.NAMA_NASABAH, b.POTENSI,
										d.KETERANGAN AS AKTIVITAS_TERAKHIR,
										a.ID_PROSPEK, a.TANGGAL_AKTIVITAS, a.NOMINAL,
										E.KETERANGAN AS KOMITMEN
										FROM TAX_AKTIVITAS a
										INNER JOIN TAX_PROSPEK b ON a.ID_PROSPEK = b.ID
										INNER JOIN TAX_LOOKUP_JENIS_NASABAH c ON c.ID = b.JENIS_NASABAH
										INNER JOIN TAX_LOOKUP_AKTIVITAS d ON d.ID = a.ID_AKTIVITAS
										INNER JOIN TAX_LOOKUP_KOMITMEN e ON e.ID = A.ID_KOMITMEN
										INNER JOIN TAX_USER f ON f.ID =  a.CREATED_BY
										WHERE f.ID = '$id_user' and (a.ID_KOMITMEN = '$id_komitmen' AND a.TANGGAL_AKTIVITAS BETWEEN '$tanggal2' AND '$tanggal3')
										ORDER BY a.TANGGAL_AKTIVITAS ASC");
		}

		return $hasil->result();
	}

	//FUNCTION EXPORT DATA AKTIVITAS
	function getReportAktivitas($id_user, $id_komitmen, $tanggal2, $tanggal3)
	{
		$role_id = $_SESSION['ROLE_ID'];
		// SUPER_ADMIN || ADMIN || LEVEL KANTOR_BESAR
		if ($role_id == 1 || $role_id == 2 || $role_id == 3) {
			$hasil = $this->db->query("SELECT
										c.JENIS_NASABAH,
										b.ID_NASABAH, b.NAMA_NASABAH, b.POTENSI,
										d.KETERANGAN AS AKTIVITAS_TERAKHIR,
										a.ID_PROSPEK, a.TANGGAL_AKTIVITAS, a.NOMINAL,
										e.KETERANGAN AS KOMITMEN,
										f.ID AS NPP, f.USERNAME AS NAMA_PIC,
										g.BRANCH_NAME AS CABANG,
										i.REGION_NAME AS WILAYAH
										FROM TAX_AKTIVITAS a
										INNER JOIN TAX_PROSPEK b ON a.ID_PROSPEK = b.ID
										INNER JOIN TAX_LOOKUP_JENIS_NASABAH c ON c.ID = b.JENIS_NASABAH
										INNER JOIN TAX_LOOKUP_AKTIVITAS d ON d.ID = a.ID_AKTIVITAS
										INNER JOIN TAX_LOOKUP_KOMITMEN e ON e.ID = A.ID_KOMITMEN
										INNER JOIN TAX_USER f ON f.ID =  a.CREATED_BY
										INNER JOIN TAX_BRANCH g ON g.BRANCH_CODE = f.UNIT_ID
										INNER JOIN TAX_BRANCH_REGION i ON i.REGION_CODE = g.REGION
										WHERE a.ID_KOMITMEN = '$id_komitmen' AND a.TANGGAL_AKTIVITAS BETWEEN '$tanggal2' AND '$tanggal3'
										ORDER BY a.TANGGAL_AKTIVITAS ASC");
		}
		elseif ($role_id == 4) { //LEVEL HCR ATAU WILAYAH
			$hasil = $this->db->query("SELECT
										c.JENIS_NASABAH,
										b.ID_NASABAH, b.NAMA_NASABAH, b.POTENSI,
										d.KETERANGAN AS AKTIVITAS_TERAKHIR,
										a.ID_PROSPEK, a.TANGGAL_AKTIVITAS, a.NOMINAL,
										e.KETERANGAN AS KOMITMEN,
										f.ID AS NPP, f.USERNAME AS NAMA_PIC,
										g.BRANCH_NAME AS CABANG
										FROM TAX_AKTIVITAS a
										INNER JOIN TAX_PROSPEK b ON a.ID_PROSPEK = b.ID
										INNER JOIN TAX_LOOKUP_JENIS_NASABAH c ON c.ID = b.JENIS_NASABAH
										INNER JOIN TAX_LOOKUP_AKTIVITAS d ON d.ID = a.ID_AKTIVITAS
										INNER JOIN TAX_LOOKUP_KOMITMEN e ON e.ID = A.ID_KOMITMEN
										INNER JOIN TAX_USER f ON f.ID =  a.CREATED_BY
										INNER JOIN TAX_BRANCH g ON g.BRANCH_CODE = f.UNIT_ID
										INNER JOIN TAX_BRANCH_REGION i ON i.REGION_CODE = g.REGION
										INNER JOIN TAX_USER h ON f.unit_id = h.unit_id  WHERE h.ID = '$id_user' AND (a.ID_KOMITMEN = '$id_komitmen' AND a.TANGGAL_AKTIVITAS BETWEEN '$tanggal2' AND '$tanggal3')
										ORDER BY a.TANGGAL_AKTIVITAS ASC");
		}
		elseif ($role_id == 5) { //LEVEL BM ATAU PEMIMPIN_CABANG
			$hasil = $this->db->query("SELECT
										c.JENIS_NASABAH,
										b.ID_NASABAH, b.NAMA_NASABAH, b.POTENSI,
										d.KETERANGAN AS AKTIVITAS_TERAKHIR,
										a.ID_PROSPEK, a.TANGGAL_AKTIVITAS, a.NOMINAL,
										e.KETERANGAN AS KOMITMEN,
										f.ID AS NPP, f.USERNAME AS NAMA_PIC
										FROM TAX_AKTIVITAS a
										INNER JOIN TAX_PROSPEK b ON a.ID_PROSPEK = b.ID
										INNER JOIN TAX_LOOKUP_JENIS_NASABAH c ON c.ID = b.JENIS_NASABAH
										INNER JOIN TAX_LOOKUP_AKTIVITAS d ON d.ID = a.ID_AKTIVITAS
										INNER JOIN TAX_LOOKUP_KOMITMEN e ON e.ID = A.ID_KOMITMEN
										INNER JOIN TAX_USER f ON f.ID =  a.CREATED_BY
										INNER JOIN TAX_BRANCH g ON g.BRANCH_CODE = f.UNIT_ID
										INNER JOIN TAX_USER h ON f.unit_id = h.unit_id
										WHERE h.ID = '$id_user' AND (a.ID_KOMITMEN = '$id_komitmen' AND a.TANGGAL_AKTIVITAS BETWEEN '$tanggal2' AND '$tanggal3')
										ORDER BY a.TANGGAL_AKTIVITAS ASC");
		}
		elseif ($role_id == 6) { //LEVEL PIC
			$hasil = $this->db->query("SELECT
										c.JENIS_NASABAH,
										b.ID_NASABAH, b.NAMA_NASABAH, b.POTENSI,
										d.KETERANGAN AS AKTIVITAS_TERAKHIR,
										a.ID_PROSPEK, a.TANGGAL_AKTIVITAS, a.NOMINAL,
										E.KETERANGAN AS KOMITMEN
										FROM TAX_AKTIVITAS a
										INNER JOIN TAX_PROSPEK b ON a.ID_PROSPEK = b.ID
										INNER JOIN TAX_LOOKUP_JENIS_NASABAH c ON c.ID = b.JENIS_NASABAH
										INNER JOIN TAX_LOOKUP_AKTIVITAS d ON d.ID = a.ID_AKTIVITAS
										INNER JOIN TAX_LOOKUP_KOMITMEN e ON e.ID = A.ID_KOMITMEN
										INNER JOIN TAX_USER f ON f.ID =  a.CREATED_BY
										WHERE f.ID = '$id_user' and (a.ID_KOMITMEN = '$id_komitmen' AND a.TANGGAL_AKTIVITAS BETWEEN '$tanggal2' AND '$tanggal3')
										ORDER BY a.TANGGAL_AKTIVITAS ASC");
		}

		return $hasil;
	}




}
