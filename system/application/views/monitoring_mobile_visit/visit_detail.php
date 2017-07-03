<!-----------------load header------------------>
<?php echo $this->load->view('layout_mobile_monitoring/header'); ?>
<!-----------------load header------------------>

        <!-- row -->
        <div class="row" >
            <!-- left content -->
            <div class="col-md-2">

			   <!-- menu acordion -->
			   <?php echo $this->load->view('layout_mobile_monitoring/menu'); ?>
			   <!-- end menu acordion -->

				<div class="informasi-atas">
                    INFORMASI USER
                </div>
                <div class="informasi-content">
				    <table border="0" cellspacing="2">
                      <tr>
                        <td align="left"><div style="padding:2px">NPP</div></td>
                        <td>:</td>
                        <td width="100%" align="left"><div style="padding:2px"><?php echo $this->session->userdata('ID'); ?></div></td>
                      </tr>
                      <tr>
                        <td align="left"><div style="padding:2px">Nama</div></td>
                        <td>:</td>
                        <td align="left"><div style="padding:2px"><?php echo $this->session->userdata('USER_NAME'); ?></div></td>
                      </tr>
                      <tr>
                        <td align="left"><div style="padding:2px">Level</div></td>
                        <td>:</td>
                        <td align="left"><div style="padding:2px"><?php echo $this->session->userdata('USER_LEVEL'); ?></div></td>
                      </tr>


					                        <tr>
                        <td align="left"><div style="padding:2px">Region</div></td>
                        <td>:</td>
                        <td align="left"><div style="padding:2px"><?php echo $this->session->userdata('REGION'); ?></div></td>
                      </tr>
                      <tr>
                        <td align="left"><div style="padding:2px">Branch</div></td>
                        <td>:</td>
                        <td align="left"><div style="padding:2px"><?php echo $this->session->userdata('BRANCH_NAME'); ?></div></td>
                      </tr>
                                            <tr>
                        <td align="left"><div style="padding:2px">Grade</div></td>
                        <td>:</td>
                        <td align="left"><div style="padding:2px"><?php echo $this->session->userdata('GRADE'); ?></div></td>
                      </tr>
                                          </table>
                </div>

			</div>
            <!-- end left content -->

			<!-- right content -->
            <div class="col-md-10">
				<div class="panel panel-primary">
				<div class="panel-heading" style="background-color:#008080; color:#fff;">Detail Visit</div>
					<?php echo $maps['html']; ?>
				</div>
            </div>
			<!-- end right content -->

        </div><!-- end row content -->

<!-----------------load footer------------------>
<?php echo $this->load->view('layout_mobile_monitoring/footer'); ?>
<!-----------------load footer------------------>
<?php echo $maps['js']; ?>
