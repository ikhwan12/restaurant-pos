var userTable;
$(document).ready(function() {
        
        userTable = $('#example').DataTable({ 
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "searching": false,
            "autoWidth": false,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"order/view",
                "type": "POST",
                data:{ajaxreq:true}
            },
            "columnDefs": [
            { 
                "targets": [ 0, 4, -1 ], //last column
                "orderable": false, //set not orderable
            }
            
            ],
        } );
        
       
        
} );


function edit(id){
    location.replace(site_url+'order/myorder/'+id);
}

function printMenu(id){
    $.ajax({
        url: site_url+"order/kitchenPrint/"+id,
        dataType:"json",
        success: function (data, textStatus, jqXHR) {
            if(!data.connected){
                alert(data.message);
            }
        }
    });
}
