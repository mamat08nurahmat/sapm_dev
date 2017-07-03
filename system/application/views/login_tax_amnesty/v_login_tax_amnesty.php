<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Tax Amnesty Monitoring</title>
    <link rel="shortcut icon" href="<?php echo favicon.'favicon.jpg' ?>"><!-- Favicon and touch icons -->
    <link href="<?php echo NEWCSS.'bootstrap.min.css' ?>" rel="stylesheet"> <!-- Bootstrap Core CSS -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style>
		body {
			padding-top: 40px;
		  	padding-bottom: 40px;
		  	background: url(<?php echo bg_tax.'bg-tax.jpg'; ?>) no-repeat center center fixed;
		  	-webkit-background-size: cover;
		  	-moz-background-size: cover;
		  	-o-background-size: cover;
		  	background-size: cover;
		}
    </style>
</head>
<body>
	    <div class="container">
        <div  style="margin-top:100px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info" >
                    <div class="panel-default" style="background-color:#FF9934; padding:10px 20px">
                        <div class="panel-title text-center" style="color:#fff; font-weight:bold;"><small>TAX AMNESTY MONITORING</small></div>
                        <!--<div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Forgot password?</a></div>-->
                    </div>

                    <div style="padding-top:30px" class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                        <!-- form login -->
                        <?php
							$attributes = array('role' => 'form', 'class' => 'form-horizontal', 'id' => 'loginform');
							echo form_open('login_tax_amnesty/check_login_form', $attributes);
						?>
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input id="username" type="text" class="form-control" name="username" value="" placeholder="username">
                                    </div>

                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="password" type="password" class="form-control" name="password" placeholder="password">
                                    </div>



                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->

                                    <div class="col-sm-12 controls">
                                     <!-- <a id="btn-login" href="#" class="btn " >Login  </a>-->
								      <p class="text-right"><input type="submit" name="login" class="btn" value="Login" style="background-color:#339AAF; color:#fff; font-weight:bold">
                                    </p></div>
                                </div>
						<?php
							echo form_close();
						?>
	                    <!-- end form login -->


                        </div>
                    </div>
        </div>

    </div>

</body>
</html>
