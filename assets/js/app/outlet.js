var userTable;
var deletedId;
var action;
$(document).ready(function() {
        
        dis_en_input(true);
        
        userTable = $('#example').DataTable({ 
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "autoWidth": false,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"outlet/view",
                "type": "POST",
                data:{ajaxreq:true}
            },
            "columnDefs": [
            { 
                "targets": [ 0, -1 ], //last column
                "orderable": false, //set not orderable
            },
            {
                "targets": [ 0 ],
                "visible": false
            },
            { "className": "text-right", "targets": 3 }
            
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
            nama_outlet: {
                    row: '.col-sm-9',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                },
            alamat_outlet: {
                    row: '.col-sm-9',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                },
            telp: {
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
            ppn: {
                    row: '.col-sm-4',
                    validators: {
                        integer: {
                            message: 'Only integer allowed'
                        }
                    }
                }
            
            }
        });
        
        var fv =  $('#addUserForm').data('formValidation');
        
         $("#addBtn").click(function (e){
            action = "Add";
            dis_en_input(false);
            $('#ppn').val(0);
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
        
        $("#outlet").keypress(function (e){
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
   $("#addBtn").prop("disabled", false);
   if(action=="Update"){
       $("#addBtn").text("Tambah Outlet");
   }
}

    
function addUser(fv){
         
         var url;
         if(action == "Add"){
             url = site_url+"outlet/add";
         }else{
             url = site_url+"outlet/update";
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
            url : site_url+"outlet/detail/"+id ,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                dis_en_input(false);
                $('#nama_outlet').val(data.nama_outlet);
                $('#alamat_outlet').val(data.alamat_outlet);
                $('#telp').val(data.telp);
                $('#ppn').val(data.ppn);
                $('#printer').val(data.printer);
                $("#addBtn").text("Ubah Outlet");
                $("#collapseOne").collapse("show");
                $("#addBtn").prop("disabled", true);
            }
        });

}
function dis_en_input(status){
    $('#nama_outlet, #alamat_outlet, #telp, #ppn, #printer, #saveBtn').prop('disabled',status);
}

