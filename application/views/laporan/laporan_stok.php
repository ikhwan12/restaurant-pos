<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Content Header (Page header) -->
      <section class="content-header">
           <div class="row">
               <div class="col-sm-4 col-xs-12" style="font-size: 20px;font-weight: bold;"><?=  strtoupper($title1);?></div>
              <div class="col-sm-5 col-xs-12">
                   
              </div>
              <div class="col-sm-2 col-xs-9">
                    
                        <select name="outlet" id="outlet" class="form-control" style="width: 100%">
                        </select>
              </div>
              <div class="col-sm-1 col-xs-1">
                  <button id="search" class="btn btn-info"><i class="fa fa-search"></i></button>
              </div>
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
                            <th>Kategori</th> 
                            <th>Produk</th> 
                            <th>Stok</th> 
                            <th>Satuan</th> 
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
  <script>var id_outlet = "<?=$this->session->userdata('outlet');?>";</script>
   <script src="<?php echo base_url('assets/js/app/laporan_stok.js');?>"></script>