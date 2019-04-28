<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Content Header (Page header) -->
      <section class="content-header">
         <div class="row">
              <div  class="col-sm-4">
<!--                  <button id="importBtn"  class="btn btn-flat btn-default"><i class="fa fa-arrow-circle-up"></i> Import</button></a>
                  <button id="exportBtn"  class="btn btn-flat btn-default"><i class="fa fa-arrow-circle-down"></i> Export</button></a>-->
              </div>
              <div class="col-sm-4" style="font-size: 20px;font-weight: bold;text-align: center;"><?=$title1;?></div>
              <div class="col-sm-4"></div>
          </div>
      </section>
<!-- Main content -->
      <section class="content">
        <div class="row">
        
        <div class="col-md-6">
                <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body table-overflow" >
                    <table class="table table-bordered table-striped" id="example"> 
                    <thead> 
                        <tr> 
                            <th>No.</th> 
                            <th></th> 
                            <th>Kategori</th> 
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
                        Tambah Kategori
                      </button>
                    </h4>
                  </div>
                    <div class="box-body">
                      <form class="form-horizontal" id="addUserForm">
                        <div class="box-body">
                          <div class="form-group"> 
                                <label for="kategori" class="col-sm-2 control-label">Kategori</label> 
                                <div class="col-sm-9"> 
                                    <input type="text" class="form-control" id="kategori" name="kategori" placeholder="Nama Kategori"> 
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
        <div id="modal-confirm" class="modal modal-info">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Upload Data Kategori</h4>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" id="uploadForm">
<!--                        <label class="btn btn-default btn-file">
                            Browse <input type="file" id="myfile" style="display: none;">
                        </label>-->
                        <h4>Input File Excel</h4>
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn-primary">
                                    Browse&hellip; <input type="file" style="display: none;" id="myfile">
                                </span>
                            </label>
                            <input id="filename" type="text" class="form-control" readonly>
                        </div>
                  </form>
              </div>
              <div class="modal-footer">
                <button type="button" id="noBtn" class="btn btn-outline pull-left" data-dismiss="modal">Batal</button>
                <button type="button" id="uploadSubmitBtn" class="btn btn-outline">Upload</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
      </div>
   <script src="<?php echo base_url('assets/js/app/kategori.js');?>"></script>