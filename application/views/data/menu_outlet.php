<div class="content-wrapper">
    <div class="container-fluid" style="padding-top: 0px;padding-bottom: 0px;">
      <!-- Content Header (Page header) -->
      <section class="content-header">
      </section>
<!-- Main content -->
      <section class="content">
          <div class="row">
              <div class="col-md-5">
                  <div class="box box-danger" style="border-left: 1px solid gray;border-right: 1px solid gray;display: block;height: 540px;"> 
                     <div class="box-header with-border">
                         <div class="row">
                             <div class="col-sm-2"><h3 class="box-title">Produk</h3></div>
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
                         <div class="direct-chat-messages" style="display: block;height: 450px;">
                          <table id="menu" class="table table-condensed table-hover" width="100%" cellspacing="0">
                              <thead>
                                  <tr style="height: 0px;">
                                    <th></th>
                                    <th style="width: 10%;"></th>
                                    <th ></th>
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
            <div class="col-md-7">
                <div class="box box-danger" style="border-left: 1px solid gray;border-right: 1px solid gray;display: block;height: 540px;"> 
                     <div class="box-header with-border">
                         <div class="row">
                             <div class="col-sm-3"><h3 class="box-title">Menu Outlet</h3></div>
                             <?php
                                        if($this->session->userdata('outlet') == ''){
                                        ?>
                             <div class="col-sm-9">
                                  <div class="form-group"> 
                                  <div class="col-sm-9 selectContainer">
                                        <select name="outlet" id="outlet" class="form-control" style="width: 100%">
                                        </select>
                                        </div>
                                  </div>
                             </div>
                             <?php
                                        }
                                        ?>
                                  
                         </div>
                      </div>
                     <div class="box-body">
                         <div class="direct-chat-messages" style="display: block;height: 450px;">
                          <table id="menu-outlet" class="table table-condensed table-hover" width="100%" cellspacing="0">
                              <thead>
                                  <tr style="height: 0px;">
                                    <th style="width: 10%;"></th>
                                    <th ></th>
                                    <th >Menu</th>
                                    <th>Harga</th>
                                    <th>Gojek</th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
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
  <script type="text/javascript">var outlet = "<?=$this->session->userdata('outlet');?>";</script>
  <script src="<?php echo base_url('assets/js/app/menu_outlet.js');?>"></script>
  
  <div class="example-modal">
  <div id="modal-confirm" class="modal fade">
      <div class="modal-dialog modal-info" style="vertical-align: middle;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="priceTitle"></h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" id="addUserForm">
                <div class="box-body">
                  <div class="form-group"> 
                        <label for="harga" class="col-sm-2 control-label">Harga</label> 
                        <div class="col-sm-9"> 
                            <input type="text" class="form-control" id="harga" name="harga" placeholder="Harga Biasa"> 
                        </div> 
                  </div> 
                  <div class="form-group"> 
                        <label for="harga_gojek" class="col-sm-2 control-label">Gojek</label> 
                        <div class="col-sm-9"> 
                            <input type="text" class="form-control" id="harga_gojek" name="harga_gojek" placeholder="Harga Gojek"> 
                        </div> 
                  </div> 
                </div>
                <input type="text" id="id_menu" name="id_menu" hidden>
                <input type="text" id="id" name="id" hidden>
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
      <div id="modal-info" class="modal modal-danger fade">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Info!</h4>
              </div>
              <div class="modal-body">
                <p>Menu sudah ditambahkan.</p>
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