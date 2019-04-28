var table;
$(document).ready(function() {
        
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
                    message: 'Laporan Stok',
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
                "url": site_url+"laporan_stok/view",
                "dataSrc": ""
              },
            "autoWidth": false,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "columnDefs": [
                  { 
                      "className": "text-right", "targets": [2] 
                  }
            ]
        } );
        
       
        $('#search').click(function (){
            var outlet = $('#outlet').val();
            table.ajax.url( site_url+"laporan_stok/view/"+outlet ).load();
        });
       
        
} );

