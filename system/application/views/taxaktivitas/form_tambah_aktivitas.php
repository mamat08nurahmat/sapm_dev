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
					<div class="panel-heading" style="background-color:#008080; color:#fff;"><strong>INPUT AKTIVITAS</strong></div><br />
					<div class="table-responsive" style="margin:10px; overflow:visible">
						 <form class="form-horizontal" method="post" role="form" id="frmlogin" action="<?php echo site_url('aktivitas/proses_tambah_aktivitas'); ?>">
							<div class="form-group">
							  <label class="control-label col-sm-2" for=""><p class="text-left">Nama Nasabah</p></label>
							  <div class="col-sm-4"> 	
								<div class="input-group"> <!-- input group -->
									<input type="hidden" id="id_prospek" name="id_prospek"   class="form-control" >
									<input type="text" id="nama_nasabah" name="nama_nasabah" class="form-control" placeholder="" required>
									<span class="input-group-btn">
										<button id="cari" type="button" class="btn btn-info"><span class="glyphicon glyphicon-search"></span> Search</button>
										
									</span> 
								</div>* clik tombol untuk mencari nasabah 
							  </div>
							  
							   <div class="col-sm-4"> </div>
							  
							</div>
							
						
							<div class="form-group">   
							  <label class="control-label col-sm-2" for=""><p class="text-left">Jenis Aktivitas</p></label>							
							  <div class="col-sm-10">
								<div class="checkbox">
									<label class="radio-inline"><input type="radio" name="jenis" value="1" required>Call</label>
									<label class="radio-inline"><input type="radio" name="jenis" value="2" required>Visit</label>
								</div>
							  </div>
							</div>
							<!--<div class="form-group">   
							  <label class="control-label col-sm-2" for=""><p class="text-left">Status</p></label>							
							  <div class="col-sm-10">
								<div class="checkbox">
									<label class="radio-inline"><input type="radio" name="status">Prospek</label>
									<label class="radio-inline"><input type="radio" name="status">Peminat</label>
								</div>
							  </div>
							</div>-->
							<div class="form-group">   
							  <label class="control-label col-sm-2" for=""><p class="text-left">Tanggal</p></label>							
							  <div class="col-sm-3">
								<input type="text" id="tanggal1" name="tanggal" class="form-control" required>
							  </div>
							
							</div>
							<div class="form-group">   
							  <label class="control-label col-sm-2" for=""><p class="text-left">Komitmen</p></label>							
							  <div class="col-sm-3">
									<select class="form-control" name="komitmen" required>
										<option value="1">Komitmen Deklarasi</option>
										<option value="2">Komitmen Repatriasi</option>
										<option value="3">Lainnya</option> 
									</select> 
							  </div>
							</div>
							<div class="form-group">   
							  <label class="control-label col-sm-2" for=""><p class="text-left">Nominal</p></label>							
							  <div class="col-sm-3">
								<input type="text" name="nominal" id="rupiah" class="form-control" >
							  </div>
							
							</div>
							<div class="form-group">
							  <label class="control-label col-sm-2" for="email"><p class="text-left">Keterangan</p></label>
							  <div class="col-sm-8">
									<textarea name="keterangan" class="form-control" rows="3" required></textarea>
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
				<h4 class="modal-title">Cari Nama Nasabah</h4>
			  </div>
			  <div class="modal-body">
				<!--<label class="col-lg-4 control-label">Cari Nama Nasabah</label>-->
				<input type="text" name="carinasabah" id="carinasabah" class="form-control" placeholder="Ketikan Nama Nasabah">
				
				<div id="tampilnasabah"></div>

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
		
		$("#carinasabah").keyup(function(){
            var carinasabah=$("#carinasabah").val();
            
            $.ajax({
                url:"<?php echo site_url('aktivitas/cari_nasabah');?>",
                type:"POST",
                data:"carinasabah="+carinasabah,
                cache:false,
                success:function(html){
                    $("#tampilnasabah").html(html);
                }
            })
        })
		

		$('body').on('click', '.tambah', function(){
            var id_prospek=$(this).attr("id_prospek");
            var nama_nasabah=$(this).attr("nama_nasabah");
            
            $("#id_prospek").val(id_prospek);
            $("#nama_nasabah").val(nama_nasabah);
            
            $("#myModal2").modal("hide");
			
        })
		
		$('#rupiah').maskMoney({prefix:'', thousands:'.', decimal:',', precision:0}); 
        
		
	})	
</script>
<!-----------------script ajax------------------>


