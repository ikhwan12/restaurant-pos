<div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
            <?=$title1;?>
        </h1>
      </section>
<!-- Main content -->
      <section class="content">
          <div class="row" style="margin-top: 10px;">
              <?php
                foreach ($tile_modul as $item){
                 
                    ?>
               <div class="col-lg-3 col-xs-6">
          <!-- small box -->
                  <div class="small-box bg-gray-active">
                    <div class="inner">
                        <h3><i class="fa <?=$item->icon;?>"></i></h3>

                      <p><?=$item->modul;?></p>
                    </div>
                    <div class="icon">
                      <i class="fa <?=$item->icon;?>"></i>
                    </div>
                    <a href="<?=$item->link;?>" class="small-box-footer">
                      Pilih <i class="fa fa-arrow-circle-right"></i>
                    </a>
                  </div>
                </div>
              <?php
                
                }
              ?>
             
                
          </div>
        <!-- /.box -->
      </section>
      <!-- /.content -->
        </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->