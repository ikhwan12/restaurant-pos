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
                if(id_outlet != ""){
                    $("#outlet").val(id_outlet);
                }
                $('#outlet').select2();
            }
        });  
        
        
        
        table = $('#example').DataTable( {
            "searching": false,  
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'print',
                    message: 'Rekapitulasi Kas',
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
             "ajax": {
                "url": site_url+"rekap_kas/view",
                "dataSrc": ""
              },
            "autoWidth": false,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "columnDefs": [
                  { 
                      "className": "text-right", "targets": [2,3,4,5,6,7] 
                  }
            ]
        } );
        
       
        $('#search').click(function (){
            var date = $('#daterange-btn span').text();
            date = date.split(' - ');
            var start = moment(date[0]).format("YYYY-MM-DD");
            var end = moment(date[1]).format("YYYY-MM-DD");
            var outlet = $('#outlet').val();
            table.ajax.url( site_url+"rekap_kas/view/"+ start + "/" + end + "/"+outlet ).load();
        });
       
        
} );

