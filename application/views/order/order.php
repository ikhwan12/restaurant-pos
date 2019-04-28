<div class="content-wrapper">
    <div class="container-fluid" style="padding-top: 0px;padding-bottom: 0px;">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          <?php $this->session->userdata('order');?>
          <div class="col-sm-12"><strong><span class="pull-right">No. Nota : <span id="noNota"></span></span></strong></div>
      </section>
<!-- Main content -->
      <section class="content">
          <div class="row no-gutter">
              <div class="col-md-2">
                  <div class="box box-success" style="display: block;height: 540px;">
                     <div class="box-body">
                         <div class="direct-chat-messages" id="box-kategori" style="height: 500px;">
                          <table id="kategori" class="table table-condensed table-hover" width="100%" cellspacing="0">
                              <thead style="display: none;">
                                  <tr>
                                    <th></th>
                                    <th></th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                         </div>
                     </div>
                 </div>
            </div>
              <div class="col-md-6">
                  <div class="box box-danger" style="border-left: 1px solid gray;border-right: 1px solid gray;display: block;height: 540px;"> 
                     <div class="box-header with-border">
                         <div class="row">
                             <div class="col-sm-7">
                                 <form class="sidebar-form" style="margin-top: 0px; margin-bottom: 0px;">
                                    <div class="input-group">
                                      <input type="text" name="searchmenu" id="searchmenu" class="form-control" placeholder="Search...">
                                          <span class="input-group-btn">
                                            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                                            </button>
                                          </span>
                                    </div>
                                  </form>
                             </div>
                         </div>
                      </div>
                     <div class="box-body">
                         <div class="direct-chat-messages" id="box-menu" style="height: 450px;">
                          <table id="menu" class="table table-condensed table-hover" width="100%" cellspacing="0">
                              <thead>
                                  <tr style="height: 0px;">
                                    <th></th>
                                    <th style="width: 5%;"></th>
                                    <th ></th>
                                    <th></th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                         </div>
                     </div>
                 </div>
            </div>
            <div class="col-md-4">
                <div class="box box-info"> 
                     <div class="box-header with-border ">
                         <div class="container-fluid">
                                 <input type="text" id="id_order" name="id_order" value="<?=$id_order;?>" hidden>
                                 <div class="row">
                                     <div class="col-xs-4">
                                         <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            <input type="text" id="customer" class="form-control" name="customer" placeholder="Customer" >
                                         </div>
                                     </div>
                                     <div class="col-xs-3">
                                            <div class="input-group">
                                                <span class="input-group-addon"><a href="<?=  site_url('order/assign_table/'.$id_order);?>" id='assign_table'><i class="fa fa-th"></i></a></span>
                                                <input type="text" id="no_meja" class="form-control" name="no_meja" placeholder="Meja" readonly>
                                             </div>
                                     </div>
                                     <div class="col-xs-1"></div>
                                     <div class="col-xs-2"><button class="btn btn-flat btn-info" id="list-order"><i class="fa fa-list-ol"></i></button></div>
                                     <div class="col-xs-2"><button class="btn btn-flat btn-info" id="meja"><i class="fa fa-th"></i></button></div>
                                 </div>
                         </div>
                      </div>
                     <div class="box-body">
                         <div class="direct-chat-messages" id="box-order" style="height: 183px;overflow-x: hidden;">
                          <table id="order" class="table table-condensed table-hover"  width="100%" cellspacing="0">
                              <thead>
                                  <tr style="height: 0px;">
                                    <th></th>
                                    <th style="width: 50%;"></th>
                                    <th style="width: 50%;"></th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                         </div>
                     </div>
                     <div class="box-footer" style="font-size: 12px;">
                         <div class="row">
                             <div class="col-xs-12">
                                <div class="table-responsive">
                                  <table class="table">
                                    <tr>
                                    <th>
                                    <div class="row" style="margin-left: 0px;">
                                        <div class="col-xs-3">Diskon</div> 
                                        <div class="col-xs-6">
                                            <div class="input-group">
                                                <input class="form-control input-sm" id="p_diskon" name="p_diskon" min="0" placeholder="Diskon">
                                               <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    </th>
                                    <td>
                                        <div class="row" style="margin-right: 0px;">
                                        <div class="col-xs-12">
                                            <div class="input-group pull-right">
                                               <span class="input-group-addon"><i class="fa">Rp. </i></span>
                                               <input class="form-control input-sm" id="diskon" name="diskon" type="number" min="0" placeholder="Diskon">
                                            </div>
                                        </div>
                                        </div>
                                    </td>
                                    </tr>
                                    <tr >
                                      <th style="width:50%">Subtotal:</th>
                                      <td class="pull-right">Rp. <span id="subtotal"></span></td>
                                    </tr>
                                    <tr>
                                      <th>PPN (<span id="ppn"></span>%)</th>
                                      <td class="pull-right">Rp. <span id="ppn_value"></span></td>
                                    </tr>
                                    <tr style="font-size: 20px;"> 
                                      <th>Total:</th>
                                      <td class="pull-right">Rp. <span id="total"></span></td>
                                    </tr>
                                  </table>
                                </div>
                              </div>
                         </div>
                         <div class="row">
                             <div class="col-sm-12">
                                 <a href="javascript:void(0)" id="simpanBtn" class="btn btn-sm btn-success btn-flat pull-left"><i class="fa fa-save"></i> Simpan</a>
                                 <a href="javascript:void(0)" id="hapusBtn" class="btn btn-sm btn-danger btn-flat pull-right"><i class="fa fa-remove"></i> Hapus</a>
                             </div>
                         </div>
                         <br>
                         <div class="row">
                             <div class="col-sm-12">
                                 <a href="javascript:void(0)" id="bayarBtn" class="btn btn-sm btn-primary btn-block btn-flat"><i class="fa fa-money"></i> Bayar</a>
                            </div>
                         </div>
                         
                      </div>
                 </div>
            </div>
            
          </div>
        <!-- /.box -->
      </section>
      <!-- /.content -->
        </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
    <div class="example-modal">
      <div id="modal-info" class="modal modal-info fade">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Ubah Kuantitas</h4>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" id="addUserForm">
                    <div class="box-body">
                      <div class="form-group"> 
                            <label for="qty" class="col-sm-2 control-label">Qty</label> 
                            <div class="col-sm-9"> 
                                <input type="number" class="form-control" min="0" id="qty" name="qty" placeholder="Jumlah"> 
                            </div> 
                      </div> 
                    </div>
                    <input type="text" id="id" name="id" hidden="">
                    <!-- /.box-body -->
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
    <div class="example-modal">
      <div id="modal-option" class="modal modal-info fade">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pilihan Menu</h4>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" id="opsiForm">
                    <div class="box-body">
                      <div class="form-group"> 
                            <label for="opsi" class="col-sm-2 control-label">Pilihan</label> 
                            <div class="col-sm-9"> 
                                <select id="opsi" name="opsi" class="form-control">
                                </select> 
                            </div>
                      </div> 
                      <div class="form-group"> 
                            <label for="jml" class="col-sm-2 control-label">Qty</label> 
                            <div class="col-sm-9"> 
                                <input type="number" class="form-control" min="1" id="jml" name="jml" placeholder="Jumlah"> 
                            </div>
                      </div> 
                    </div>
                    <input type="text" id="harga_om" name="harga_om" hidden>
                    <input type="text" id="id_order_wo" name="id_order_wo" hidden>
                    <input type="text" id="harga_modifier" name="harga_modifier" hidden>
                    <input type="text" id="idOm" name="idOm" hidden>
                    <!-- /.box-body -->
                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" id="opsiCancelBtn" class="btn btn-outline pull-left" data-dismiss="modal">Cancel</button>
                  <button type="button" id="opsiOKBtn" class="btn btn-outline">Save</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
      </div>
  
    <div class="alert-modal">
      <div id="modal-alert" class="modal modal-danger fade">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Info !</h4>
              </div>
              <div class="modal-body">
                  <p>Please assign your account into one of the outlets and relog.</p>
              </div>
              <div class="modal-footer">
                  <button type="button"class="btn btn-outline" data-dismiss="modal">Close</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
      </div>
  <script type="text/javascript">
      var outlet = "<?=$this->session->userdata('outlet');?>";
  </script>
  <script src="<?php echo base_url('assets/js/app/order.js');?>"></script>