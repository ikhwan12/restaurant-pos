var userTable;
var deletedId;
var action;
$(document).ready(function() {
        dis_en_input(true);
        get_position("");
        get_outlet("");
        
        userTable = $('#example').DataTable({ 
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "autoWidth": false,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"pengguna/view",
                "type": "POST",
                data:{ajaxreq:true}
            },
            "columnDefs": [
            { 
                "targets": [ -1 ], //last column
                "orderable": false, //set not orderable
            },
             {
                "targets": [ 2, 3 ],
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
            var id = userTable.row( this ).data()[0];
            change(id);
        } );
        
         $('#addUserForm').formValidation({
           icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
            password: {
                    row: '.col-sm-9',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        },
                        stringLength: {
                            min: 8,
                            message: 'Password must be more than 8 characters'
                        }
                    }
                },
            nama: {
                    row: '.col-sm-9',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        },
                        regexp:{
                            regexp: /^[a-zA-Z\s]*$/,
                            message:"Letters only "
                        }
                    }
                },
            alamat: {
                    row: '.col-sm-9',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                },
            no_telp: {
                    row: '.col-sm-9',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        },
                        regexp:{
                            regexp: /^[0-9\(\)\-\s]*$/,
                            message:"Not a valid telp number character"
                        }
                    }
                },
            id_posisi: {
                    row: '.col-sm-9',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                },
            outlet: {
                    row: '.col-sm-5',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                }
            }
        });
        
        var fv =  $('#addUserForm').data('formValidation');
        
        $('#id_posisi').change(function (){
            if(action == "Add"){
                if(this.value != ''){
                    var selected_text = this.options[this.selectedIndex].innerHTML;
                    generateID(selected_text); 
                }else{
                    $('#username').val('');
                }
            }
        });
        
        
        $("#addBtn").click(function (e){
            action = "Add";
            dis_en_input(false);
            $('#id_posisi').prop("disabled", false);
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
        
        $("#username, #password, #nama, #alamat, #no_telp").keypress(function (e){
           if(e.keyCode == 13){
               $("#saveBtn").click();
           }
        });
        
         $('#yesBtn').on('click', function(){
            $.ajax({
                 url : site_url+"pengguna/delete/"+deletedId ,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    if(deletedId == $("#username").val()){
                        resetForm(fv);
                        changeAddBtn();
                    }
                    reload_table();
                    $('#modal-confirm').modal('hide');
                }
            });
        });
        
} );

function reload_table(){
    userTable.ajax.reload(null,false); //reload datatable ajax 
} 

function resetForm(fv){
   get_position("");
   get_outlet("");
   fv.resetForm();
   $('#addUserForm')[0].reset();
   dis_en_input(true);
   
}

function changeAddBtn(){
   $("#addBtn").prop("disabled", false);
   if(action=="Update"){
       $("#addBtn").text("Tambah Pengguna");
   }
}

function generateID(text){
        
        $.ajax({
                url : site_url+"pengguna/generateID",
                type: "POST",
                data: {posisi: text},
                dataType: "JSON",
                success: function(data)
                {
                        $('#username').val(data.id);
                        $('#password').val(data.id);
                }
            });
        
    }
    
function addUser(fv){
         
         var url;
         if(action == "Add"){
             url = site_url+"pengguna/add";
         }else{
             url = site_url+"pengguna/update";
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
            url : site_url+"pengguna/detail/"+id ,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                dis_en_input(false);
                get_position(data.id_posisi);
                get_outlet(data.id_outlet);
                $('#username').val(data.username);
                $('#password').val('--------');
                $('#nama').val(data.nama);
                $('#alamat').val(data.alamat);
                $('#no_telp').val(data.no_telp);
                $('#aktif').val(data.aktif);
                $("#addBtn").text("Ubah Pengguna");
                $("#collapseOne").collapse("show");
                $("#addBtn").prop("disabled", true);
            }
        });

}

function del(id){
    deletedId = id;
    $('#modal-confirm').modal('show');
}

function get_position(val){
    
    $('#id_posisi').select2();
    $('#id_posisi').select2('destroy');
    $.ajax({
            url : site_url+"posisi/daftar_posisi",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('#id_posisi').text("");
                $.each(data, function(key, value){
                        $('#id_posisi').append("<option value='"+key+"'>"+value+"</option>");
                });
                $('#id_posisi').val(val);
                $('#id_posisi').select2();
            }
        });  
    
}
function get_outlet(val){
    
    $('#outlet').select2();
    $('#outlet').select2('destroy');
    $.ajax({
            url : site_url+"outlet/daftar_outlet",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('#outlet').text("");
                $.each(data, function(key, value){
                        $('#outlet').append("<option value='"+key+"'>"+value+"</option>");
                });
                $('#outlet').val(val);
                $('#outlet').select2();
            }
        });  
    
}

function dis_en_input(status){
    $('#id_posisi, #nama, #password, #alamat, #no_telp, #aktif, #outlet, #saveBtn').prop('disabled',status);
}
