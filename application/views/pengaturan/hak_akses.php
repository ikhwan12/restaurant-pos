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
        <div class="col-md-8">
            <!-- /.box-header -->
              <div class="box-group" id="accordion">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <div class="col-md-1" style="margin-bottom: 10px;">
                        <a href="<?=  site_url('posisi');?>" class="btn btn-info"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="col-md-6" style="margin-bottom: 10px;">
                    <select id="posisi" name="posisi" class="form-control select2" style="width: 100%;">
                    </select>
                    </div>
                    <h4 class="box-title">
                      <button class="btn btn-primary" id="okBtn">
                          <i class="fa fa-save"> Simpan</i>
                      </button>
                    </h4>
                   
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse">
                    <div class="box-body">
                    </div>
                  </div>
                </div>
              </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        
      </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title"><?=$table_title;?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-overflow">
                    <table class="table table-bordered table-striped" id="example"> 
                    <thead> 
                        <tr> 
                            <th>No.</th> 
                            <th>Menu</th> 
                            <th>Modul</th> 
                            <th>Akses</th> 
                        </tr> 
                    </thead> 
                    <tbody> 
                    </tbody> 
                </table> 
                </div>
            </div>
        </div>
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
   <script src="<?php echo base_url('assets/js/app/hak_akses.js');?>"></script>