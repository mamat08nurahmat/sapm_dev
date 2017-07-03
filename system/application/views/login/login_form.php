<!-- load header -->
<?php  echo $this->load->view('layout_login/header.php'); ?>
<!-- load header -->

    <!-- Page Content -->
    <div class="container" style="background-color: #fff; overflow: hidden;">
        <div class="row">
            <!-- left content -->
            <div class="col-md-9">
                <!-- header caraousel -->
                <div class="row carousel-holder" style="margin-top: 20px;">

                    <div class="col-md-12">
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

							<ol class="carousel-indicators">
								<?php
									//$count = $datacount;
									$count = $datacount[0]->JUMLAH;

									for ($i=0; $i<$count; $i++) {
										echo '<li data-target="#carousel-example-generic" data-slide-to="'.$i.'"'; if($i==0){ echo 'class="active"'; } echo '></li>';
									}

								?>
                            </ol>

                            <div class="carousel-inner">
								<?php
									foreach($data as $hasil):

									if($hasil->ACTIVE==1){
										echo '<div class="item active"><img style="width:850px;height:300px;" class="slide-image" src="'.slider.$hasil->GAMBAR.'" alt="Tidak Ada Gambar"/></div>';
									}else{
										echo '<div class="item"><img style="width:850px;height:300px;" class="slide-image" src="'.slider.$hasil->GAMBAR.'" alt="Tidak Ada Gambar"/></div>';
									}

									endforeach
								?>
                            </div>

                            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>
                    </div>

                </div><!-- end header caraousel -->

                <!-- content -->
                <div class="row">

                    <div class="col-sm-4 col-lg-4 col-md-4">
					<?php foreach($datawizard as $h): ?>
                        <div class="thumbnail">
                            <a data-toggle="modal" href="#myModal2"><img src="<?php echo helpdesk.$h->GAMBAR; ?>" width="250" height="100" alt="gallery"> </a>
                            <!-- Modal -->
                            <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel"><strong><?php echo $h->JUDUL; ?></strong></h4>
                                        </div>
                                        <div class="modal-body">
                                            <img src="<?php echo helpdesk.$h->GAMBAR; ?>" alt="gallery">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
					<?php endforeach ?>
                    </div>

                    <div class="col-sm-4 col-lg-4 col-md-4">
					<?php foreach($databarbarian as $b): ?>
                        <div class="thumbnail">
                            <a data-toggle="modal" href="#myModal"><img src="<?php echo helpdesk.$b->GAMBAR; ?>" width="250" height="130" alt="gallery"> </a>
							<!-- Modal -->
							<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
							  <div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel"><strong><?php echo $b->JUDUL; ?></strong></h4>
								  </div>
								  <div class="modal-body">
									<img src="<?php echo helpdesk.$b->GAMBAR;  ?>" alt="gallery">
								  </div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
								  </div>
								</div>
							  </div>
							</div>
                        </div>
					<?php endforeach ?>
                    </div>

                    <div class="col-sm-4 col-lg-4 col-md-4">
						<?php foreach($databuilder as $giant): ?>
                        <div class="thumbnail" style="border:none;">
						<a href="<?php echo site_url($giant->URL); ?>" target="_blank">
                            <img src="<?php echo helpdesk.$giant->GAMBAR; ?>" width="250" height="130">
						</a>
                        </div>
						<?php endforeach ?>
                    </div>

                </div><!-- end content -->

            </div> <!-- end left content -->

            <!-- right content -->
            <div class="col-md-3">
                <div class="form-top">
                    LOGIN SAPM
                </div>
                <div class="form-login">
                <!-- login sapm  -->
                    <?php
                    $attributes = array('role' => 'form', 'class' => 'login-form', 'id' => 'frmlogin', 'name' => 'frmlogin' );
                    echo form_open('login/gologin', $attributes);
                    // echo form_open("#");
                    ?>

                        <div class="form-group">
                            <label class="sr-only" for="form-username">Username</label>
                            <input type="text" name="username"  placeholder="Username..." class="form-username form-control" id="username">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="form-password">Password</label>
                            <input type="password" name="password" placeholder="Password..." class="form-password form-control" id="password">
                        </div>
                        <input type="submit" id="btnlogin" class="btn btn-warning" value="Login">

                    <?php
                        echo form_close();
                    ?>
				
                </div> <!-- end login sapm  -->

                <br />
				<!-- banner -->
				<?php
					//print_r($databanner);
					foreach($databanner as $h) {
				?>
					<div>
						<a href="<?php echo $h->URL; ?>" target="_blank"><img src="<?php echo banner.$h->GAMBAR; ?>" alt="Tidak Ada Gambar" width="241" height="82"/></a>
					</div>
					<br />
				<?php
					}
				?>
				<!-- end banner -->

            </div> <!-- end right content -->

        </div>

    </div>
    <!-- /.container -->

<!-- load footer -->
<?php  echo $this->load->view('layout_login/footer.php'); ?>
<!-- load footer -->
