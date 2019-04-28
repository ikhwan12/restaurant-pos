
var table;
$(document).ready(function() {
        
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
        
        table = $('#example').DataTable( {
             "ajax": {
                "url": site_url+"analisa_penjualan/view_jam",
                "dataSrc": ""
              },
            "autoWidth": false,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "columnDefs": [
                  { 
                      "className": "text-right", "targets": [1,2,3] 
                  }
            ],
            "searching": false,  
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'print',
                    message: 'Laporan Penjualan Per Jam',
                    text:      '<i class="fa fa-print"></i>',
                    titleAttr: 'Print',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excelHtml5',
                    text:      '<i class="fa fa-file-excel-o"></i>',
                    titleAttr: 'Excel',
                    exportOptions: {
                        columns: ':visible'
                }
                },
                {
                    extend: 'colvis',
                    text:      '<i class="fa fa-filter"></i>',
                    titleAttr: 'Column Visibility',
                    collectionLayout: 'fixed three-column',
                    postfixButtons: [ 'colvisRestore' ]
                }
            ],
            "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$.]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over all pages
                    total = api.column( 2 ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                    totalc = api.column( 1 ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );

                    // Total over this page
                     pageTotal = api.column( 2, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                    pageTotalc = api.column( 1, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );

                    // Update footer
                    $( api.column( 3 ).footer() ).html($.number(pageTotal/pageTotalc,0,',','.') +' ('+ $.number(total/totalc,0,',','.') +' total)');
                    $( api.column( 2 ).footer() ).html($.number(pageTotal,0,',','.') +' ('+ $.number(total,0,',','.') +' total)');
                    $( api.column( 1 ).footer() ).html($.number(pageTotalc,0,',','.') +' ('+ $.number(totalc,0,',','.') +' total)');
                }
        } );
        
       
        $('#search').click(function (){
            var date = $('#daterange-btn span').text();
            date = date.split(' - ');
            var start = moment(date[0]).format("YYYY-MM-DD");
            var end = moment(date[1]).format("YYYY-MM-DD");
            var outlet = $('#outlet').val();
            table.ajax.url( site_url+"analisa_penjualan/view_jam/"+start+"/"+end+'/'+outlet ).load();
        });
       
        
} );

