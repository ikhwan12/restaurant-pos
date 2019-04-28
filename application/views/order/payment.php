
<div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
       
      </section>
<!-- Main content -->
      <section class="content">
          <div class="row" id="payment_form" hidden>
              <div class="col-sm-6">
                  <div class="box box-primary bg-gray-light" style="height: 450px;">
                      <div class="box-header with-border">
                          <label class="form-control text-center bg-gray-light no-border">Total Belanja</label>
                      </div>
                      <div class="box-body">
                          <div class="row">
                              <div class="col-md-12">
                                  <input class="col-xs-12 text-center bg-blue-gradient calcs" type="text" name="total" size="16" id="total" value="" readonly>
                              </div>
                          </div>
                          <div class="row">
                                  <div class="col-md-3 col-xs-3"></div>
                                  <div class="col-md-6 col-xs-6">
                                      <label class="form-control bg-gray-light no-border text-center">Metode Pembayaran</label>
                                      <div class="form-group">
                                          <input type="radio" id="tunai" name="iCheck" value="tunai">
                                          <label for="tunai" style="margin-left: 10px;">TUNAI</label>
                                      </div>
                                      <div class="form-group">
                                          <input type="radio" id="kredit" name="iCheck" value="kredit">
                                          <label for="kredit" style="margin-left: 10px;">KREDIT</label>
                                      </div>
                                      <div class="form-group">
                                          <input type="radio" id="debit" name="iCheck" value="debit">
                                          <label for="debit" style="margin-left: 10px;">DEBIT</label>
                                      </div>
                                      <div id="dk-detail" style="padding: 2px;" hidden>
                                      <div class="form-group">
                                          <select class="form-control input-sm " id="bank" name="bank">
                                              <option value="" selected>Pilih Bank...</option>
                                              <option value="BNI">BNI</option>
                                              <option value="BCA">BCA</option>
                                              <option value="BRI">BRI</option>
                                              <option value="Mandiri">Mandiri</option>
                                          </select>
                                      </div>
                                      <div class="form-group">
                                          <input class="form-control input-sm " id="kartu" name="kartu" type="text" placeholder="No. Kartu">
                                      </div>
                                      </div>
                                      <input class="form-control" placeholder="Catatan" id="catatan" name="catatan" style="margin-top: 5px">
                                  </div>
                                  <div class="col-md-3 col-xs-3"></div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-sm-6">
                  <div class="box box-primary" style="height: 450px;">
                      <div class="box-header with-border">
                          <label class="form-control text-center no-border">Jumlah Bayar</label>
                      </div>
                      <div class="box-body">
                          <div class="row">
                              <div class="col-md-12">
                                  <input id="print" class="col-xs-12 text-center bg-black-gradient calcs" type="text" name="print" size="16">
                         
                              </div>
                          </div>
                          <div class="row ft-bg" style="margin-bottom:  10px;">
                                <div class="col-md-4 col-xs-4"><button class="btn btn-default btn-block btn-flat btn-lg" onClick="go(7);">7</button></div>
                                <div class="col-md-4 col-xs-4"><button class="btn btn-default btn-block btn-flat btn-lg" onClick="go(8);">8</button></div>
                                <div class="col-xs-4 col-xs-4"><button class="btn btn-default btn-block btn-flat btn-lg" onClick="go(9);">9</button></div>
                          </div>
                          <div class="row ft-bg" style="margin-bottom:  10px;">
                                <div class="col-xs-4 col-xs-4"><button class="btn btn-default btn-block btn-flat btn-lg" onClick="go(4);">4</button></div>
                                <div class="col-xs-4 col-xs-4"><button class="btn btn-default btn-block btn-flat btn-lg" onClick="go(5);">5</button></div>
                                <div class="col-xs-4 col-xs-4"><button class="btn btn-default btn-block btn-flat btn-lg" onClick="go(6);">6</button></div>
                          </div>
                          <div class="row ft-bg" style="margin-bottom:  10px;">
                                <div class="col-md-4 col-xs-4"><button class="btn btn-default btn-block btn-flat btn-lg" onClick="go(1);">1</button></div>
                                <div class="col-md-4 col-xs-4"><button class="btn btn-default btn-block btn-flat btn-lg" onClick="go(2);">2</button></div>
                                <div class="col-md-4 col-xs-4"><button class="btn btn-default btn-block btn-flat btn-lg" onClick="go(3);">3</button></div>
                          </div>
                          <div class="row ft-bg" style="margin-bottom:  10px;">
                                <div class="col-xs-4 col-xs-4"><button class="btn btn-default btn-block btn-flat btn-lg" onClick="go('clear');"><i class="fa fa-long-arrow-left"></i></button></div>
                                <div class="col-xs-4 col-xs-4"><button class="btn btn-default btn-block btn-flat btn-lg" onClick="go(0);">0</button></div>
                                <div class="col-xs-4 col-xs-4"><button type="button" id="pay" class="btn btn-success btn-block btn-flat btn-lg"><i class="fa fa-level-down gly-rotate-90"></i></button></div>
                          </div>
                          
                      </div>
                  </div>
              </div>
          </div>
          <div class="row" id="info_form" hidden>
              <div class="col-sm-12">
                  <div class="box box-primary bg-gray-light" style="height: 450px;">
                      <div class="box-body">
                          <div class="row">
                              <div class="col-md-6 col-xs-6">
                                  <i class="fa fa-check-square-o" style="height: 450px;padding-top: 150px;font-size: 10em;color: green;display: block;vertical-align:middle;text-align:center;"></i>
                              </div>
                              <div class="col-md-6 col-xs-6 text-center" style="height: 450px;padding-top: 125px;">
                                  <p style="font-size: 16px;"><strong>Kembali</strong></p>
                                  <p style="font-size: 30px;"><span id="kembali"></span></p>
                                  <p style="font-size: 20px;">Dibayar dengan <span id="cara"></span></p>
                                  <button id="selesai" class="btn btn-flat btn-success">Selesai</button>
                              </div>
                          </div>
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
  <div class="alert-modal">
      <div id="print-alert" class="modal modal-default fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Print Receipt?</h4>
              </div>
              <div class="modal-body">
                  <p>Klik "Yes" jika ingin mencetak struk.</p>
              </div>
              <div class="modal-footer">
                  <button id="yPrint" type="button"class="btn btn-success pull-right">Yes</button>
                  <button id="nPrint" type="button"class="btn btn-danger pull-left" data-dismiss="modal">No</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
      </div>
  <script>
      var id_order = "<?=$id_order;?>";
  </script>
  <script src="<?php echo base_url('assets/js/app/payment.js');?>"></script>