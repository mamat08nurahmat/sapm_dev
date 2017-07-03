<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Aplikasi PHR Nasabah</title>
    <!-- Favicon BNI -->
    <link rel="shortcut icon" href="<?php echo favicon.'favicon.jpg' ?>">
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo NEWCSS."bootstrap.min.css"; ?>" rel="stylesheet"> 

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="background-color:#16434E; border-bottom:4px solid #D38429;">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo site_url('login_phr_nasabah/gologin') ?>" style="color:#fff;"><strong>APLIKASI</strong> PHR NASABAH</a>
            </div>

            <?php
                /*================== ROLE ===================*/
                $role_id = $_SESSION['ROLE_ID'];
                /*================== ROLE ===================*/
            ?>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="<?php echo site_url('login_phr_nasabah/gologin') ?>" style="color:#fff"><strong>HOME</strong></a>
                    </li>
                    <?php
                        //user biasa
                        if ($role_id == 3) {

                        }
                        else{
                    ?>
                    <li>
                        <a href="<?php echo site_url('phr_program') ?>" style="color:#fff"><strong>PROGRAM</strong></a>
                    </li>

                    <li>
                        <a href="<?php echo site_url('phr_program_cif') ?>" style="color:#fff"><strong>PROGRAM CIF</strong></a>
                    </li>

                    <li>
                        <a href="<?php echo site_url('phr_user') ?>" style="color:#fff"><strong>MANAJEMEN USER</strong></a>
                    </li>
                    <?php
                        }
                    ?>

                    <li>
                        <a href="<?php echo site_url('login_phr_nasabah/logout') ?>" style="color:#fff"><strong>LOGOUT</strong></a>
                    </li>

                    <!--<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color:#fff"><strong>KELUAR</strong> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#">Logout</a>
                            </li>
                        </ul>
                    </li>-->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <!-- Navigation --><br /><br /><br />
