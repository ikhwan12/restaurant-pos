<div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
            Contact & Support
        </h1>
       
      </section>
<!-- Main content -->
      <section class="content" id="test">
           <div class="alert alert-info alert-dismissible">
            <h4><i class="icon fa fa-phone"></i> Contact Person</h4>
            <p>Ikhwan : +62 877 8989 4688</p>
          </div>
          <div class="row">
              <div class="col-sm-12">
                  <button class="btn btn-flat btn-info pull-right" id="updateBtn"><i class="fa fa-refresh"></i> Update </button>
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
        <div id="modal-confirm" class="modal modal-info">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Upload Update File</h4>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" id="uploadForm">
                        <h4>Input Zip File</h4>
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
  <script>var previlage = "<?=$this->session->userdata('posisi');?>"</script>
     <script src="<?php echo base_url('assets/js/app/support.js');?>"></script>