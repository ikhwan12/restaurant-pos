var userTable;
var deletedId;
var action;
$(document).ready(function() {
        
         $.ajax({
            url : site_url+"posisi/daftar_posisi",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $.each(data, function(key, value){
                        $('#posisi').append("<option value='"+key+"'>"+value+"</option>");
                });
                $('#posisi').val('');
                $("#posisi").select2();
            }
        });   
        
         $("#posisi").change(function (){
            var id_posisi = this.value;
            userTable.ajax.url( site_url + "hak_akses/view/" + id_posisi).load();
        });
        
         $("#okBtn").on('click', function (){
            if(confirm("Anda Yakin?")){
                window.location = site_url+"hak_akses";
            }
            
        });
        
        
        userTable = $('#example').DataTable({ 
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "autoWidth": false,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"hak_akses/view",
                "type": "POST",
                data:{ajaxreq:true}
            },
            "columnDefs": [
            { 
                "targets": [ -1 ], //last column
                "orderable": false, //set not orderable
            },
            
            ],
        } );
        
        
} );

function reload_table()
{
    userTable.ajax.reload(null,false); //reload datatable ajax 
}

function doalert(elm, id){
    if (elm.checked) {
        ubahAkses(id, 1);
    }else {
        ubahAkses(id, 0);
    }
 }
 
 function ubahAkses(id, flag){
     
    $.ajax({
            url : site_url+"hak_akses/ubah_akses/"+id,
            type: "POST",
            data: {'baca': flag},
            dataType: "JSON",
            success: function(data)
            {
                if(data.status){
                    reload_table();
                }
            }
        });  
     
 }