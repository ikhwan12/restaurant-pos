var userTable;
var deletedId;
var changeId;
var action;
var selectedNode;;
$(document).ready(function() {
        $("#saveBtn2").click(function (){
            if(selectedNode != '' && typeof selectedNode != 'undefined'){
                savePrevilage(changeId, selectedNode);
            }
        });
        $("#cancelBtn2").click(function (){
            $("#tree").jstree();
            $("#tree").jstree(true).destroy(true);
            $("#tree").empty();
            selectedNode = '';
            changeId = '';
        });
          
        dis_en_input(true);
        userTable = $('#example').DataTable({ 
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "autoWidth": false,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"posisi/view",
                "type": "POST",
                data:{ajaxreq:true}
            },
            "columnDefs": [
            
            {
                "targets": [ 0 ],
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
            changeId = id;
            change(id);
            test(id);
        } );
        
         $('#addUserForm').formValidation({
           icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
            posisi: {
                    row: '.col-sm-9',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        },
                        regexp:{
                            regexp:/^[a-zA-Z 0-9\s]*$/,
                            message:"Character not Allowed"
                        }
                    }
                }
            }
        });
        
        var fv =  $('#addUserForm').data('formValidation');
        
         $("#addBtn").click(function (e){
            action = "Add";
            dis_en_input(false);
            $("#collapseOne").collapse("show");
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
            $("#tree").jstree();
            $("#tree").jstree(true).destroy(true);
            $("#tree").empty();
            selectedNode = '';
            changeId = '';
        });
        
        $("#posisi").keypress(function (e){
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
       $("#addBtn").text("Tambah Posisi");
   }
}

    
function addUser(fv){
         
         var url;
         if(action == "Add"){
             url = site_url+"posisi/add";
         }else{
             url = site_url+"posisi/update";
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
            url : site_url+"posisi/detail/"+id ,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                dis_en_input(false);
                $('#posisi').val(data.posisi);
                $("#addBtn").text("Ubah Posisi");
                $("#collapseOne").collapse("show");
                $("#addBtn").prop("disabled", true);
            }
        });

}

function dis_en_input(status){
    $('#posisi, #saveBtn').prop('disabled',status);
}

function get_modul(id, resp){
    $.ajax({
            url : site_url+"posisi/get_all_menu/"+id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                resp(data);
            }
        });
}

function formTree(data, result){
    
    var c = 0;
    var prev = "";
    var treeview = "";
    treeview += "<ul>";
    $.each(data, function (key, value){
        var pm = "";
        if(value.akses === '1'){
            pm = "data-checkstate='checked'";
        }
        if(prev !== value.parent_modul){
            if(c === 0){
                if(value.modul === value.parent_modul){
                    treeview += '<li id="'+value.id_akses+'" '+pm+'>'+value.modul+'</li>';
                }else{
                    treeview += '<li>'+value.parent_modul+'<ul><li id="'+value.id_akses+'" '+pm+'>'+value.modul+'</li>';
                }
            }else{
                if(value.modul === value.parent_modul){
                    treeview += '</ul></li><li id="'+value.id_akses+'" '+pm+'>'+value.modul+'</li>';
                }else{
                    treeview += '</ul></li><li>'+value.parent_modul+'<ul><li id="'+value.id_akses+'" '+pm+'>'+value.modul+'</li>';
                }
                c = 0;
            } 
            prev = value.parent_modul;
        }else if(prev === value.parent_modul){
              treeview += '<li id="'+value.id_akses+'" '+pm+'>'+value.modul+'</li>';
              prev = value.parent_modul;
              c++;
        }
    });
    treeview += "</ul>";
    result(treeview);
}

function modifyTree(treeVar){
    var jt = $("#tree").jstree({
       "types" : {
           "default" : {
             "icon" : "fa fa-folder-open"
           },
           "demo" : {
               "icon" : "glyphicon glyphicon-ok"
             }
       },
       "checkbox": {
           "keep_selected_style": false
       },
       "plugins": ["checkbox","types"]
   });
   treeVar(jt);
}

function savePrevilage(id, data){
     $.ajax({
            url : site_url+"posisi/savePrevilage",
            type: "POST",
            data:{id:id,modul:data},
            dataType: "JSON",
            success: function(data)
            {
                if(data.status){
                    if(confirm("The Page Will Reresh To Make A Change.")){
                        location.replace(site_url+'posisi');
                    }
                }
            }
        });
}

function test(id){
    $("#tree").jstree();
    $("#tree").jstree(true).destroy(true);
    $("#tree").empty();
      $.ajax({
            url : site_url+"posisi/get_all_menu/"+id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {  
                var g = formTree(data, function (x){
                    $("#tree").html(x);
                });
                var j = modifyTree(function (jt){
                    jt.jstree(true).open_all();
                    $('li[data-checkstate="checked"]').each(function() {
                      jt.jstree('check_node', $(this));
                    });
                     $('#tree').on("changed.jstree", function (e, data) {
                        selectedNode = data.selected; 
                      });
                });
   
            }
        });

}