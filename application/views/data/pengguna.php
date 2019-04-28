<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          <?=$title1;?>
        </h1>
       
      </section>
<!-- Main content -->
      <section class="content">
        <div class="row">
        <div class="col-md-7">
                <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title"><?=$table_title;?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-overflow">
                    <table class="table table-bordered table-striped" id="example"> 
                    <thead> 
                        <tr> 
                            <th>ID</th> 
                            <th>Nama</th> 
                            <th>Alamat</th> 
                            <th>No. Telp</th> 
                            <th>Posisi</th> 
                            <th>Outlet</th> 
                            <th>Aktif</th> 
                            <th>Status</th> 
                        </tr> 
                    </thead> 
                    <tbody> 
                    </tbody> 
                </table> 
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <!-- /.box-header -->
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <button class="btn btn-primary" id="addBtn">
                        Tambah Pengguna
                      </button>
                    </h4>
                  </div>
                    <div class="box-body">
                      <form class="form-horizontal" id="addUserForm">
                        <div class="box-body">
                           <div class="form-group">
                                    <label for="previlage" class="col-sm-2 control-label">Posisi</label>
                                    <div class="col-sm-9 selectContainer">
                                        <select name="id_posisi" id="id_posisi" class="form-control" style="width: 100%">
                                        </select>
                                    </div>
                                    <a href="<?=  site_url().'/posisi';?>" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i></a>
                           </div>
                          <div class="form-group"> 
                            <label for="username" class="col-sm-2 control-label">Username</label> 
                            <div class="col-sm-9"> 
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" readonly> 
                            </div> 
                            </div> 
                            <div class="form-group"> 
                                    <label for="password" class="col-sm-2 control-label">Password</label> 
                                    <div class="col-sm-9"> 
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password"> 
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
                                    <label for="no_telp" class="col-sm-2 control-label">No. Telp.</label> 
                                    <div class="col-sm-9"> 
                                        <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="Nomor Telepon"> 
                                    </div> 
                            </div>
                            
                            <div class="form-group"> 
                                    <label for="aktif" class="col-sm-2 control-label">Aktif</label> 
                                    <div class="col-sm-4"> 
                                        <select class="form-control" id="aktif" name="aktif">
                                            <option value="">Pilih Status...</option>
                                            <option value="1">Aktif</option>
                                            <option value="0">Non Aktif</option>
                                        </select> 
                                    </div> 
                                    <div class="col-sm-5 selectContainer">
                                        <select name="outlet" id="outlet" class="form-control" style="width: 100%">
                                        </select>
                                    </div>
                                     <a href="<?=  site_url().'/outlet';?>" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <input type="text" id="id" name="id" hidden>
                        <!-- /.box-body -->
                        <div class="box-footer">
                          <button type="button" id="cancelBtn" class="btn btn-danger">Cancel</button>
                          <button type="button" id="saveBtn" class="btn btn-success pull-right">Save</button>
                        </div>
                        <!-- /.box-footer -->
                      </form>
                    </div>
                </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        
      </div>
      </section>
      <!-- /.content -->
     
      
       </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  
  
  <div class="example-modal">
        <div id="modal-confirm" class="modal modal-warning">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Warning!</h4>
              </div>
              <div class="modal-body">
                <p>Anda yakin ingin menghapus data ini?</p>
              </div>
              <div class="modal-footer">
                <button type="button" id="noBtn" class="btn btn-outline pull-left" data-dismiss="modal">Tidak</button>
                <button type="button" id="yesBtn" class="btn btn-outline">Ya</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
      </div>
   <script src="<?php echo base_url('assets/js/app/pengguna.js');?>"></script>