<style>
	.tax li {
		margin-bottom : 15px;
		text-align: justify;
		line-height: 1.5em;
	}
</style>
<!-----------------load header------------------>
<?php echo $this->load->view('layout_taxamnesty/header'); ?>
<!-----------------load header------------------>
<script>
function doconfirm()
{
    hapus = confirm("Apakah anda yakin akan menghapus");
    if(hapus!=true)
    {
        return false;
    }
}
</script>
<div>
        <!-- row -->
        <div class="row" >
            <!-- left content -->
            <div class="col-md-2">
			
			   <!-- menu acordion -->
			   <?php echo $this->load->view('layout_taxamnesty/menu'); ?>
			   <!-- end menu acordion -->
			   				
				<div class="informasi-atas">
                    INFORMASI USER
                </div>
				
                <div class="informasi-content">
				    <table border="0" cellspacing="2" style="font-size:11px; font-weight:bold;">
                      <tr>
                        <td align="left"><div style="padding:2px">Username</div></td>
                        <td>: </td>
                        <td width="100%" align="left"><div style="padding:2px"> <?php echo $this->session->userdata('ID'); ?></div></td>
                      </tr>
					  
                      <tr>
                        <td align="left"><div style="padding:2px">Nama</div></td>
                        <td>: </td>
                        <td align="left"><div style="padding:2px"> <?php echo $this->session->userdata('USERNAME'); ?></div></td>
                      </tr>
					  
                      <tr>
                        <td align="left"><div style="padding:2px">Level</div></td>
                        <td>: </td>
                        <td align="left"><div style="padding:2px"> <?php echo $this->session->userdata('NAMA_ROLE'); ?></div></td>
                      </tr>
                      
					  <!-- 	
					  <tr>
                        <td align="left"><div style="padding:2px">Region</div></td>
                        <td>:</td>
                        <td align="left"><div style="padding:2px"></div></td>
                      </tr>-->
					  
                      <tr>
                        <td align="left"><div style="padding:2px">Branch</div></td>
                        <td>: </td>
                        <td align="left"><div style="padding:2px"> <?php echo $this->session->userdata('BRANCH_NAME'); ?></div></td>
                      </tr>
					  
					  <!--
					  <tr>
                        <td align="left"><div style="padding:2px">Grade</div></td>
                        <td>:</td>
                        <td align="left"><div style="padding:2px"></div></td>
                      </tr>-->
					  
				    </table>
                </div><br /><br />
				
			</div>            <!-- end left content -->


			<!-- right content -->	
			<?PHP  
			/*================== ROLE ===================*/ 
			$role_id = $_SESSION['ROLE_ID'];  
			/*================== ROLE ===================*/ 
			?>
			
            <div class="col-md-10">
				<div class="panel panel-default">
					<div class="panel-heading" style="background-color: #26c4c4; color:#fff;">
						<strong><span class="glyphicon glyphicon-user"></span>&nbsp; Selamat Datang <?php echo $_SESSION['USERNAME']; ?></strong>
					</div><br />	
					<div class="table-responsive" style="padding:10px;">
						<h5><a href="#"><strong>Apa Itu Tax Amnesty ?</strong></a></h5>
						<ol class="tax">
							<li>Tax Amnesty adalah program pengampunan yang diberikan oleh Pemerintah kepada Wajib Pajak meliputi penghapusan pajak terutang, penghapusan sanksi administrasi perpajakan, serta penghapusan sanksi pidana di bidang perpajakan atas harta yang diperoleh pada tahun 2015 dan sebelumnya yang belum dilaporkan Surat Pemberitahuan Tahunan (SPT) dengan cara melunasi seluruh tunggakan pajak yang dimiliki dan membayar Uang Tebusan</li>
							<li>Nasabah Tax Amnesty adalah Wajib Pajak yang memenuhi kriteria untuk memanfaatkan kebijakan Tax Amnesty</li>
							<li>Dana Repatriasi adalah dana yang dialihkan dari luar Wilayah NKRI ke dalam Wilayah NKRI dan diinvestasikan oleh pemohon Pengampunan Pajak di Indonesia dalam rangka Pengampunan Pajak setelah memperoleh Surat Keterangan Pengampunan Pajak</li>
							<li>Dana Deklarasi Dalam Negeri adalah dana Wajib Pajak yang berada di dalam negeri dan dialihkan ke Rekening Khusus dalam rangka Tax Amnesty</li>
							<li>Surat Pernyataan Harta untuk Pengampunan Pajak adalah surat yang digunakan oleh Wajib Pajak Pemohon Pengampunan Pajak untuk mengungkap harta, utang, nilai harta bersih, serta perhitungan dan pembayaran Uang Tebusan</li>
							<li>Uang Tebusan adalah sejumlah uang yang dibayarkan oleh Wajib Pajak ke Kas Negara untuk mendapatkan Pengampunan Pajak</li>
							<li>Rekening Khusus adalah rekening Wajib Pajak yang khusus dibuka dengan kode / flagging “Dana Tax Amnesty” pada Bank Persepsi dalam bentuk rekening simpanan atau rekening trustee untuk menampung Dana Repatriasi dan Dana Deklarasi Dalam Negeri</li>
							<li>Pengelola Nasabah Tax Amnesty adalah pihak yang ditunjuk sebagai Person In Charge (PIC) untuk melakukan pengelolaan dan monitoring serta pengisian aktivitas di Tax Amnesty Monitoring System (TAMS)</li>
							<li>Tax Amnesty Monitoring System (TAMS) adalah aplikasi yang digunakan untuk mengelola dan melakukan monitoring terhadap aktivitas yang dilakukan kepada nasabah tax amnesty</li>
							
						</ol>
					</div>
					
				</div><br /><br />
				
            </div>
			<!-- end right content -->

        </div><!-- end row content -->
</div>
<!-----------------load footer------------------>
<?php echo $this->load->view('layout_taxamnesty/footer'); ?>
<!-----------------load footer------------------>