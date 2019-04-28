<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Content Header (Page header) -->
      <section class="content-header">
           <div class="row">
              <div  class="col-sm-4">
                  <a href="<?=  site_url('order');?>" class="btn btn-flat btn-default"><i class="fa fa-arrow-left"></i> Order</button></a>
              </div>
              <div class="col-sm-4" style="font-size: 20px;font-weight: bold;text-align: center;">LIST ORDER</div>
              <div class="col-sm-4"></div>
          </div>
      </section>
<!-- Main content -->
      <section class="content">
          
        <div class="row">
        
            <div class="col-md-12">
                <div class="box box-primary">
                <!-- /.box-header -->
                <div class="box-body table-overflow">
                    <table class="table table-bordered table-striped" id="example" width="100" cellspacing="0"> 
                    <thead> 
                        <tr> 
                            <th>ID</th> 
                            <th>Tanggal</th> 
                            <th>Operator</th> 
                            <th>Customer</th> 
                            <th>Item</th> 
                            <th>Total</th> 
                            <th>Action</th> 
                        </tr> 
                    </thead> 
                    <tbody> 
                    </tbody> 
                </table> 
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
  
   <script src="<?php echo base_url('assets/js/app/list_order.js');?>"></script>