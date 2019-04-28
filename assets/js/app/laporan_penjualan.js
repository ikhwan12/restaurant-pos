var userTable;
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
        
        userTable = $('#example').DataTable({ 
            dom: 'Blfrtip',
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            buttons: [
                {
                    extend: 'print',
                    message: 'Laporan Penjualan',
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
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "searching": false,
            "autoWidth": false,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"laporan_penjualan/view",
                "type": "POST",
                data:{ajaxreq:true}
            },
            "columnDefs": [
            { 
                "targets": [ 0, 6 ], //last column
                "orderable": false, //set not orderable
            },
            { "className": "text-right", "targets": [7,8,9,10] }
            
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

                    pageTotals = api.column( 7, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                    pageTotald = api.column( 8, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                    pageTotalp = api.column( 9, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                    pageTotal = api.column( 10, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );

                    // Update footer
                    $( api.column( 7 ).footer() ).html($.number(pageTotals,0,',','.'));
                    $( api.column( 8 ).footer() ).html($.number(pageTotald,0,',','.'));
                    $( api.column( 9 ).footer() ).html($.number(pageTotalp,0,',','.'));
                    $( api.column( 10 ).footer() ).html($.number(pageTotal,0,',','.'));
                }
        } );
        
        $('#search').click(function (){
           var date = $('#daterange-btn span').text();
           date = date.split(' - ');
           var start = moment(date[0]).format("YYYY-MM-DD");
           var end = moment(date[1]).format("YYYY-MM-DD");
           var outlet = $('#outlet').val();
           userTable.ajax.url( site_url + "laporan_penjualan/view/" + start + "/" + end + "/" + outlet).load(); 
        });
       
        
} );

