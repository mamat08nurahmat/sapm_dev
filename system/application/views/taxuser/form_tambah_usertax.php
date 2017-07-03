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
                </div>
				<br /><br />
			</div>            <!-- end left content -->


			<!-- right content -->
            <div class="col-md-10">
				<div class="panel panel-default">
					<div class="panel-heading" style="background-color:#008080; color:#fff;"><strong>TAMBAH USER</strong></div><br />
					<div class="table-responsive" style="margin:10px; overflow:visible">
						 <form class="form-horizontal" method="post" role="form" id="frmlogin" action="<?php echo site_url('usertax/proses_tambah_usertax'); ?>">
							<div class="form-group">
							  <label class="control-label col-sm-2" for=""><p class="text-left">NPP</p></label>
							  <div class="col-sm-3">
								<input type="text" name="npp" maxlength="7" class="form-control" >
							  </div>
							</div>

							<div class="form-group">
							  <label class="control-label col-sm-2" for=""><p class="text-left">Nama User</p></label>
							  <div class="col-sm-5">
								<input type="text" name="nama_user"  class="form-control" >
							  </div>

							</div>

							<!--
							<div class="form-group">
							  <label class="control-label col-sm-2" for=""><p class="text-left">Posisi</p></label>
							  <div class="col-sm-3">
								<input type="text" name="posisi"  class="form-control" >
							  </div>
							</div>-->


							<div class="form-group">
							  <label class="control-label col-sm-2" for=""><p class="text-left">Email</p></label>
							  <div class="col-sm-5">
								<input type="text" name="email"  class="form-control" >
							  </div>

							</div>


							<div class="form-group">
							  <label class="control-label col-sm-2" for=""><p class="text-left">Unit ID</p></label>
							  <div class="col-sm-4">
								<div class="input-group"> <!-- input group -->
									<input type="text" id="id_unit" name="id_unit" class="form-control" placeholder="" required>
									<span class="input-group-btn">
										<button id="cari" type="button" class="btn btn-info"><span class="glyphicon glyphicon-search"></span> Search</button>

									</span>
								</div>* clik tombol untuk mencari unit_id
							  </div>



							</div>

							<div class="form-group">
							  <label class="control-label col-sm-2" for=""><p class="text-left">Level</p></label>
							  <div class="col-sm-3">
									<select class="form-control" name="level" required>
                                        <option>- Pilih Level -</option>
                                        <?php
                                            foreach($lookuprole as $row)
                                            {
                                                ?>
                                                <option value="<?php echo $row->ID; ?>"><?php echo $row->NAMA_ROLE; ?></option>
                                                <?php
                                            }
                                        ?>
									</select>

							  </div>
							</div>

							<div class="form-group">
							  <div class="col-sm-offset-2 col-sm-10">
								<input type="submit" name="simpan" class="btn btn-primary" value="Simpan" />
								<input type="button" name="batal" class="btn btn-warning" onclick=self.history.back() value="Batal" />
							  </div>
							</div>


						  </form>
					 </div>
				 </div>
			</div>

		</div><br /><br />

		<!-- Modal Cari Nasabah -->
		<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Cari Unit ID</h4>
			  </div>
			  <div class="modal-body">
				<!--<label class="col-lg-4 control-label">Cari Nama Nasabah</label>-->
				<input type="text" name="cariunit" id="cariunit" class="form-control" placeholder="Ketikan Unit ID">

				<div id="tampilunit"></div>

			  </div>

			  <br /><br />
			  <div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				<!--<button type="button" class="btn btn-primary" id="konfirmasi">Hapus</button>-->
			  </div>
			</div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div>
		<!-- End Modal Cari Nasabah -->


<!-----------------load footer------------------>
<?php echo $this->load->view('layout_taxamnesty/footer'); ?>
<!-----------------load footer------------------>


<!-----------------script ajax------------------>
<script type="text/javascript">

	$(document).ready(function(){


		$("#cari").click(function(){
            $("#myModal2").modal("show");
			return false;
        })

		$("#cariunit").keyup(function(){
            var cariunit = $("#cariunit").val();

            $.ajax({
                url:"<?php echo site_url('usertax/cari_unit');?>",
                type:"POST",
                data:"cariunit="+cariunit,
                cache:false,
                success:function(html){
                    $("#tampilunit").html(html);
                }
            })
        })


		$('body').on('click', '.tambah', function(){
            var id_unit   = $(this).attr("id_unit");

            $("#id_unit").val(id_unit);

            $("#myModal2").modal("hide");

        })

		//$('#rupiah').maskMoney({prefix:'', thousands:'.', decimal:',', precision:0});


	})
</script>
<!-----------------script ajax------------------>
