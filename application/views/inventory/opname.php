<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="row">
              <div  class="col-sm-4 col-xs-4">
                  <button id="addBtn" class="btn btn-flat btn-primary"><i class="fa fa-plus"></i> </button>&nbsp;
                  <button id='editBtn' class="btn btn-flat btn-info"><i class="fa fa-edit"></i> </button>
              </div>
            <div class="col-sm-4 col-xs-4" style="font-size: 20px;font-weight: bold;text-align: center;"><?=  strtoupper($title1);?></div>
              <div class="col-sm-4 col-xs-4"></div>
          </div>
      </section>
<!-- Main content -->
      <section class="content">
        <div class="row" id="table-box">
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
                            <th>Lokasi</th> 
                            <th>Tanggal dan Waktu</th> 
                            <th>Catatan</th> 
                            <th>Petugas</th> 
                        </tr> 
                    </thead> 
                    <tbody> 
                    </tbody> 
                </table> 
                </div>
            </div>
        <!-- /.col -->
      </div>
          <div class="row" id="form-box">
            <!-- /.box-header -->
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-primary">
                    <div class="box-body">
                        <form class="form-horizontal" id="addUserForm">
                        <div class="row">
                        <div class="col-sm-6">
                              <div class="form-group"> 
                                    <label for="outlet" class="col-sm-2 control-label">Tanggal</label> 
                                    <div class="col-sm-9 selectContainer"> 
                                        <select class="form-control" id="outlet" name="outlet" style="width: 100%" > 
                                            <option value="">Pilih Outlet...</option>
                                        </select>    
                                    </div> 
                              </div> 
                              <div class="form-group"> 
                                    <label for="tanggal" class="col-sm-2 control-label">Tanggal</label> 
                                    <div class="col-sm-9"> 
                                        <input type="text" class="form-control" id="tanggal" name="tanggal" placeholder="Tanggal"> 
                                    </div> 
                              </div> 
                              <div class="form-group"> 
                                    <label for="note" class="col-sm-2 control-label">Note</label> 
                                        <div class="col-sm-9"> 
                                            <textarea  id="note" name="note" class="form-control" placeholder="Catatan"></textarea>
                                        </div> 
                              </div> 
                              
                            </div>
                            <input type="text" id="id" name="id" hidden>
                            <div class="col-sm-6">    
                                <div class="col-sm-6">
                                    <button type="button" id="detBtn" class="btn btn-flat btn-info"><i class="fa fa-search"></i> Detail</button>
                                </div>   
                            <div class="col-sm-12 bg-gray-light" style="padding: 10px;" id="rsp" hidden>
                              <div class="col-sm-12" >  
                                  <table class="table table-striped table-condensed" width="100%" id="rspTab">
                                      <thead>
                                         <th></th>
                                         <th>Produk</th>
                                         <th>Stok</th>
                                         <th>Real</th>
                                         <th>Variance</th>
                                      <thead>
                                    <tbody>
                                    </tbody>
                                  </table>  
                              </div>   
                              </div>   
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="box-footer">
                      <button type="button" id="cancelBtn" class="btn btn-danger">Cancel</button>
                      <button type="button" id="saveBtn" class="btn btn-success pull-right">Save</button>
                    </div>
                </div>
          <!-- /.box -->
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
   <script src="<?php echo base_url('assets/js/app/opname.js');?>"></script>