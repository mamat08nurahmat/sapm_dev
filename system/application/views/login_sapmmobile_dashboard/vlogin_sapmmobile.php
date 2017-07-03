<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sapm Dashboard Monitoring Mobile</title>
		<link rel="shortcut icon" href="<?php echo favicon.'favicon.jpg' ?>"><!-- Favicon and touch icons -->
        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="<?php echo NEWCSS."bootstrap.min.css"; ?>">
        <link rel="stylesheet" href="<?php echo NEWCSS."font-awesome.min.css"; ?>">
		<link rel="stylesheet" href="<?php echo NEWCSS."form-elements-sapmmobile-dash.css"; ?>">
        <link rel="stylesheet" href="<?php echo NEWCSS."style-login-sapmmobile-dash.css"; ?>">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">

            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1>&nbsp;</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                            <h3><strong>Sapm Dashboard</strong> Monitoring Mobile</h3>

                            </div>
                            <div class="form-bottom">
								<?php
									$attributes = array('class' => 'login-form', 'role' => 'form');
									echo form_open('login_sapmmobile_dashboard/gologin', $attributes);
								?>
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Username</label>
			                        	<input type="text" name="username" placeholder="Username..." class="form-username form-control" id="username">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Password</label>
			                        	<input type="password" name="password" placeholder="Password..." class="form-password form-control" id="password">
			                        </div>
			                        <input type="submit" class="btn" id="btnlogin" value="LOGIN" />
								<?php
									echo form_close();
								?>
		                    </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>


        <!-- Javascript -->
        <script src="<?php echo NEWJS."jquery-1.11.1.min.js"; ?>"></script>
        <script src="<?php echo NEWJS."bootstrap.min.js"; ?>"></script>
     	<!--<script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/scripts.js"></script>-->

        <!--[if lt IE 10]>
		<script src="<?php echo NEWJS."placeholder.js"; ?>"></script>
        <![endif]-->

    </body>

</html>

<script type="text/javascript">
	/* Javascript validasi login */
	 $("#btnlogin").click(function(){
        if($("#username").val() == ''){
            alert ('Username Anda Tidak Boleh Kosong');
            username.focus();
            return false;
        }
        else if($("#password").val() == ''){
            alert ('Password Anda Tidak Boleh Kosong');
            password.focus();
            return false;
        } else {
            $("#btnlogin").show();
        }
    });
</script>	
