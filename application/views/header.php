<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=$title;?></title>
  <link rel="shortcut icon" href="<?=  base_url('assets/images/logo_rent.jpg');?>"/>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
   <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?=  base_url('assets/bootstrap/css/bootstrap.min.css');?>">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?=  base_url('assets/plugins/datatables/dataTables.bootstrap.css');?>">
  <link href="<?php echo base_url('assets/css/buttons.dataTables.min.css');?>" rel="stylesheet"> 
   <!-- Select2 -->
  <link rel="stylesheet" href="<?=  base_url('assets/plugins/select2/select2.min.css');?>">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?=  base_url('assets/plugins/daterangepicker/daterangepicker.css');?>">
    <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?=  base_url('assets/plugins/datepicker/datepicker3.css');?>">
  <link rel="stylesheet" href="<?=  base_url('assets/plugins/jQueryUI/jquery-ui.css');?>">
   <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?=  base_url('assets/plugins/iCheck/all.css');?>">
  <link rel="stylesheet" href="<?=  base_url('assets/plugins/pace/pace.css');?>">
  <link rel="stylesheet" href="<?=  base_url('assets/plugins/jstree/style.min.css');?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=  base_url('assets/css/font-awesome.min.css');?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=  base_url('assets/css/ionicons.min.css');?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=  base_url('assets/dist/css/AdminLTE.css');?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?=  base_url('assets/dist/css/skins/_all-skins.min.css');?>">
  <link rel="stylesheet" href="<?=  base_url('assets/css/css-header.css');?>">
 
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  
 <script src="<?=  base_url('assets/plugins/jQuery/jquery-2.2.3.min.js');?>"></script>
 <script src="<?=  base_url('assets/plugins/jQueryUI/jquery-ui.js');?>"></script>
 <script type="text/javascript">
    var site_url = "<?=  site_url();?>"+"/";
    var base_url = "<?=  base_url();?>";
 </script>
<script src="<?=  base_url('assets/js/header-script.js');?>"></script>
</head>
<!-- jQuery 2.2.3 -->


<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-red layout-top-nav" onload="startTime();">
  <div class="wrapper">
  <div id="loader-c"></div>
  <header class="main-header">
    <nav class="navbar navbar-fixed-top" >
        <div class="container">
        <div class="navbar-custom-menu pull-left">
          <ul class="nav navbar-nav">
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-bars"></i></a>
          </li>
          </ul>
        </div>
         <div>
             <a href="<?=  site_url();?>" class="navbar-brand" style="text-align: center;"><b>Aplikasi</b> <span style="color: yellow">Kasir</span></a>
         </div>

        <!-- Collect the nav links, forms, and other content for toggling -->

        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <!-- Menu Toggle Button -->
              <a id="txt" class="dropdown-toggle"></a>
            </li>
            <li class="dropdown">
              <!-- Menu Toggle Button -->
                <a href="<?=  site_url("login/logout");?>" class="dropdown-toggle">
                <i class="fa fa-power-off"> Logout</i></a>
            </li>
            <!-- User Account Menu -->
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
  <aside class="control-sidebar control-sidebar-dark" style="position: fixed;z-index: 999999;padding-top: 5px;">
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="row">
            <div class="col-sm-12">
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-arrow-left pull-right" style="color: rgba(255, 255, 255, 0.8); font-size: 20px;"></i></a>
            </div>
        </div>
        <ul class="control-sidebar-menu">
          <li>
            <a href="<?=  site_url('profile');?>">
              <div class="row">  
              <div class="col-sm-4">  
              <img src="<?=  base_url('assets/images/icon-user-default.png')?>" class="user-image" alt="User Image">
              </div>
                  <div class="col-sm-8">
                <h4 class="control-sidebar-subheading"> <?php echo $this->session->userdata('nama')?></h4>
                <span style="color: white;"> <?=  $posisi?></span><br>
                <span style="color: white;"> <?=  date("d/m/Y");?></span>
              </div>
              </div>
            </a>
          </li>
        </ul>
        <div>
        <ul class="sidebar-menu">
           <?php
           foreach ($modul as $item) {
                        ?>
                    <li>
                        <a href="<?=  site_url($item->parent_link);?>" class="control-sidebar-subheading" style="font-size: 18px;">
                          <i class="fa <?=$item->parent_icon;?>"></i>  <span style="padding-left: 20px;"><?=$item->parent_modul;?></span>
                        </a>
                    </li>
            <?php
                }
           ?>
          
          <li>
            <a href="<?=  site_url("pengaturan");?>" class="control-sidebar-subheading" style="font-size: 18px;">
            <i class="fa fa-gears"></i>  <span style="padding-left: 20px;">Pengaturan</span>
            </a>
          </li>
          <li>
            <a href="<?=  site_url("support");?>" class="control-sidebar-subheading" style="font-size: 18px;">
            <i class="fa fa-info-circle"></i>  <span style="padding-left: 20px;">About</span>
            </a>
          </li>
        </ul>
      <!-- Home tab content -->
      
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- Full Width Column -->