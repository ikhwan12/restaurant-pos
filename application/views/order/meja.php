
<div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          <div class="row">
              <div  class="col-sm-4">
                  <a href="<?=  site_url('order');?>" class="btn btn-flat btn-default"><i class="fa fa-arrow-left"></i> Order</button></a>&nbsp;
                  <button id='addBtn' class="btn btn-flat btn-warning"><i class="fa fa-plus"></i> Add</button>&nbsp;
                  <button id='detailBtn' class="btn btn-flat btn-primary"><i class="fa fa-edit"></i> Edit</button>
                  <button id='delBtn' class="btn btn-flat btn-danger"><i class="fa fa-trash"></i> Delete</button>
              </div>
              <div class="col-sm-4" style="font-size: 20px;font-weight: bold;text-align: center;">M E J A</div>
              <div class="col-sm-4"><button id='printBtn' class="btn btn-flat btn-info pull-right"><i class="fa fa-print"></i> Cetak Menu</button></div>
          </div>
      </section>
<!-- Main content -->
<section class="content" id="chair">
        <div id="loader"></div>
    <?php
        $jum_meja = sizeof($meja);
        $i = 0;
        foreach ($meja as $item) {
            if($item->id_order != NULL){
                $color = 'bg-red';
            }else{
                $color = 'bg-aqua';
            }
            if($i == 0){
    ?>
                <div class="row">
                <div class="col-lg-2 col-xs-4" style="margin-top: 20px;"  id="t<?=$item->no_meja;?>" draggable="true" ondragstart="drag('<?=$item->id_order;?>','<?=$item->no_meja;?>',event)"  ondragover="allowDrop(event)" ondrop="drop('<?=$item->no_meja;?>',event)">
                    <a href="javascript:void(0);" onclick="chBo('<?=$item->id_order;?>','<?=$item->no_meja;?>')" >
                        <div class="info-box-icon <?=$color;?> trans" id="dv<?=$item->no_meja;?>" style="width: 100px; height: 100px"><i class="fa"><?=$item->no_meja;?></i>
                        </div>
                    </a>
                </div>
    <?php
            }else if($i == $jum_meja - 1){
    ?>
                <div class="col-lg-2 col-xs-4" style="margin-top: 20px;"  id="t<?=$item->no_meja;?>" draggable="true" ondragstart="drag('<?=$item->id_order;?>','<?=$item->no_meja;?>',event)"  ondragover="allowDrop(event)" ondrop="drop('<?=$item->no_meja;?>',event)">
                <a href="javascript:void(0);" onclick="chBo('<?=$item->id_order;?>','<?=$item->no_meja;?>')" >
                    <div class="info-box-icon <?=$color;?> trans" id="dv<?=$item->no_meja;?>" style="width: 100px; height: 100px"><i class="fa"><?=$item->no_meja;?></i>
                    </div>
                </a>
                </div>
                </div>
    <?php
            }else if($i%6 == 0){
    ?>
                </div>
                <div class="row">
                <div class="col-lg-2 col-xs-4" style="margin-top: 20px;"  id="t<?=$item->no_meja;?>" draggable="true" ondragstart="drag('<?=$item->id_order;?>','<?=$item->no_meja;?>',event)"  ondragover="allowDrop(event)" ondrop="drop('<?=$item->no_meja;?>',event)">
                    <a href="javascript:void(0);" onclick="chBo('<?=$item->id_order;?>','<?=$item->no_meja;?>')" >
                        <div class="info-box-icon <?=$color;?> trans" id="dv<?=$item->no_meja;?>" style="width: 100px; height: 100px"><i class="fa"><?=$item->no_meja;?></i>
                        </div>
                    </a>
                </div>
    <?php
            }else{
    ?>
                <div class="col-lg-2 col-xs-4" style="margin-top: 20px;"  id="t<?=$item->no_meja;?>" draggable="true" ondragstart="drag('<?=$item->id_order;?>','<?=$item->no_meja;?>',event)"  ondragover="allowDrop(event)" ondrop="drop('<?=$item->no_meja;?>',event)">
                <a href="javascript:void(0);" onclick="chBo('<?=$item->id_order;?>','<?=$item->no_meja;?>')" >
                    <div class="info-box-icon <?=$color;?> trans" id="dv<?=$item->no_meja;?>" style="width: 100px; height: 100px"><i class="fa"><?=$item->no_meja;?></i>
                    </div>
                </a>
                </div>
    <?php
            }
            
            $i++;
        }
    ?>
            
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
                <h4 class="modal-title">Tambah Meja</h4>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" id="addUserForm">
                    <div class="box-body">
                      <div class="form-group"> 
                            <label for="no" class="col-sm-2 control-label">No</label> 
                            <div class="col-sm-9"> 
                                <input type="text" class="form-control" id="no" name="no" placeholder="No. Meja"> 
                            </div> 
                      </div> 
                    </div>
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
     <div class="alert-modal">
      <div id="modal-warn" class="modal modal-warning fade">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Warning!</h4>
              </div>
              <div class="modal-body">
                  <p id="warnTxt"></p>
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
<script src="<?php echo base_url('assets/js/app/meja.js');?>"></script>