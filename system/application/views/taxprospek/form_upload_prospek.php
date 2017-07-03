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
					<div class="panel-heading" style="background-color:#008080; color:#fff;"><STRONG>UPLOAD DATA PROSPEK</STRONG>
						
					</div><br />
					<div class="form-horizontal" style="margin:10px">
						<div class="form-group">
							<div class="col-lg-5">
								<a href="<?php echo site_url('prospek/download_prospek'); ?>"><input type="submit" class="btn btn-warning" name="userfile" size="20" value="Unduh Format Upload" /></a>
							</div>
						</div><br /> 
						
						<h4>Upload data prospek dengan file excel 97-2003 ekstensi.xls</h4>
						<br />
						<?php echo form_open_multipart('prospek/proses_upload_prospek');?>
						<div class="form-inline">
							<div class="form-group">
								<div class="col-lg-5">
									 
									<input type="file" id="file_upload" name="userfile" size="20"  required/>
								</div>							
							</div>
							<button type="submit" class="btn btn-sm btn-primary" name="upload">Upload Data Prospek</button>
						</div>
						<?php echo form_close();?>
					   
					</div>
					<br />	
						
						

				</div><br /><br />
				
            </div>
			<!-- end right content -->

        </div><!-- end row content -->

<!-----------------load footer------------------>
<?php echo $this->load->view('layout_taxamnesty/footer'); ?>
<!-----------------load footer------------------>

