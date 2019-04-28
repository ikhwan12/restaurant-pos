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
  <link rel="stylesheet" href="<?=  base_url('assets/plugins/pace/pace.css');?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=  base_url('assets/dist/css/AdminLTE.css');?>">
  <link rel="stylesheet" href="<?=  base_url('assets/css/login.css');?>">
  <link rel="stylesheet" href="<?=  base_url('assets/css/css-header.css');?>">
  <link rel="stylesheet" href="<?=  base_url('assets/css/wizard.css');?>">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
     <div id="loader"></div>  
        <div id="loader-c"></div>
    <section class="content">
    <!--<div class="background-image"></div>-->
    <div class="background-image"></div>
    <div class="container">
        <div class="row">   
        <div class="wizard" style="box-shadow: 10px 10px 5px black;">
            <div class="wizard-inner" >
                <div class="connecting-line"></div>
                <ul class="nav nav-tabs bg-blue-gradient" role="tablist">
 
                    <li role="presentation" data-form="db">
                        <a href="#step1" data-toggle="tab" aria-controls="setupdatabase" role="tab" title="Setup Database">
                            <span class="round-tab">
                                <i class="fa fa-database"></i>
                            </span>
                        </a>
                    </li>

                    <li role="presentation" data-form="activation">
                        <a href="#step2" data-toggle="tab" aria-controls="activation" role="tab" title="Activation">
                            <span class="round-tab">
                                <i class="fa fa-key"></i>
                            </span>
                        </a>
                    </li>
                    <li role="presentation" data-form="registration">
                        <a href="#step3" data-toggle="tab" aria-controls="registration" role="tab" title="Registration">
                            <span class="round-tab">
                                <i class="fa fa-file-text-o"></i>
                            </span>
                        </a>
                    </li>

                    <li role="presentation" data-form="success">
                        <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-ok"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>

                <div class="tab-content">
                    <div class="tab-pane" role="tabpanel" id="step1">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                        <h3>Setup Database</h3>    
                        <form class="form-horizontal" id="setting">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Hostname</label>
                                <div class="col-sm-10">
                                  <div class="input-group">
                                    <input type="text" class="form-control" name="host" placeholder="Hostname">
                                    <span class="input-group-addon"><i class="fa fa-server"></i></span>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Username</label>
                                <div class="col-sm-10">
                                  <div class="input-group">
                                    <input type="text" class="form-control" name="username" placeholder="Username">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Password</label>
                                <div class="col-sm-10">
                                  <div class="input-group">
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Database</label>
                                <div class="col-sm-10">
                                  <div class="input-group">
                                    <input type="text" class="form-control" name="database" placeholder="Database">
                                    <span class="input-group-addon"><i class="fa fa-database"></i></span>
                                  </div>
                                </div>
                            </div>
                          </form>
                        
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step2">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                        <h3>Activation</h3>    
                        <form class="form-horizontal" id="activation">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Serial Key</label>
                                <div class="col-sm-10">
                                  <div class="input-group">
                                    <input type="text" class="form-control" name="serial" placeholder="Serial Key">
                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                  </div>
                                </div>
                            </div>
                          </form>
                        
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step3">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                        <h3>Registrasi Admin</h3>    
                        <form class="form-horizontal" id="registration">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Posisi</label>
                                <div class="col-sm-10">
                                  <div class="input-group">
                                    <select class="form-control" name="id_posisi">
                                    </select>
                                    <span class="input-group-addon"><i class="fa fa-male"></i></span>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Username</label>
                                <div class="col-sm-10">
                                  <div class="input-group">
                                      <input type="text" class="form-control" name="id_user" placeholder="Username" readonly>
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Password</label>
                                <div class="col-sm-10">
                                  <div class="input-group">
                                    <input type="password" class="form-control" name="user_pass" placeholder="Password">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Nama</label>
                                <div class="col-sm-10">
                                  <div class="input-group">
                                    <input type="text" class="form-control" name="nama" placeholder="Nama">
                                    <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                  </div>
                                </div>
                            </div>
                          </form>
                        
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="complete">
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                        <i class="fa fa-check-square-o" style="font-size: 10em;color: green;display: block;vertical-align:middle;text-align:center;"></i>
                        </div>
                        <div class="col-md-4">
                        <h3>Complete</h3>
                        <p>You have successfully completed all steps.</p>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <div class="box-footer">
                 <div class="col-xs-12">
                     <button type="button" id="saveBtn" class="btn btn-primary btn-flat pull-right">Next <i class="fa fa-arrow-right"></i></button>
                  </div>
            </div>
        </div>
        </div>
        <div style="margin-top: 20px; text-align: center;">
            <strong style="color: white">&copy; 2016 - Developed by </strong><a href="http://indiglob.com" style="color: white">Indiglobal</a>.
        </div>   
    </section>
   <div class="example-modal">
      <div id="modal-info" class="modal modal-warning fade">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Info!</h4>
              </div>
              <div class="modal-body">
                <p id="message"></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
      </div>
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="<?=  base_url('assets/plugins/jQuery/jquery-2.2.3.min.js');?>"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?=  base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>
<script src="<?=  base_url('assets/plugins/pace/pace.min.js');?>"></script>
<!--<script src="<?=  base_url('assets/js/wizard.js');?>"></script>-->
<script type="text/javascript">var site_url = "<?=  site_url();?>/";</script>
<script src="<?=  base_url('assets/js/app/setup.js');?>"></script>
<!-- Form Validation -->
<script src="<?php echo base_url('assets/js/formValidation.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/framework_bootstrap.min.js');?>"></script>
</body>
</html>
