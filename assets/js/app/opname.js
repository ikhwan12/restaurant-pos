var listOutlet;
var editID;
var table; 
var action;
$(document).ready(function() {
    
    $('#form-box').hide();
    show_hide_btn('addBtn');
    
    table = $('#rspTab').DataTable( {
           "ordering": false,
             "ajax": {
                "url": site_url+"opname/addView",
                "dataSrc": ""
              },
            "autoWidth": false,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "columnDefs": [
                  { 
                      "className": "text-right", "targets": [2, 3, 4] 
                  },
                 
            ]
        } );
    
    var lo = getOutlet(function (data){
       listOutlet = data;
       $( '#outlet' ).select2({
            data:listOutlet
        });
        $( '#outlet' ).change(function (){
            if(action == "Add"){
                table.ajax.url( site_url + "opname/addView/" + this.value).load();
            }
        });
        
    });
    
    userTable = $('#example').DataTable({ 
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "autoWidth": false,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"opname/view",
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
            show_hide_btn('*');
            editID = id;
        } );
        
        
        $('#addUserForm').formValidation({
           icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
            outlet: {
                    row: '.col-sm-9',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                },
            tanggal: {
                    row: '.col-sm-9',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                }
            
            }
        });
        
        var fv =  $('#addUserForm').data('formValidation');
        
         $('#tanggal').datetimepicker({
             format:"YYYY-MM-DD h:mm:ss"
         }); 
        
         $("#addBtn").click(function (e){
            show_hide_btn();
            show_div('form-box');
            action = "Add";
        });
        $("#editBtn").click(function (e){
            show_hide_btn();
            change(editID);
            show_div('form-box');
        });
        $("#cancelBtn").click(function (e){
           resetForm(fv);
           changeAddBtn();
        });
         $('#saveBtn').on('click', function(){
            fv.validate();
            if(fv.isValid()){
                addUser(fv);
            }
        });
        $('#detBtn').click(function (){
           $('#rsp').toggle();
        });
        
});

function show_hide_btn(st){
    $('#addBtn, #editBtn').hide();
    if(st == "*"){
        $('#addBtn, #editBtn').show();
    }else if(typeof st != 'undefined'){
        $('#'+st).show();
    }
}
function show_div(div_id){
    $("#table-box, #form-box").hide();
    $("#"+div_id).show();
}
function resetForm(fv){
   fv.resetForm();
   $('#addUserForm')[0].reset();
   userTable.$('tr.active').removeClass('active');
   $('#rsp').toggle();
   $('#outlet').prop("disabled",false);
   $('#outlet').val("").trigger("change");
   table.ajax.url( site_url + "opname/addView/").load();
}

function changeAddBtn(){
   show_div('table-box');
   show_hide_btn('addBtn');
}

function addUser(fv){
         
         var url;
         if(action == "Add"){
             url = site_url+"opname/add";
         }else{
             url = site_url+"opname/update";
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
                        location.replace(site_url + "opname");
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
            url : site_url+"opname/detail/"+id ,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('#outlet').val(data.id_outlet).trigger('change').attr("disabled","disabled");
                $('#tanggal').val(data.tanggal);
                $('#note').val(data.note);
                table.ajax.url( site_url + "opname/updateView/" + id).load();
            }
        });   
}
function getOutlet(listOutlet){
    $.ajax({
            url : site_url+"outlet/outletData",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
               listOutlet(data);
            }
        });  
}
function getProduk(listProduk){
    $.ajax({
            url : site_url+"menu_outlet/warehouseData",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
               listProduk(data);
            }
        });  
}

function getProdukDetail(value, result){
    $.ajax({
            url : site_url+"menu_outlet/getDetailProduk",
            type: "POST",
            data: {id:value},
            dataType: "JSON",
            success: function(data)
            {
               result(data);
            }
        });  
}

function updateVar(val, i){
    var stok = $("#st"+i).val();
    var Ex = parseFloat(val)+parseFloat(stok);
    var Ex2 = Math.pow(val, 2) + Math.pow(stok, 2);
    var Ex_2 = Math.pow(Ex, 2);
    var variance = (2*Ex2 - Ex_2)/(2*1);
    $('#var'+i).text($.number(variance,'2','.',','));
}