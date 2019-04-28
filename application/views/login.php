<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $title;?></title>
  <link rel="shortcut icon" href="<?=  base_url('assets/images/logo_rent.jpg');?>"/>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?=  base_url('assets/bootstrap/css/bootstrap.min.css');?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=  base_url('assets/css/font-awesome.min.css');?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=  base_url('assets/css/ionicons.min.css');?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=  base_url('assets/dist/css/AdminLTE.css');?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?=  base_url('assets/plugins/iCheck/square/blue.css');?>">
  <link rel="stylesheet" href="<?=  base_url('assets/css/login.css');?>">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
    <div class="background-image"></div>
   
  <div class="login-box">
  <div class="login-logo">
      <a href=""><b style="color: greenyellow;  text-shadow: 2px 2px black;">Login Aplikasi</b> <span style="color: lime;text-shadow: 2px 2px grey;"></span></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body" style="box-shadow: 10px 10px 5px black;">
    <p class="login-box-msg">Masukkan <i>username</i> dan <i>password</i></p>
    <div style="color: red">
    <?php 

    if($this->session->flashdata('login_error'))
      {
              echo '<i>Username</i> atau <i>password</i> salah.';
      }

    ?>
    </div>
    <form action="<?php echo site_url('login/check_login')?>" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="username" placeholder="Username" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Log In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
  <div style="margin-top: 20px; text-align: center;">
      <strong style="color: white">&copy; 2016 - Developed by </strong><a href="http://indiglob.com" style="color: white">Indiglobal</a>.
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="<?=  base_url('assets/plugins/jQuery/jquery-2.2.3.min.js');?>"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?=  base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>
<!-- iCheck -->
<script src="<?=  base_url('assets/plugins/iCheck/icheck.min.js');?>"></script>

</body>
</html>
