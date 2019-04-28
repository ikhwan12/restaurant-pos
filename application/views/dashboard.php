<div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
            Selamat Datang, <a href="<?php echo site_url('profile')?>"><?=$this->session->userdata('nama');?></a>.
        </h1>
       
      </section>
<!-- Main content -->
      <section class="content" id="test">
        <?php
            if(!$isChange){
                ?>
        <div class="callout callout-warning">
          <h4>Warning!</h4>

          <p>Password Anda masih sama dengan username Anda. Mohon ubah password Anda untuk keamanan. <i class="fa fa-smile-o"></i></p>
        </div>
        <?php
            }
        ?>
          <div class="row" style="margin-top: 20px;">
              <div class="col-lg-2"></div>
              <div class="col-lg-8 text-center">
                  <div class="box box-info" style="height: 400px; box-shadow: 0px 10px 5px #888888;background-color: red;">
<!--                      <p style="font-size: xx-large;margin-top: 120px;text-shadow: 2px 2px black;">Aplikasi Kasir Suprek</p>-->
                      <img src="<?=  base_url('assets/images/LOGO MR SUPREK.jpg');?>" style="max-height: 100%;max-width: 100%">
                  </div>
              </div>
              <div class="col-lg-2"></div>
          </div>
        <!-- /.box -->
      </section>
      <!-- /.content -->
        </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->