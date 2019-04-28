<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Content Header (Page header) -->
      <section class="content-header">
      </section>
<!-- Main content -->
      <section class="content">
          <div class="row">
              <div class="col-md-12">
          <!-- Custom Tabs (Pulled to the right) -->
                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs pull-right">
                    <li class="active"><a href="#tab_1-1" data-toggle="tab">Rekap Kas</a></li>
                    <li><a href="#tab_2-2" data-toggle="tab">Kas Keluar</a></li>
                    <li><a href="#tab_3-2" data-toggle="tab">Kas Masuk</a></li>
                    <li class="pull-left header"><i class="fa fa-th"></i> <?=$title1;?></li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="tab_1-1">
                        <div class="row">
                            <div class="col-md-6">
                                <form class="form-horizontal" id="addUserForm2">
                                    <div class="box-body">
                                      <div class="form-group"> 
                                            <label for="tunai" class="col-sm-2 control-label">Tunai</label> 
                                            <div class="col-sm-5"> 
                                                <input type="text" class="form-control" id="tunai" name="tunai" placeholder="Tunai"> 
                                            </div> 
                                        </div> 
                                      <div class="form-group"> 
                                            <label for="kartu" class="col-sm-2 control-label">Kartu</label> 
                                            <div class="col-sm-5"> 
                                                <input type="text" class="form-control" id="kartu" name="kartu" placeholder="Kartu"> 
                                            </div> 
                                        </div> 
                                      <div class="form-group"> 
                                          <div class="col-sm-2"></div> 
                                          <div class="col-sm-5"> 
                                              <button id="saveRekap" class="btn btn-success pull-right">Save</button>
                                          </div>
                                        </div> 
                                    </div>
                                    <input type="text" id="id" name="id" hidden>
                                    <!-- /.box-body -->
                                    <!-- /.box-footer -->
                                  </form>
                                  <table id="rekapTable" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                      <th></th>
                                      <th>No</th>
                                      <th>Operator</th>
                                      <th>Tgl & Waktu</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    
                                    </tbody>
                                  </table>
                            </div>
                            <div class="col-md-6">
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <h4><?=$outlet;?></h4>
                                        <div class="box-tools pull-right">
                                            <button class="btn btn-info pull-right" id="printReport"><i class="fa fa-print"></i></button>
                                         </div>
                                    </div>
                                    <div class="box-body">
                                        <strong id="dateTime"><?=  date("d M Y H:i:s").' - '.date("d M Y H:i:s");?></strong>
                                        <h4>Ringkasan</h4>
                                        <table id="resumeTable" class="table">
                                            <thead>
                                            <tr>
                                              <th></th>
                                              <th>Aktual</th>
                                              <th>Terekam</th>
                                              <th>Selisih</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                          </table>
                                        <h4>Detail</h4>
                                        <table id="detailTable" class="table" width="200px">
                                            <thead style="height: 0px">
                                            <tr>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                          </table>
                                        <h4>Ringkasan Penjualan</h4>
                                        <table id="rekapTable" class="table">
                                            <thead style="display: none">
                                            <tr>
                                              <th></th>
                                              <th>Aktual</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                              <td>Jumlah Penjualan</td>
                                              <td class="text-right"><span id="jumlahJual">0</span></td>
                                            </tr>
                                            </tbody>
                                          </table>
                                    </div>
                                </div>
                           </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2-2">
                        <div class="row">
                            <div class="col-md-6">
                                <button id="addKeluarBtn" class="btn btn-primary">Tambah</button>
                            </div>
                            <div class="col-md-6">
                                <div id="tableBtn1" class="pull-right"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box-body table-overflow">
                                    <table class="table table-bordered table-striped" id="kas-keluar"> 
                                        <thead> 
                                            <tr> 
                                                <th>No</th> 
                                                <th>Tgl & Waktu</th> 
                                                <th>Keterangan</th> 
                                                <th>Jumlah</th> 
                                                <th>Petugas</th> 
                                            </tr> 
                                        </thead> 
                                        <tbody> 
                                        </tbody> 
                                    </table> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_3-2">
                        <div class="row">
                            <div class="col-md-6">
                                <button id="addMasukBtn" class="btn btn-primary">Tambah</button>
                            </div>
                            <div class="col-md-6">
                                <div id="tableBtn2" class="pull-right"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box-body table-overflow">
                                    <table class="table table-bordered table-striped" id="kas-masuk"> 
                                    <thead> 
                                        <tr> 
                                            <th></th> 
                                            <th>Tgl & Waktu</th> 
                                            <th>Keterangan</th> 
                                            <th>Jumlah</th> 
                                            <th>Petugas</th> 
                                        </tr> 
                                    </thead> 
                                    <tbody> 
                                    </tbody> 
                                </table> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                  </div>
                  <!-- /.tab-content -->
                </div>
                <!-- nav-tabs-custom -->
              </div>
          </div>
      </section>
      <!-- /.content -->
     
      
       </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  
  <div class="example-modal">
      <div id="modal-masuk" class="modal modal-info fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Kas Masuk</h4>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" id="addUserForm">
                    <div class="box-body">
                      <div class="form-group"> 
                            <label for="catatan" class="col-sm-2 control-label">Keterangan</label> 
                            <div class="col-sm-9"> 
                                <textarea  class="form-control" id="catatan" name="catatan" placeholder="Keterangan"></textarea> 
                            </div> 
                        </div> 
                      <div class="form-group"> 
                            <label for="jumlah" class="col-sm-2 control-label">Jumlah</label> 
                            <div class="col-sm-5"> 
                                <input type="text" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah"> 
                            </div> 
                        </div> 
                    </div>
                    <input type="text" id="idkas" name="idkas" hidden>
                    <!-- /.box-body -->
                    <!-- /.box-footer -->
                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" id="cancelBtn" class="btn btn-outline pull-left" data-dismiss="modal">Cancel</button>
                  <button type="button" id="saveBtn" class="btn btn-outline">Save</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
      </div>
   <script src="<?php echo base_url('assets/js/app/kas.js');?>"></script>