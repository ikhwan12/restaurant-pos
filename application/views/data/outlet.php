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
        
        <div class="col-md-6">
                <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title"><?=$table_title;?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-overflow">
                    <table class="table table-bordered table-striped" id="example"> 
                    <thead> 
                        <tr> 
                            <th></th> 
                            <th>Outlet</th> 
                            <th>Alamat</th> 
                            <th>PPN(%)</th> 
                        </tr> 
                    </thead> 
                    <tbody> 
                    </tbody> 
                </table> 
                </div>
            </div>
        </div>
            <div class="col-md-6">
            <!-- /.box-header -->
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <button class="btn btn-primary" id="addBtn">
                        Tambah Outlet
                      </button>
                    </h4>
                  </div>
                    <div class="box-body">
                      <form class="form-horizontal" id="addUserForm">
                        <div class="box-body">
                            <div class="form-group"> 
                                  <label for="outlet" class="col-sm-2 control-label">Outlet</label> 
                                  <div class="col-sm-9"> 
                                      <input type="text" class="form-control" id="nama_outlet" name="nama_outlet" placeholder="Nama Outlet"> 
                                  </div> 
                            </div> 
                             <div class="form-group"> 
                                    <label for="alamat" class="col-sm-2 control-label">Alamat</label> 
                                    <div class="col-sm-9"> 
                                        <textarea  id="alamat_outlet" name="alamat_outlet" class="form-control" placeholder="Alamat"></textarea>
                                    </div> 
                            </div>
                            <div class="form-group"> 
                                    <label for="telp" class="col-sm-2 control-label">No. Telp.</label> 
                                    <div class="col-sm-9"> 
                                        <input type="text" class="form-control" id="telp" name="telp" placeholder="Nomor Telepon"> 
                                    </div> 
                            </div>
                            <div class="form-group"> 
                                    <label for="ppn" class="col-sm-2 control-label">PPN</label> 
                                    <div class="col-sm-4"> 
                                        <div class="input-group">
                                            <input class="form-control" id="ppn" name="ppn" type="text" placeholder="PPN">
                                            <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                          </div>
                                    </div> 
                            </div>
                            <div class="form-group"> 
                                    <label for="printer" class="col-sm-2 control-label">Printer</label> 
                                    <div class="col-sm-9"> 
                                        <div class="input-group">
                                            <input class="form-control" id="printer" name="printer" type="text" placeholder="Printer"> 
                                            <span class="input-group-addon"><i class="fa fa-print"></i></span>
                                          </div>
                                    </div> 
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
   <script src="<?php echo base_url('assets/js/app/outlet.js');?>"></script>