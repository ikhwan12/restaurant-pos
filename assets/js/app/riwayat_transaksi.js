var userTable;
$(document).ready(function() {
        
        userTable = $('#example').DataTable({ 
             dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'print',
                    message: 'Riwayat Transaksi',
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
                "url": site_url+"riwayat_transaksi/view",
                "type": "POST",
                data:{ajaxreq:true}
            },
            "columnDefs": [
            { 
                "targets": [ 0, 5 ], //last column
                "orderable": false, //set not orderable
            },
            {
                "targets": [ 0 ],
                "visible": false
            }
            
            ],
        } );
        
       
        
} );


function edit(id){
    location.replace(site_url+'order/myorder/'+id);
}
    