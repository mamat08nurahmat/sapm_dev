<?php 
	/*================== ROLE ===================*/ 
	$role_id = $_SESSION['USER_LEVEL'];  
	/*================== ROLE ===================*/ 
?>
<div class="panel-group" >
	<div class="" style="border: 1px solid #008080;">
		<div style="background-color:#008080; font-weight:bold; color:#fff; border:none; display:block;  padding: 10px 0;text-align: center; ">DASHBOARD</div>
		<a href="<?php echo site_url('home_mobile_monitoring'); ?>"class="list-group-item">Home</a>
		<a href="<?php echo site_url('visit_mobile_monitoring'); ?>" class="list-group-item">Hasil Visit</a>
		<a href="<?php echo site_url('call_mobile_monitoring'); ?>" class="list-group-item">Hasil Call</a>
		<a href="<?php echo site_url('login_sapmmobile_dashboard/logout'); ?>" class="list-group-item">Logout</a>
	</div>
</div>
			


			