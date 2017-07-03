<?php 
	/*================== ROLE ===================*/ 
	$role_id = $_SESSION['ROLE_ID'];  
	/*================== ROLE ===================*/ 
?>
<div class="panel-group" >
	<div class="" style="border: 1px solid #008080;">
		<div style="background-color:#008080; font-weight:bold; color:#fff; border:none; display:block;  padding: 10px 0;text-align: center; ">DASHBOARD</div>
		<a href="<?php echo site_url('home_tax_amnesty'); ?>" class="list-group-item">Home</a>
		<a href="<?php echo site_url('prospek'); ?>" class="list-group-item">Prospek</a>
		<a href="<?php echo site_url('aktivitas'); ?>" class="list-group-item">Aktivitas</a>
		<a href="<?php echo site_url('aktivitas/vaktivitas'); ?>" class="list-group-item">Report Aktivitas</a>	
		<a href="<?php echo site_url('aktivitas/vclosing'); ?>" class="list-group-item">Report Closing</a>
		<?php
			if ($role_id == 3 || $role_id == 4 || $role_id == 5 || $role_id == 6) {
				
			}
			else{
		?>
				<a href="<?php echo site_url('prospek/upload_prospek'); ?>" class="list-group-item">Upload Data Prospek</a>
		<?php 
			}
		?>	

		<?php
			if ($role_id == 3 || $role_id == 4 || $role_id == 5 || $role_id == 6) {
				
			}
			else{
		?>	
		<a href="<?php echo site_url('usertax'); ?>" class="list-group-item">Manajemen User</a>
		<?php 
			}
		?>
		<a href="<?php echo site_url('login_tax_amnesty/logout'); ?>" class="list-group-item">Logout</a>
	</div>
</div>
			