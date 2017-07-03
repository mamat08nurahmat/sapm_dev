<!-- load header -->
<?php  echo $this->load->view('layout_login/header.php'); ?>
<!-- load header -->
	

    <!-- Page Content -->
    <div class="container" style="background-color: #fff; overflow: hidden;">
        <div class="row">

            <div class="col-sm-12 col-md-12">

                <div class="wrapp" style="border:1px solid #ccc; padding: 5px; margin: 20px 0">

                <ul class="nav nav-tabs" style="background-color: #008080">
                    <li class="active"><a data-toggle="tab" href="#home" style="color: orange">KARTU KREDIT</a></li>
                    <!--<li><a data-toggle="tab" href="#menu1">Menu 1</a></li>-->
                    <!--<li><a data-toggle="tab" href="#menu2">Menu 2</a></li>-->
                    <!--<li><a data-toggle="tab" href="#menu3">Menu 3</a></li>-->
                </ul>

                <div class="tab-content table-responsive">
					<!-- KARTU KREDIT -->
                    <div id="home" class="tab-pane fade in active">
						<!-- <form action="./referral/gethasilkk" method="post">-->
					<?php
                    $attributes = array('id' => 'frmlogin', 'name' => 'frmlogin' );
                    echo form_open('referral', $attributes);
                    ?>

                        <br />
                        <table width="0" border="0" class="table-responsive">
                            <tbody>
                            <!--<tr>
                                <td width="100">PRODUK </td>
                                <td><select name="produk" class="form-control" style="margin-bottom: 15px">
                                    <option value="0">- Pilih Produk -</option>
                                    <option>Kartu Kredit</option>
                                </select> </td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>-->
                            <tr>
                                <td width="100">NPP</td>
                                <td><input type="text" name="npp" class="form-control" placeholder="Masukan NPP" style="margin-bottom: 15px" id="npp"></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="100">PERIODE</td>
                                <td><input type="text" id="start" name="start" class="form-control"  style="margin-bottom: 15px"></td>
                                <td>&nbsp; TO &nbsp;</td>
                                <td><input type="text" id="end" name="end" class="form-control" style="margin-bottom: 15px"></td>
                                <td>&nbsp;<input type="submit" value="Generate" name="proses" id="btnproses" class="btn btn-primary" style="margin-bottom: 15px" id="submit-1"></td>
                            </tr>
							<tr>
								<td colspan="5">Untuk alasan decline & informasi lebih lanjut, dapat menghubungi helpdesk SLN di <strong><span style="color:#286090">02129713000</span></strong></td>
							</tr> 
							</tbody>
							
                        </table>
						<br />
						
						
                        <table  class="table table-bordered  table-responsive">
							<tbody>
                            <tr>
                                <th rowspan="2" class="text-center" bgcolor="#EAF4FD"><br />NAMA NASABAH</th>
                                <th rowspan="2" class="text-center" bgcolor="#EAF4FD"><br />TGL LAHIR</th>
                                <th rowspan="2" class="text-center" bgcolor="#EAF4FD"><br />JENIS KARTU</th>
                                <th rowspan="2" class="text-center" bgcolor="#EAF4FD"><br />LOGO</th>
                                <th colspan="3" class="text-center" bgcolor="#EAF4FD">SUBMIT</th>
                                <th colspan="3" class="text-center" bgcolor="#EAF4FD">RESULT</th>
                            </tr>
                            <tr>
                                <th bgcolor="#EAF4FD" class="text-center">INPUT</th>
                                <th bgcolor="#EAF4FD" class="text-center">VERIFIKASI</th>
                                <th bgcolor="#EAF4FD" class="text-center">ANALISA</th>
                                <th bgcolor="#EAF4FD" class="text-center">APPROVE</th>
                                <th bgcolor="#EAF4FD" class="text-center">DECLINE</th>
                                <th bgcolor="#EAF4FD" class="text-center"><a href="#" data-toggle="modal" data-target="#myModal">KET</a></th>
                            </tr>
							
							
                            <?php 
							if (isset($filter)) {
								
								foreach($filter as $data) {
							?>	
                            <tr>
                                <td><?php echo $data->NAMA_NASABAH; ?></td>
                                <td class="text-center"><?php echo $data->TGL_LAHIR; ?></td>
                                <td class="text-center"><?php echo $data->JENIS_KARTU; ?></td>
                                <td class="text-center"><?php echo $data->LOGO; ?></td>
                                <td class="text-center"><?php echo $data->INPUT_DATA; ?></td>
                                <td class="text-center"><?php echo $data->VERIFIKASI; ?></td>
								<td class="text-center"><?php echo $data->ANALISA; ?></td>
                                <td class="text-center"><?php echo $data->APP; ?></td>
                                <td class="text-center"><?php echo $data->DECLINE; ?></td>
                                <td><?php echo $data->KETERANGAN; ?></td>
                            </tr>
							<?php 
								} //end foreach
							} //end if
							?>
                            </tbody>
                        </table>
						
						
						
						<br /><br />

					 <?php
                        echo form_close();
                    ?>
                    </div>
					<!-- END KARTU KREDIT -->
					
                    <!-- <div id="menu1" class="tab-pane fade">
                        <h3>Menu 1</h3>
                        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </div> -->
                    <!-- <div id="menu2" class="tab-pane fade">
                        <h3>Menu 2</h3>
                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                    </div> -->
                    <!--<div id="menu3" class="tab-pane fade">-->
                        <!--<h3>Menu 3</h3>-->
                        <!--<p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>-->
                    <!--</div>-->
				
                 </div> </div><!-- end wrap -->

            </div>
        </div>
	<br /><br /><br />
    </div>
    <!-- /.container -->

<!-- load footer -->	
<?php  echo $this->load->view('layout_login/footer.php'); ?>
<!-- load footer -->  

<script type="text/javascript">
	/* validasi referral view */
	 $("#btnproses").click(function(){
        if($("#npp").val() == ''){
            alert ('Silahkan Masukan NPP Anda');
            npp.focus();
            return false;
        } else {
            $("#frmlogin").submit(); 
        }
    });
</script>


<!----Modal Detail Keterangan---->
<div id="myModal" class="modal fade">
<div class="modal-dialog  modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h5 class="modal-title" class="text-center"><strong>DETAIL KETERANGAN</strong></h5>
		</div>
		<div class="modal-body" style="max-height: calc(100vh - 210px); overflow-y: auto;">
			<h5 class="text-center"><strong>REASON DECLINE APLIKASI </strong></h3>
			<h5 class="text-center"><strong>MASIH BISA DIPROSES</strong></h3>
			<table class="table table-bordered table-responsive">
			  <tr>
				<th bgcolor="#0269C2" class="text-center" style="color:white">NO</th>
				<th bgcolor="#0269C2" class="text-center" style="color:white">KODE</th>
				<th bgcolor="#0269C2" class="text-center" style="color:white">KETERANGAN</th>
			  </tr>
			  <tr>
				<td class="text-center" >1</td>
				<td class="text-center" >AK</td>
				<td><!--<a href="#" data-trigger="focus"   data-toggle="popover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." title=""></a>-->Alamat Kantor Tidak Jelas</td>
			  </tr>
			  <tr>
				<td class="text-center" >2</td>
				<td class="text-center" >AR</td>
				<td>Alamat Rumah    Tidak Jelas</td>
			  </tr>
			  <tr>
				<td class="text-center" >3</td>
				<td class="text-center" >CP</td>
				<td>Cancel    Permintaan</td>
			  </tr>
			  <tr>
				<td class="text-center" >4</td>
				<td class="text-center" >DP</td>
				<td>Diluar    Prosedur</td>
			  </tr>
			  <tr>
				<td class="text-center" height="37" >5</td>
				<td class="text-center" >NP</td>
				<td>Missing NPWP</td>
			  </tr>
			  <tr>
				<td class="text-center" >6</td>
				<td class="text-center" >SD</td>
				<td>Sulit    Dihubungi</td>
			  </tr>
			  <tr>
				<td class="text-center" >7</td>
				<td class="text-center" >SG</td>
				<td>Slip Gaji    Meragukan</td>
			  </tr>
			  <tr>
				<td class="text-center" >8</td>
				<td class="text-center" >SS</td>
				<td>Missing    Dokumen Penghasilan</td>
			  </tr>
			  <tr>
				<td class="text-center" >9</td>
				<td class="text-center" >TL</td>
				<td>Tidak    Lengkap/Dokumen Kurang</td>
			  </tr>
			  <tr>
				<td class="text-center" >10</td>
				<td class="text-center" >TR</td>
				<td>Tidak Ada    Telpon</td>
			  </tr>
			  <tr>
				<td class="text-center" >11</td>
				<td class="text-center" >DK</td>
				<td>Analisa Tidak    Sesuai Permintaan</td>
			  </tr>
			  <tr>
				<td class="text-center" >12</td>
				<td class="text-center" >II</td>
				<td>Incomplete    Information</td>
			  </tr>
			  <tr>
				<td class="text-center" >13</td>
				<td class="text-center" >AK</td>
				<td>Alamat    Kantor Tidak Jelas</td>
			  </tr>
			</table>
			
			<!--<h5 class="text-center"><strong>REASON DECLINE APLIKASI WILAYAH LUAR JAKARTA</strong></h3>
			<h5 class="text-center"><strong>MASIH BISA DIPROSES</strong></h3>
			<table class="table table-bordered table-responsive">
			  <tr>
				<th bgcolor="#1abed9" class="text-center" style="color:white">NO</th>
				<th bgcolor="#1abed9" class="text-center" style="color:white">KODE</th>
				<th bgcolor="#1abed9" class="text-center" style="color:white">KETERANGAN</th>
			  </tr>
			  <tr>
				<td>1</td>
				<td>CP</td>
				<td>Cancel    Permintaan</td>
			  </tr>
			  <tr>
				<td>2</td>
				<td>II</td>
				<td>Incomplete    Information</td>
			  </tr>
			  <tr>
				<td>3</td>
				<td>DK</td>
				<td>Analisa Tidak Sesuai    Permintaan</td>
			  </tr>
			  <tr>
				<td>4</td>
				<td>SD</td>
				<td>Sulit Dihubungi</td>
			  </tr>
			  <tr>
				<td>5</td>
				<td>TL</td>
				<td>Tidak Lengkap/Dokumen    Kurang</td>
			  </tr>
			  <tr>
				<td>6</td>
				<td>TR</td>
				<td>Tidak Ada Telpon</td>
			  </tr>
			</table>-->
			
			
			<h5 class="text-center"><strong>REASON DECLINE APLIKASI</strong></h3>
			<h5 class="text-center"><strong>TIDAK BISA DIPROSES</strong></h3>
			<table class="table table-bordered table-responsive">
			  <tr>
				<th bgcolor="#eaa91b" class="text-center" style="color:white">NO</th>
				<th bgcolor="#eaa91b" class="text-center" style="color:white">KODE</th>
				<th bgcolor="#eaa91b" class="text-center" style="color:white">KETERANGAN</th>
			  </tr>
			  <tr>
				<td>1</td>
				<td>BI</td>
				<td>Bad Info</td>
			  </tr>
			  <tr>
				<td>2</td>
				<td>BR</td>
				<td>Bad Rating</td>
			  </tr>
			  <tr>
				<td>3</td>
				<td>DS</td>
				<td>Tanda Tangan Beda    dengan Aplikasi</td>
			  </tr>
			  <tr>
				<td>4</td>
				<td>DU</td>
				<td>Duplikasi Data</td>
			  </tr>
			  <tr>
				<td>5</td>
				<td>HR</td>
				<td>High Risk</td>
			  </tr>
			  <tr>
				<td>6</td>
				<td>KM</td>
				<td>Kapasitas Minimal</td>
			  </tr>
			  <tr>
				<td>7</td>
				<td>LB</td>
				<td>Low Bisnis, Karyawan    &lt; 5 Orang</td>
			  </tr>
			  <tr>
				<td>8</td>
				<td>MD</td>
				<td>Manipulasi Data</td>
			  </tr>
			  <tr>
				<td>9</td>
				<td>MI</td>
				<td>Pendapatan Minimum</td>
			  </tr>
			  <tr>
				<td>10</td>
				<td>MK</td>
				<td>Masa Kerja &gt;1    Tahun</td>
			  </tr>
			  <tr>
				<td>11</td>
				<td>MS</td>
				<td>Member Since</td>
			  </tr>
			  <tr>
				<td>12</td>
				<td>OL</td>
				<td>Over Limit</td>
			  </tr>
			  <tr>
				<td>13</td>
				<td>PK</td>
				<td>Pegawai Kontrak</td>
			  </tr>
			  <tr>
				<td>14</td>
				<td>RD</td>
				<td>Decline Scoring</td>
			  </tr>
			  <tr>
				<td>15</td>
				<td>SB</td>
				<td>BI Checking</td>
			  </tr>
			  <tr>
				<td>16</td>
				<td>SB1</td>
				<td>Sudah Punya 2 Kartu    Kredit &amp; Gaji di Bawah 10Jt</td>
			  </tr>
			  <tr>
				<td>17</td>
				<td>SB2</td>
				<td>Plafon Sudah Maksimal    dari 3X Penghasilan Bersih karena Gaji di Bawah 10Jt</td>
			  </tr>
			  <tr>
				<td>18</td>
				<td>SI</td>
				<td>BI Checking</td>
			  </tr>
			  <tr>
				<td>19</td>
				<td>SID</td>
				<td>BI Checking</td>
			  </tr>
			  <tr>
				<td>20</td>
				<td>SK</td>
				<td>Surat Keterangan    Meragukan</td>
			  </tr>
			  <tr>
				<td>21</td>
				<td>TT</td>
				<td>Tidak Ada Tanda    Tangan di Aplikasi</td>
			  </tr>
			  <tr>
				<td>22</td>
				<td>UM</td>
				<td>Minimal Umur</td>
			  </tr>
			  <tr>
				<td>23</td>
				<td>UL</td>
				<td>Maksimal Umur</td>
			  </tr>
			  <tr>
				<td>24</td>
				<td>GA</td>
				<td>Duplikasi Garuda</td>
			  </tr>
			  <tr>
				<td>25</td>
				<td>TB</td>
				<td>Tidak Bekerja</td>
			  </tr>
			  <tr>
				<td>26</td>
				<td>LT</td>
				<td>Luar Target</td>
			  </tr>
			  <tr>
				<td>27</td>
				<td>PR</td>
				<td>Bagian HRD Tidak Bisa    Memberi Informasi Kepada Pihak Luar</td>
			  </tr>
			  <tr>
				<td>28</td>
				<td>PN</td>
				<td>Masa Pensiun</td>
			  </tr>
			</table>
			
			
			<h5 class="text-center"><strong>PENGAJUAN</strong></h3>
			<h5 class="text-center"><strong>MASIH PROSES</strong></h3>
			<table class="table table-bordered table-responsive">
			  <tr>
				<th bgcolor="#ff7e56" class="text-center" style="color:white">NO</th>
				<th bgcolor="#ff7e56" class="text-center" style="color:white">KODE</th>
				<th bgcolor="#ff7e56" class="text-center" style="color:white">KETERANGAN</th>
			  </tr>
			  <tr>
				<td>1</td>
				<td>MP</td>
				<td>Menunggu Input    Data Entry</td>
			  </tr>
			  <tr>
				<td>2</td>
				<td>MV</td>
				<td>Menunggu Verifikasi</td>
			  </tr>
			  <tr>
				<td>3</td>
				<td>MK</td>
				<td>Menunggu Koresponden</td>
			  </tr>
			  <tr>
				<td>4</td>
				<td>MA</td>
				<td>Menunggu Analis</td>
			  </tr>
			  <tr>
				<td>5</td>
				<td>WP</td>
				<td>Proses Kelengkapan    Data</td>
			  </tr>
			  <tr>
				<td>6</td>
				<td>WV</td>
				<td>Waiting Verifikasi</td>
			  </tr>
			  <tr>
				<td>7</td>
				<td>WK</td>
				<td>Waiting Koresponden</td>
			  </tr>
			  <tr>
				<td>8</td>
				<td>WA</td>
				<td>Waiting Analis</td>
			  </tr>
			  <tr>
				<td>9</td>
				<td>XV</td>
				<td>Masih Dalam Proses</td>
			  </tr>
			  <tr>
				<td>10</td>
				<td>CO</td>
				<td>Proses Collection</td>
			  </tr>
			  <tr>
				<td>11</td>
				<td>CF</td>
				<td>Waiting Proses Collection</td>
			  </tr>
			  <tr>
				<td>12</td>
				<td>SL</td>
				<td>Aplikasi Dikembalikan    Ke Sales</td>
			  </tr>
			  <tr>
				<td>13</td>
				<td>AM</td>
				<td>Account Maintainance</td>
			  </tr>
			</table>
			
			<h5 class="text-center"><strong>Untuk Reasult Approve, yg muncul huruf N, Null, atau huruf dengan 1 </strong></h3>
			<h5 class="text-center"><strong>Karakter itu disebut Block.</strong></h3>
			<table class="table table-bordered table-responsive">
			  <tr>
				<th bgcolor="#FFD11A" class="text-center" style="color:white">NO</th>
				<th bgcolor="#FFD11A" class="text-center" style="color:white">KODE</th>
				<th bgcolor="#FFD11A" class="text-center" style="color:white">KETERANGAN BLOCK</th>
			  </tr>
			  <tr>
				<td class="text-center" >1</td>
				<td class="text-center" >A</td>
				<td>Tutup Buku</td>
			  </tr>
			  <tr>
				<td class="text-center" >2</td>
				<td class="text-center" >B</td>
				<td>Ch Meninggal</td>
			  </tr>
			  <tr>
				<td class="text-center" >3</td>
				<td class="text-center" >C</td>
				<td>Belum Bayar 30 Day</td>
			  </tr>
			  <tr>
				<td class="text-center" >4</td>
				<td class="text-center" >D</td>
				<td>Belum Bayar 60 Day</td>
			  </tr>
			  <tr>
				<td class="text-center" height="37" >5</td>
				<td class="text-center" >E</td>
				<td>Belum Bayar 90 Day</td>
			  </tr>
			  <tr>
				<td class="text-center" >6</td>
				<td class="text-center" >F</td>
				<td>Kartu Manipulasi (Fraud)</td>
			  </tr>
			  <tr>
				<td class="text-center" >7</td>
				<td class="text-center" >G</td>
				<td>Aplikan Blm Tnda Tangan/blm jd Kartu</td>
			  </tr>
			  <tr>
				<td class="text-center" >8</td>
				<td class="text-center" >H</td>
				<td>Over Limit</td>
			  </tr>
			  <tr>
				<td class="text-center" >9</td>
				<td class="text-center" >J</td>
				<td>Boleh Proses Belum Tutup Buku</td>
			  </tr>
			  <tr>
				<td class="text-center" >10</td>
				<td class="text-center" >K</td>
				<td>Kartu Change Logo</td>
			  </tr>
			  <tr>
				<td class="text-center" >11</td>
				<td class="text-center" >L</td>
				<td>Kartu Hilang</td>
			  </tr>
			  <tr>
				<td class="text-center" >12</td>
				<td class="text-center" >M</td>
				<td>Blokir Sementara</td>
			  </tr>
			  <tr>
				<td class="text-center" >13</td>
				<td class="text-center" >N</td>
				<td>Kartu Belum Aktif</td>
			  </tr>
			  <tr>
				<td class="text-center" >14</td>
				<td class="text-center" >O</td>
				<td>Double Kartu Karena Kesalahan Sistem</td>
			  </tr>
			   <tr>
				<td class="text-center" >15</td>
				<td class="text-center" >P</td>
				<td>Belum Bayar X Day</td>
			  </tr>
			   <tr>
				<td class="text-center" >16</td>
				<td class="text-center" >Q</td>
				<td>Belum Proses</td>
			  </tr>
			  <tr>
				<td class="text-center" >17</td>
				<td class="text-center" >T</td>
				<td>Tidak Boleh Input / Ch Banyak Masalah</td>
			  </tr>
			  <tr>
				<td class="text-center" >18</td>
				<td class="text-center" >U</td>
				<td>Kartu Blokir / Kartu Tidak Samapai</td>
			  </tr>
			  <tr>
				<td class="text-center" >19</td>
				<td class="text-center" >W</td>
				<td>Hapus Buku</td>
			  </tr>
			  <tr>
				<td class="text-center" >20</td>
				<td class="text-center" >X</td>
				<td>Tidak Mau Perpanjangan Keanggotaan</td>
			  </tr>
			  <tr>
				<td class="text-center" >21</td>
				<td class="text-center" >Y</td>
				<td>Hampir Over Limit</td>
			  </tr>
			  <tr>
				<td class="text-center" >22</td>
				<td class="text-center" >I</td>
				<td>Imajiner / Kartu Otomatis Block</td>
			  </tr>
			  <tr>
				<td class="text-center" >23</td>
				<td class="text-center" >Z</td>
				<td>Sedang Proses Collection</td>
			  </tr>
			</table>

			
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
		</div>
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!----Modal Detail Keterangan---->	

<script type="text/javascript" charset="utf-8"> 
	$(document).ready(function(){
		$('[data-toggle="popover"]').popover();
	});
</script>


		
