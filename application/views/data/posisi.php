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
        <div class="col-md-4">
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
                            <th>Posisi</th> 
                        </tr> 
                    </thead> 
                    <tbody> 
                    </tbody> 
                </table> 
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- /.box-header -->
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <button class="btn btn-primary" id="addBtn">
                        Tambah Posisi
                      </button>
                    </h4>
                  </div>
                    <div class="box-body">
                      <form class="form-horizontal" id="addUserForm">
                        <div class="box-body">
                          <div class="form-group"> 
                                <label for="posisi" class="col-sm-2 control-label">Posisi</label> 
                                <div class="col-sm-9"> 
                                    <input type="text" class="form-control" id="posisi" name="posisi" placeholder="Posisi"> 
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
            <div class="col-md-4">
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      Hak Akses Posisi
                    </h4>
                  </div>
                    <div class="box-body">
                     <div id="tree">
                    </div>
                    </div>
                    <div class="box-footer">
                      <button type="button" id="cancelBtn2" class="btn btn-danger">Cancel</button>
                      <button type="button" id="saveBtn2" class="btn btn-success pull-right">Save</button>
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
   <script src="<?php echo base_url('assets/js/app/posisi.js');?>"></script>