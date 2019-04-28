<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=$title;?></title>
  <link rel="shortcut icon" href="<?=  base_url('assets/images/logo_rent.jpg');?>"/>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
   <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?=  base_url('assets/bootstrap/css/bootstrap.min.css');?>">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?=  base_url('assets/plugins/datatables/dataTables.bootstrap.css');?>">
  <link href="<?php echo base_url('assets/css/buttons.dataTables.min.css');?>" rel="stylesheet"> 
  <link rel="stylesheet" href="<?=  base_url('assets/plugins/jQueryUI/jquery-ui.css');?>">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=  base_url('assets/css/font-awesome.min.css');?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=  base_url('assets/dist/css/AdminLTE.css');?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?=  base_url('assets/dist/css/skins/_all-skins.min.css');?>">
 
 <script src="<?=  base_url('assets/plugins/jQuery/jquery-2.2.3.min.js');?>"></script>
 <script src="<?=  base_url('assets/plugins/jQueryUI/jquery-ui.js');?>"></script>
</head>

<body  onload="window.print()">
<!-- Main content -->
      <section class="content">
          <div class="row">
              <div class="col-md-12">
                    <div class="tab-pane active" id="tab_1-1">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <h4><?=$outlet;?></h4>
                                    </div>
                                    <div class="box-body">
                                        <strong id="dateTime"><?=$date;?></strong>
                                        <h4>Ringkasan</h4>
                                        <table id="resumeTable" class="table">
                                            <thead>
                                            <tr>
                                              <th></th>
                                              <th class="text-center">Aktual</th>
                                              <th class="text-center">Terekam</th>
                                              <th class="text-center">Selisih</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 0;
                                                    foreach ($resume as $item) {
                                                        if($i == 2){
                                                            echo "<tr>"
                                                            . "<td><strong>".$item[0]."</strong></td>"
                                                            . "<td class='text-right'><strong>".$item[1]."</strong></td>"
                                                            . "<td class='text-right'><strong>".$item[2]."</strong></td>"
                                                            . "<td class='text-right'><strong>".$item[3]."</strong></td>"
                                                            . "</tr>";
                                                        }else{
                                                            echo "<tr>"
                                                            . "<td>".$item[0]."</td>"
                                                            . "<td class='text-right'>".$item[1]."</td>"
                                                            . "<td class='text-right'>".$item[2]."</td>"
                                                            . "<td class='text-right'>".$item[3]."</td>"
                                                            . "</tr>";
                                                        }
                                                        $i++;
                                                    }
                                                ?>
                                            </tbody>
                                          </table>
                                        <h4>Detail</h4>
                                        <table id="detailTable" class="table" width="200px">
                                            <thead style="display: none">
                                            <tr>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 0;
                                                    foreach ($detail as $item) {
                                                         if($i == 3){
                                                            echo "<tr>"
                                                            . "<td><strong>".$item[0]."</strong></td>"
                                                            . "<td class='text-right'><strong>".$item[1]."</strong></td>"
                                                            . "</tr>";
                                                        }else{
                                                            echo "<tr>"
                                                            . "<td>".$item[0]."</td>"
                                                            . "<td class='text-right'>".$item[1]."</td>"
                                                            . "</tr>";
                                                        }
                                                        $i++;
                                                    }
                                                ?>
                                            </tbody>
                                          </table>
                                        <h4>Ringkasan Penjualan</h4>
                                        <table id="rekapTable" class="table">
                                            <thead style="display: none">
                                            <tr>
                                              <th></th>
                                              <th>Aktual</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                              <td>Jumlah Penjualan</td>
                                              <td class="text-right"><strong id="jumlahJual"><?=$jumlah;?></strong></td>
                                            </tr>
                                            </tbody>
                                          </table>
                                    </div>
                                </div>
                           </div>
                            <div class="col-md-6">
                            </div>
                        </div>
                    </div>
              </div>
          </div>
      </section>
      <!-- /.content -->

  <!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/js/app/kasPrint.js');?>"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?=  base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>
<!-- DataTables -->
<script src="<?=  base_url('assets/plugins/datatables/jquery.dataTables.min.js');?>"></script>
<script src="<?=  base_url('assets/plugins/datatables/dataTables.bootstrap.min.js');?>"></script>
<!-- AdminLTE App -->
<script src="<?=  base_url('assets/dist/js/app.min.js');?>"></script>
</body>
</html>   