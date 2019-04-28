<div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          <?=$title1;?>
        </h1>
       
      </section>
<!-- Main content -->
      <section class="content">
        
        <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-info">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?=  base_url('assets/images/icon-user-default.png')?>" alt="User profile picture">

              <h3 class="profile-username text-center" id="nama_txt"></h3>

              <p class="text-muted text-center" id="posisi_txt"></p>
              
              <hr>
              
              <strong><i class="fa fa-map-marker margin-r-5"></i> Address</strong>

              <p class="text-muted" style="margin-left: 15px;" id="address_txt">
              </p>

              <hr>

              <strong><i class="fa fa-phone margin-r-5"></i> Telp.</strong>

              <p class="text-muted"  style="margin-left: 15px;" id="telp_txt"></p>
              
              <hr>

              <a href="<?php echo site_url('login/logout')?>" class="btn btn-danger btn-block"><b><i class="fa fa-sign-out"></i> Log Out </b></a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-7">
                    <div class="box box-info">
                    <div class="box-header with-border">
                      <h3 class="box-title">Detail Profile</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal" id="form1" action="<?php echo site_url('profile/update_detail')?>" method="post">
                      <div class="box-body">
                          <div class="form-group"> 
                            <label for="username" class="col-sm-2 control-label">Username</label> 
                            <div class="col-sm-9"> 
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" readonly> 
                            </div> 
                            </div> 
                            <div class="form-group"> 
                                <label for="nama" class="col-sm-2 control-label">Nama</label> 
                                <div class="col-sm-9"> 
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap"> 
                                </div> 
                            </div> 
                            <div class="form-group"> 
                                    <label for="alamat" class="col-sm-2 control-label">Alamat</label> 
                                    <div class="col-sm-9"> 
                                        <textarea  id="alamat" name="alamat" class="form-control" placeholder="Alamat"></textarea>
                                    </div> 
                            </div>
                            <div class="form-group"> 
                                    <label for="no_telp" class="col-sm-2 control-label">Telp.</label> 
                                    <div class="col-sm-9"> 
                                        <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="Nomor Telepon"> 
                                    </div> 
                            </div>
                      </div>
                      <!-- /.box-body -->
                      <div class="box-footer">
                        <button type="submit" class="btn btn-info pull-right">Save</button>
                      </div>
                      <!-- /.box-footer -->
                    </form>
                  </div>
                </div>
                <div class="col-md-5">
                    <div class="box box-info">
                    <div class="box-header with-border">
                      <h3 class="box-title">Ubah Password</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal" id="form2" action="<?php echo site_url('profile/update_password')?>" method="post">
                      <div class="box-body">
                        <div class="form-group">
                          <label for="pass" class="col-sm-3 control-label">New</label>

                          <div class="col-sm-8">
                              <input type="password" class="form-control" id="pass" name="pass" placeholder="Password">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="v_pass" class="col-sm-3 control-label">Verify</label>

                          <div class="col-sm-8">
                              <input type="password" class="form-control" id="v_pass" name="v_pass" placeholder="Verify Password">
                          </div>
                        </div>
                      </div>
                      <!-- /.box-body -->
                      <div class="box-footer">
                        <button type="submit" class="btn btn-info pull-right">Save</button>
                      </div>
                      <!-- /.box-footer -->
                    </form>
                  </div>
                </div>
            </div>
        </div>
        <!-- /.col -->
        </div>
        
      </section>
      <!-- /.content -->
     
      
       </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  
  
   <script src="<?php echo base_url('assets/js/app/profile.js');?>"></script>