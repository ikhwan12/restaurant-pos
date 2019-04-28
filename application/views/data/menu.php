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
            <div class="col-sm-4 col-xs-4">
                <button id="importBtn"  class="btn btn-flat btn-default pull-right"><i class="fa fa-arrow-circle-up"></i> Import</button></a>
                <button id="exportBtn"  class="btn btn-flat btn-default pull-right"><i class="fa fa-arrow-circle-down"></i> Export</button></a>
            </div>
          </div>
      </section>
<!-- Main content -->
      <section class="content">
        <div id="loader"></div>
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
                            <th>Menu</th> 
                            <th>Harga</th> 
                            <th>Harga Gojek</th> 
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
                                    <label for="kategori" class="col-sm-2 control-label">Kategori</label>
                                    <div class="col-sm-9 selectContainer">
                                    <div class="input-group">
                                      <input type="text" name="kategori" id="kategori" class="form-control" placeholder="Kategori Menu">
                                          <span class="input-group-btn">
                                            <button type="button"  id="expand-btn" class="btn btn-flat "><i class="fa fa-angle-down"></i>
                                            </button>
                                          </span>
                                    </div>
                                    </div>
<!--                                    <div class="col-sm-9 selectContainer">
                                        <select name="kategori" id="kategori" class="form-control" style="width: 100%">
                                        </select>
                                    </div>-->
                              </div> 
                              <div class="form-group"> 
                                    <label for="menu" class="col-sm-2 control-label">Menu</label> 
                                    <div class="col-sm-9"> 
                                        <input type="text" class="form-control" id="menu" name="menu" placeholder="Nama Menu"> 
                                    </div> 
                              </div> 
                              <div class="form-group"> 
                                    <label for="deskripsi" class="col-sm-2 control-label">Deskripsi</label> 
                                        <div class="col-sm-9"> 
                                            <textarea  id="deskripsi" name="deskripsi" class="form-control" placeholder="Deskripsi"></textarea>
                                        </div> 
                              </div> 
                              <div class="form-group"> 
                                    <label for="price" class="col-sm-2 control-label">Harga</label> 
                                        <div class="col-sm-6"> 
                                            <input type="text" class="form-control" id="price" name="price" placeholder="Harga">
                                        </div> 
                              </div> 
                              <div class="form-group"> 
                                    <label for="gojek_price" class="col-sm-2 control-label">Gojek</label> 
                                        <div class="col-sm-6"> 
                                            <input type="text" class="form-control" id="gojek_price" name="gojek_price" placeholder="Harga Gojek">
                                        </div> 
                              </div>
                               <div class="form-group"> 
                                        <label class="col-sm-2 control-label"></label> 
                                        <div class="col-sm-6"> 
                                            <input type="checkbox" id="sold" name="sold" > Dijual
                                        </div> 
                                </div> 
                               <div class="form-group"> 
                                        <label class="col-sm-2 control-label"></label> 
                                        <div class="col-sm-6"> 
                                            <input type="checkbox" id="auto_assign" name="auto_assign" > Tambahkan ke Semua Gerai
                                        </div> 
                                </div> 
                               <div class="form-group">
                                        <label class="col-sm-2 control-label"></label> 
                                        <div class="col-sm-6"> 
                                            <input type="checkbox" id="manage_stock" name="manage_stock" > Kelola Stok
                                        </div> 
                                </div> 
                                <div class="form-group" id="div-satuan" hidden>
                                     <div class="col-sm-offset-2 col-sm-6">
                                        <label for="satuan">Satuan stok (misal: kg, gram, pcs)</label>
                                        <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Satuan">
                                     </div>
                                </div>
                            </div>
                            <input type="text" id="id" name="id" hidden>
                            <div class="col-sm-6">
<!--                                <div class="form-group"> 
                                    <label for="gojek_price" class="col-sm-2 control-label">Gambar</label> 
                                    <div class="col-sm-6"> 
                                        <div style="width: 120px;height: 120px; border: 1px solid grey">
                                            <img id="image" width="120px" height="120px" alt="No Image" style="line-height: 120px;vertical-align: middle;text-align: center;">
                                        </div>
                                         <input type="file" name="product-image">
                                    </div> 
                                </div>-->
                              <div class="col-sm-12 bg-gray-light" style="padding: 10px;margin-bottom: 10px;">
                              <div class="form-group">  
                                    <div class="col-sm-6"> 
                                        <input type="checkbox" id="piltam" name="piltam" > Pilihan Produk
                                    </div> 
                              </div>   
                                <div class="col-sm-12" id="pnt" hidden>  
                                    <input id="count" hidden>
                                  <table class="table table-striped table-condensed" width="100%" id="pntTab">
                                      <thead>
                                        <th>Nama</th>
                                        <th>Tampilan</th>
                                        <th>Harga</th>
                                        <th>Hapus</th>
                                      <thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2" ><a href="javascript:void(0);" id="addField"><i class="fa fa-plus"></i> Tambah Baru</a></th>
                                        </tr>
                                    </tfoot>
                                  </table>  
                                  
                              </div>   
                              </div>    
                                
                              <div class="col-sm-12 bg-gray-light" style="padding: 10px;">
                              <div class="form-group">  
                                    <div class="col-sm-6"> 
                                        <input type="checkbox" id="resep" name="resep" > Memiliki Resep
                                    </div> 
                              </div>   
                             <div class="col-sm-12" id="rsp" hidden>  
                                    <input id="count2" hidden>
                                  <table class="table table-striped table-condensed" width="100%" id="rspTab">
                                      <thead>
                                        <th>Bahan</th>
                                        <th>Jumlah</th>
                                      <thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2" ><a href="javascript:void(0);" id="addField2"><i class="fa fa-plus"></i> Tambah Bahan</a></th>
                                        </tr>
                                    </tfoot>
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
        <div id="modal-confirm" class="modal modal-info">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Upload Data Menu</h4>
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
                                    Browse&hellip; <input type="file" style="display: none;" accept=".xls,.xlsx" id="myfile">
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
   <script src="<?php echo base_url('assets/js/app/menu.js');?>"></script>