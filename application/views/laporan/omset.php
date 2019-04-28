<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Content Header (Page header) -->
      <section class="content-header">
      </section>
<!-- Main content -->
      <section class="content">
          <div class="row">
              <div class="col-md-12">
              <div class="box">
                  <div class="box-body">
                      <div class="col-sm-4 col-xs-12" style="font-size: 20px;font-weight: bold;">GRAFIK PENJUALAN</div>
              <div class="col-sm-5 col-xs-12">
                    <button type="button" class="btn btn-info pull-right" id="daterange-btn">
                      <span></span>
                      <i class="fa fa-caret-down"></i>
                    </button>
              </div>
              <div class="col-sm-2 col-xs-9">
                        <select name="outlet" id="outlet" class="form-control" style="width: 100%">
                        </select>
              </div>
              <div class="col-sm-1 col-xs-1">
                  <button id="search" class="btn btn-info"><i class="fa fa-search"></i></button>
              </div>
                  </div>
                  </div>
                  </div>
           </div>
              
          <div class="row">
              <div class="col-md-12">
                <!-- LINE CHART -->
                <div class="box box-info">
                  <div class="box-body">
                      <div class="chart" style="height:270px;">
                          <canvas id="lineChart" style="height:270px;"></canvas>
                      </div>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>
          </div>
          <div class="row">
            <div class="col-md-4">
                <!-- BAR CHART -->
                <div class="box box-success">
                  <div class="box-body">
                    <div class="chart2">
                      <canvas id="barChart" style="height:230px"></canvas>
                    </div>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="col-md-4">
                <!-- BAR CHART -->
                <div class="box box-success">
                  <div class="box-body">
                    <div class="chart3">
                      <canvas id="barChart2" style="height:230px"></canvas>
                    </div>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="col-md-4">
                <!-- BAR CHART -->
                <div class="box box-success">
                  <div class="box-body">
                    <div class="chart4">
                      <canvas id="pieChart" style="height:230px;"></canvas>
                    </div>
                  </div>
                  <!-- /.box-body -->
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
<script src="<?php echo base_url('assets/js/app/omset.js');?>"></script>