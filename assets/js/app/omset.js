$(function (){
    $.ajax({
            url : site_url+"laporan_penjualan/daftar_outlet",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $.each(data, function(key, value){
                        $('#outlet').append("<option value='"+key+"'>"+value+"</option>");
                });
                $('#outlet').val('');
                $('#outlet').select2();
            }
        });  
    var start = moment();
    var end = moment();

    function cb(start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#daterange-btn').daterangepicker({
        opens: "center",
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'This Week': [moment().subtract(1,'days').day(1), moment().subtract(1,'days').day(7)],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'This Year' : [moment().startOf('year'), moment().endOf('year')]
        }
    }, cb);

    cb(start, end);
    
    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      title: {
            display: true,
            text: 'Laporan Omset'
        },
      scales: {
            xAxes: [{
                type: 'time',
                ticks: {
                    autoSkip:true,
                    maxTicksLimit:10
                },
                time: {
                    displayFormats: {
                        day: 'DD MMM YY'
                    }
                }
            }]
        },
      showScale: true,
      
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: false,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - Whether the line is curved between points
      bezierCurve: true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension: 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot: false,
      //Number - Radius of each point dot in pixels
      pointDotRadius: 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth: 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius: 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke: true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth: 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill: true,
      //String - A legend template
      legend: {
            display: true,
            position: 'bottom',
            labels:{
                boxWidth:20
            }
        },
      //legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true
    };
    
    build_line_chart(areaChartOptions); 
    buildBarChart();
    buildBarChart2();
    buildPieChart();
    
    $('#search').click(function (){
         build_line_chart(areaChartOptions);   
         buildBarChart();
         buildBarChart2();
         buildPieChart();
    });
        
    
   
  });
  
  function get_data(start, end, handleData){
    return $.ajax({
        url: site_url+"omset/get_data/"+start+"/"+end+'/'+$('#outlet').val(),
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
                        handleData(data);
                    }
    });
  }
  function get_label(start, end, handleData){
    return $.ajax({
        url: site_url+"omset/get_label/"+start+"/"+end+'/'+$('#outlet').val(),
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
                        handleData(data);
                    }
    });
  }
  
  function build_line_chart(areaChartOptions){
      
        var date = $('#daterange-btn span').text();
        date = date.split(' - ');
        var start_date = moment(date[0]);
        var end_date = moment(date[1]);
        var label = Array();
            var lbl =get_label(moment(date[0]).format("YYYY-MM-DD"), moment(date[1]).format("YYYY-MM-DD"), function (data){
                $.each( data, function( key, val ) {
                    label.push(val);
                  });
            
            var dataset = get_data(moment(date[0]).format("YYYY-MM-DD"), moment(date[1]).format("YYYY-MM-DD"), function (mydata){
            var items = [];
            $.each( mydata, function( key, val ) {
                items.push(val);
              });

            var areaChartData = {
                labels: label,
                datasets:items
              };
              $('.chart').text(''); // this is my <canvas> element
              $('.chart').append('<canvas id="lineChart" style="height:270px;"><canvas>');
              
              var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
              var lineChartOptions = areaChartOptions;
              
               if(moment(date[0]).format("YYYY-MM-DD") == moment(date[1]).format("YYYY-MM-DD")){
                  
                    lineChartOptions.scales.xAxes = [{
                        type: "time",
                        time: {
                            format: "HH:mm",
                            unit: 'hour',
                            unitStepSize: 1,
                        displayFormats: {
                            'minute': 'HH:mm',
                            'hour': 'HH:mm',
                        },
                            tooltipFormat: 'HH:mm'
                        }
                  }];
              }else{
                  lineChartOptions.scales.xAxes = [{
                      type: 'time',
                      ticks: {
                          autoSkip:true,
                          maxTicksLimit:20
                      },
                      time: {
                          displayFormats: {
                              day: 'DD MMM YY'
                          }
                      }
                  }];
              }
              
              //console.log(lineChartOptions.scales.xAxes);
              var myLineChart = new Chart(lineChartCanvas, {
                  type: 'line',
                  data: areaChartData,
                  options: areaChartOptions
              });
          });
          });
          
  }
  
 function buildBarChart(){
    var date = $('#daterange-btn span').text();
    date = date.split(' - ');
    var start = moment(date[0]).format("YYYY-MM-DD");
    var end = moment(date[1]).format("YYYY-MM-DD");
    var outlet = $('#outlet').val();
    var label = [];
    var point = [];
    var tempData = getBarData(start, end, outlet, function (x){
        $.each(x.label,function (key, value){
            label.push(value);
            
        });
        $.each(x.point,function (key, value){
            point.push(value);
        });
        
          var data = {
        labels: label,
        datasets: [
            {
                label: "Top Selling Product",
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255,99,132,1)',
                borderWidth: 1,
                data: point,
            }
        ]
    };
var barChartOptions = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };
$('.chart2').text(''); // this is my <canvas> element
$('.chart2').append('<canvas id="barChart" style="height:300px;"><canvas>');
     var barChartCanvas = $("#barChart").get(0).getContext("2d");
     var BarChart = new Chart(barChartCanvas, {
        type: 'horizontalBar',
        data: data,
        options:barChartOptions
    });
        
    });
    
    
 }
 
 function buildBarChart2(){
    var date = $('#daterange-btn span').text();
    date = date.split(' - ');
    var start = moment(date[0]).format("YYYY-MM-DD");
    var end = moment(date[1]).format("YYYY-MM-DD");
    var outlet = $('#outlet').val();
    var label = [];
    var point = [];
    var tempData = getBarData2(start, end, outlet, function (x){
        $.each(x.label,function (key, value){
            label.push(value);
            
        });
        $.each(x.point,function (key, value){
            point.push(value);
        });
        
          var data = {
        labels: label,
        datasets: [
            {
                label: "Highest Sales Amount Product",
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255,99,132,1)',
                borderWidth: 1,
                data: point,
            }
        ]
    };
var barChartOptions = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };
$('.chart3').text(''); // this is my <canvas> element
$('.chart3').append('<canvas id="barChart2" style="height:300px;"><canvas>');
     var barChartCanvas = $("#barChart2").get(0).getContext("2d");
     var BarChart = new Chart(barChartCanvas, {
        type: 'horizontalBar',
        data: data,
        options:barChartOptions
    });
        
    });
    
    
 }
 
 function getBarData(start, end, outlet, handleData){
     return $.ajax({
            url: site_url+"omset/getBarData/"+start+"/"+end+'/'+$('#outlet').val(),
            type: 'GET',
            dataType: 'JSON',
            success: function (data) {
                            handleData(data);
                        }
        });
 }
 function getBarData2(start, end, outlet, handleData){
     return $.ajax({
            url: site_url+"omset/getBarData2/"+start+"/"+end+'/'+$('#outlet').val(),
            type: 'GET',
            dataType: 'JSON',
            success: function (data) {
                            handleData(data);
                        }
        });
 }
 function getPieData(start, end, outlet, handleData){
     return $.ajax({
            url: site_url+"omset/getPieData/"+start+"/"+end+'/'+$('#outlet').val(),
            type: 'GET',
            dataType: 'JSON',
            success: function (data) {
                            handleData(data);
                        }
        });
 }
 
 function buildPieChart(){
    var date = $('#daterange-btn span').text();
    date = date.split(' - ');
    var start = moment(date[0]).format("YYYY-MM-DD");
    var end = moment(date[1]).format("YYYY-MM-DD");
    var outlet = $('#outlet').val();
    var label = [];
    var point = [];
     var tempData = getPieData(start, end, outlet, function (x){
        $.each(x.label,function (key, value){
            label.push(value);
            
        });
        $.each(x.point,function (key, value){
            point.push(value);
        });
        
         var data = {
            labels: label,
            datasets: [
                {
                    data: point,
                    backgroundColor: [
                        "#FF6384",
                        "#36A2EB",
                        "#FFCE56",
                        "#00ca6d",
                        "#000",
                    ],
                    hoverBackgroundColor: [
                        "#FF6384",
                        "#36A2EB",
                        "#FFCE56",
                        "#00ca6d",
                        "#000",
                    ]
                }]
        };
            var pieOptions = {
              title: {
                    display: true,
                    text: 'Top 5 Sales by Category'
                },  
              //Boolean - Whether we should show a stroke on each segment
              segmentShowStroke: true,
              //String - The colour of each segment stroke
              segmentStrokeColor: "#fff",
              //Number - The width of each segment stroke
              segmentStrokeWidth: 2,
              //Number - The percentage of the chart that we cut out of the middle
              percentageInnerCutout: 50, // This is 0 for Pie charts
              //Number - Amount of animation steps
              animationSteps: 100,
              //String - Animation easing effect
              animationEasing: "easeOutBounce",
              //Boolean - Whether we animate the rotation of the Doughnut
              animateRotate: true,
              //Boolean - Whether we animate scaling the Doughnut from the centre
              animateScale: false,
              //Boolean - whether to make the chart responsive to window resizing
              responsive: true,
              // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
              maintainAspectRatio: true,
              legend: {
                    display: true,
                    position: 'right',
                    labels:{
                        boxWidth:15
                    }
                },
            };
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            $('.chart4').text(''); // this is my <canvas> element
            $('.chart4').append('<canvas id="pieChart" style="height:300px;"><canvas>');
            var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
            var myPieChart = new Chart(pieChartCanvas,{
                type: 'pie',
                data: data,
                options: pieOptions
            });
        
    });
     
   
     
 }