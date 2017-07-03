<?php $this->load->view('template/header') ?>	
<?php $this->load->view('template/topbar') ?>	
<?php $this->load->view('template/sidebar') ?>	
<!----------------------------------------------------->
<!--tambahkan custom Js disini-->

<!-- jQuery 2.1.3 ???-->
<script src="http://192.168.3.14/new_sapm/assetsLTE/AdminLTE-2-3-11/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<!-- Bootstrap 3.3.2 JS ???-->
<script src="http://192.168.3.14/new_sapm/assetsLTE/AdminLTE-2-3-11/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<!---=====================================--->
  <!-- Main content -->
 <section class="content">	
<!----===============================---->

	
	<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
            Selamat Datang : <strong><?php echo $_SESSION['USER_NAME'];?></strong>
    </div>
</section>	


<section class="content-header">
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
    	<img src="http://192.168.3.14/new_sapm/public/images/toolbar/icon-48-article.png" align="middle" /> 
                    Berita <strong>SAPM</strong>
    </div>
</section>	

  <!-- ROW -->
    <div class="row">
        <div class="col-xs-12">
<br/>
<?php
// print_r($news);   
	foreach($news as $row){
?>		
			

                <ul>
                   <li>
				   <font color="blue">
				   <b><?php echo $row->JUDUL." "."(".$row->TANGGAL.")"  ; ?></b>
				   </font>
				   </li>

                	<div style="color:#000; margin:0px 0px">
					<?php echo $row->ISI; ?>
                	</div>
                </ul>			
			
<!----
                <ul>
                   <li><font color="blue"><b>Perpanjangan Waktu Redeem Poin Program SGP ( 10-OCT-16 )</b></font></li>

                	<div style="color:#000; margin:0px 0px">
                		Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting
                	</div>
                </ul>
---->			



         
    <!-- /.content -->
    <br/>
<?php			
		}
?>

		
		

         </div>
    </div>
  <!-- ROW END-->

<!----===============================---->
</section>
<!----===============================---->
<!------------------------------------------------------------->
<?php $this->load->view('template/js') ?>	
<?php $this->load->view('template/footer') ?>	
