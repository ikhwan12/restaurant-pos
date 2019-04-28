var userTable;
var deletedId;
var action;
$(document).ready(function() {
        
        $('#importBtn').click(function (){
             $('#modal-confirm').modal('show');
        });
        $('#exportBtn').click(function (){
            window.open(site_url+'kategori/export/kategori');
        });
        
        
        $("#myfile").change(function (){
          $('#filename').val($(this).val());
        });
          
        
         $('#uploadSubmitBtn').on('click', function() {
            var file_data = $('#myfile').prop('files')[0];   
            var form_data = new FormData();
            form_data.append('file', file_data);                        
            $.ajax({
                url:  site_url+"kategori/import",
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: $("#uploadForm").serialize(),                         
                data: form_data,                         
                type: 'post',
                success: function(data){
                    
                }
            });
            reload_table();
        });
        
        dis_en_input(true);
        
        userTable = $('#example').DataTable({ 
             "scrollY":"400px",
             "scrollCollapse": true,
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "autoWidth": false,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"kategori/view",
                "type": "POST",
                data:{ajaxreq:true}
            },
            "columnDefs": [
            { 
                "targets": [ 0, -1 ], //last column
                "orderable": false, //set not orderable
            },
            {
                "targets": [ 1 ],
                "visible": false
            }
            
            ],
        } );
        
        $('#example tbody').on( 'click', 'tr', function () {
            
            if ( $(this).hasClass('active') ) {
            $(this).removeClass('active');
            }
            else {
                userTable.$('tr.active').removeClass('active');
                $(this).addClass('active');
            }
            var id = userTable.row( this ).data()[1];
            change(id);
        } );
        
        
         $('#addUserForm').formValidation({
           icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
            kategori: {
                    row: '.col-sm-9',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        },
                        regexp:{
                            regexp: /^[a-zA-z 0-9\s]*$/,
                            message: "Character not allowed"
                        }
                    }
                },
            
            }
        });
        
        var fv =  $('#addUserForm').data('formValidation');
        
         $("#addBtn").click(function (e){
            action = "Add";
            dis_en_input(false);
            $("#addBtn").prop("disabled", true);
        });
        
        $('#saveBtn').on('click', function(){
            
            fv.validate();
            if(fv.isValid()){
                addUser(fv);
            }
            
        });
        
        $("#cancelBtn").click(function (e){
           resetForm(fv);
           changeAddBtn();
        });
        
        $("#kategori").keypress(function (e){
           if(e.keyCode == 13){
               $("#saveBtn").click();
           }
        });
        
        
        
} );

function reload_table(){
    userTable.ajax.reload(null,false); //reload datatable ajax 
} 

function resetForm(fv){
   fv.resetForm();
   $('#addUserForm')[0].reset();
   dis_en_input(true);
}

function changeAddBtn(){
   $("#collapseOne").collapse("hide");
   $("#addBtn").prop("disabled", false);
   if(action=="Update"){
       $("#addBtn").text("Tambah Kategori");
   }
}

    
function addUser(fv){
         
         var url;
         if(action == "Add"){
             url = site_url+"kategori/add";
         }else{
             url = site_url+"kategori/update";
         }
        
         $.ajax({
                url : url,
                type: "POST",
                data: $("#addUserForm").serialize(),
                dataType: "JSON",
                beforeSend: function() { 
                    $("#saveBtn").text("Saving...");
                    $("#saveBtn").prop('disabled', true); // disable button
                },
                success: function(data)
                {
                    if(data.status){
                        reload_table();
                        resetForm(fv);
                        changeAddBtn();
                        $("#saveBtn").text("Save");
                        $("#saveBtn").prop('disabled', false);
                    }else{
                        alert('Fail');
                    }
                }
            });
    }

function change(id){
    action = "Update";
    $('#id').val(id);
    $.ajax({
            url : site_url+"kategori/detail/"+id ,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                dis_en_input(false);
                $('#kategori').val(data.kategori);
                $("#addBtn").text("Ubah Kategori");
                $("#collapseOne").collapse("show");
                $("#addBtn").prop("disabled", true);
            }
        });

}
function dis_en_input(status){
    $('#kategori, #saveBtn').prop('disabled',status);
}
