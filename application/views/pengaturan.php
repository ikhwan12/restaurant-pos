<div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
      </section>
<!-- Main content -->
      <section class="content">
          <div class="row">
              <div class="col-md-6">
            <!-- /.box-header -->
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                        Pengaturan Outlet
                    </h4>
                  </div>
                    <div class="box-body">
                        <form class="form-horizontal" id="addUserForm" method="post" action="<?=  site_url('pengaturan/update');?>">
                        <div class="box-body">
                          <div class="form-group"> 
                                <label for="printer" class="col-sm-2 control-label">Printer</label>
                                <div class="col-sm-9 selectContainer">
                                    <select name="printer" id="printer" class="form-control" style="width: 100%" required>
                                    </select>
                                </div>
                          </div> 
                        </div>
                        <input type="text" id="id" name="id" hidden>
                        <!-- /.box-body -->
                        <div class="box-footer">
                          <button type="submit" id="saveBtn" class="btn btn-success pull-right">Save</button>
                        </div>
                        <!-- /.box-footer -->
                      </form>
                    </div>
                </div>
          <!-- /.box -->
        </div>
          </div>
      </section>
      <!-- /.content -->
        </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  <script src="<?php echo base_url('assets/js/app/pengaturan.js');?>"></script>