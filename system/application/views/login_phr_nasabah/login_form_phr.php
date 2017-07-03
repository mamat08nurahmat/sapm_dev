<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login Aplikasi PHR Nasabah</title>
	<link rel="shortcut icon" href="<?php echo favicon.'favicon.jpg' ?>"><!-- Favicon and touch icons -->

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo NEWCSS.'bootstrap.min.css'; ?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo NEWCSS.'style-login-phr.css'; ?>" rel="stylesheet">



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body style="background-color: #16434E;">

    	<div class="container">
			<div class="row main">
				<div class="panel-heading">
	               <div class="panel-title text-center">
	               		<h1 class="title">Login Aplikasi PHR</h1>
	               		<hr />
	               	</div>
	            </div>
				<div class="main-login main-center">
					<?php
						$attributes = array('class' => 'form-horizontal');
						echo form_open('login_phr_nasabah/check_login_form', $attributes);
					?>

						<div class="form-group">
							<label for="username" class="cols-sm-2 control-label">Username</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="username" id="username"  placeholder="Enter your Username"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="password" class="cols-sm-2 control-label">Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<input type="password" class="form-control" name="password" id="password"  placeholder="Enter your Password"/>
								</div>
							</div>
						</div>

						<div class="form-group ">
							<input type="submit" name="login" class="btn btn-warning btn-lg btn-block login-button" value="Login" />
						</div>

					<?php
						echo form_close();
					?>
					</form>
				</div>
			</div>
		</div>

</body>

</html>
