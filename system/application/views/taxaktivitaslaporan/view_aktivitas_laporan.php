<!-----------------load header------------------>
<?php echo $this->load->view('layout_taxamnesty/header'); ?>
<!-----------------load header------------------>

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
				    <table border="0" cellspacing="2" style="font-size:11px;">
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
            <div class="col-md-10">
				<div class="panel panel-default">
					<div class="panel-heading" style="background-color:#008080; color:#fff;"><STRONG>REPORT DATA AKTIVITAS</STRONG>

					</div><br />
					<div class="form-horizontal" style="margin:10px">

							<div class="form-group">
								<label class="col-lg-2">Jenis Komitmen</label>
								<div class="col-lg-3">
									<select class="form-control" id="id_komitmen" required>
										<option selected>- Pilih Komitmen -</option>
                                        <?php foreach ($komitmen as $row) { ?>
    										<option value="<?php echo $row->ID; ?>"><?php echo $row->KETERANGAN; ?></option>
                                        <?php } ?>
									</select>

								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-2">Periode Awal</label>
								<div class="col-lg-5">
									<input type="text" id="tanggal2" class="form-control" required>
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-2">Periode Akhir</label>
								<div class="col-lg-5">
									<input type="text" id="tanggal3" class="form-control" required>
								</div>

								<div class="col-lg-4">
									<button id="tampilkan" class="btn btn-primary"><!--<i class="glyphicon glyphicon-search"></i>--> Generate</button>
								</div>
							</div>
						</div>


						<div id="tampildata" style="margin:10px; border:1px solid #ccc; padding:10px; line-height:20px;">
							<p>Silahkan Isi Range Periode Report</p>
						</div>


				</div><br /><br />

            </div>
			<!-- end right content -->

        </div><!-- end row content -->

<!-----------------load footer------------------>
<?php echo $this->load->view('layout_taxamnesty/footer'); ?>
<!-----------------load footer------------------>

<!-----------------script ajax------------------>
<script type="text/javascript">

	$(document).ready(function(){

		$("#tampilkan").click(function(){
			var id_komitmen=$("#id_komitmen").val();
            var tanggal2=$("#tanggal2").val();
            var tanggal3=$("#tanggal3").val();



			//$('#tampil').text('loading...');
			$('#tampildata').fadeOut();
			$('#tampildata').html('<img src="<?php echo loader.'loader2.gif'; ?>"> ');
			$('#tampildata').fadeIn(2500);

            $.ajax({
                url:"<?php echo site_url('aktivitas/cari_aktivitas');?>",
                type:"POST",
                data:"id_komitmen="+id_komitmen+"&tanggal2="+tanggal2+"&tanggal3="+tanggal3,
                cache:false,
                success:function(html){
                    $("#tampildata").html(html);

                }
            })
        })





	})
</script>
<!-----------------script ajax------------------>
<style>
	#tampildata {
		text-align: center;
	}
</style>
