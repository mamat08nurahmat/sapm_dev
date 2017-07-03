<div class="panel-group" id="accordion">
	<div class="panel ">
	  <div class="panel-heading atasacordion">
		<h4 class="panel-title">
		  <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">DASHBOARD</a>
		</h4>
	  </div>
	  <div id="collapse1" class="panel-collapse collapse in">
		<div class="panel-body tengahacord">
			<a href="<?php echo site_url('home'); ?>">Home</a>
			<a href="<?php echo site_url('location'); ?>">Location</a>
			<a href="<?php echo site_url('visit'); ?>">Hasil Visit</a>
			<a href="<?php echo site_url('call'); ?>">Hasil Call</a>
		</div>
	  </div>
	</div>
	
	<div class="panel">
	  <div class="panel-heading atasacordion">
		<h4 class="panel-title">
		  <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">LOGOUT</a>
		</h4>
	  </div>
	  <div id="collapse2" class="panel-collapse collapse">
		<div class="panel-body tengahacord">
			<a  data-toggle="modal" href="<?php echo site_url('login/logout'); ?>">Logout</a>				
		</div>
	  </div>
	</div>
</div>
			