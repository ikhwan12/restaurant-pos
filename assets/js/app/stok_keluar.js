var listOutlet;
var listProduk;
var editID;
var action;
$(document).ready(function() {
    
    var lb = getProduk(function(data){
           listProduk = data;
        }); 
    
    $('#form-box').hide();
    show_hide_btn('addBtn');
    userTable = $('#example').DataTable({ 
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "autoWidth": false,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"stok_keluar/view",
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
            id_outlet: {
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
            $("#count").val(0) 
            $("#count2").val(0) 
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
        $("#addField2").click(function (e){
            e.preventDefault();
            addField();
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
   $("#rspTab tbody").html("");
   $("#count2").val(0);
   userTable.$('tr.active').removeClass('active');
}

function changeAddBtn(){
   show_div('table-box');
   show_hide_btn('addBtn');
}

function addUser(fv){
         
         var url;
         if(action == "Add"){
             url = site_url+"stok_keluar/add";
         }else{
             url = site_url+"stok_keluar/update";
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
                        location.replace(site_url + "stok_keluar");
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
            url : site_url+"stok_keluar/detail/"+id ,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('#tanggal').val(data.tanggal);
                $('#note').val(data.note);
            }
        });   
    genereateFieldBarang();    
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

function addField(){
    var next = parseInt($("#count2").val());
    if(next == 0){
        next = next + 1;
        newRow = generateField(next);
        $("#rspTab tbody").html(newRow);
        $('#count2').val(next);
    }else{
        var addTo = "#rspTab tbody #rowbhn"+next;
        next = next + 1;
        var newRow = generateField(next);
        $(addTo).after(newRow);
        $('#count2').val(next);
    }
    generateSelect2(next);  
    deleteBtnFnc();
   
}
function generateField(next){
    return  '<tr id="rowbhn'+next+'">'+
                '<td><select style="width:100%" id="bhn-'+next+'"  name="bahan[]" class="form-control input-sm"></select></td>'+
                '<td><div class="input-group"><input id="qty-'+next+'" type="text" name="qty[]" class="form-control"><span class="input-group-addon" id="sat-'+next+'"></span></div></td>'+
                '<td><button  type="button" id="delbhn-'+next+'" class="btn btn-s btn-flat btn-danger del-bhn-btn"><i class="fa fa-close"></i></button>'+
                '</td></tr>';
}
function generateSelect2(next){
   $( '#bhn-'+next ).select2({
       data:listProduk
   });
   $( '#bhn-'+next ).change(function (){
        var d = getProdukDetail(this.value, function (result){
            if(result != 0){
                changeField(next, result);
            }else{
                $( '#qty-'+next ).val('');
            }
          });
    });
  
}
function deleteBtnFnc(){
     $('.del-bhn-btn').click(function(e){
            e.preventDefault();
            var fieldNum = this.id.split("-");
            var fieldID = "#rspTab tbody #rowbhn" + fieldNum[1];
            $(fieldID).remove();
            
            var stat = isEmptyTab();
            if(stat){
                $('#count2').val(0);
                $('#resep').removeAttr('checked');
                $('#rsp').hide();
            }else{
                if(fieldNum[1] == parseInt($("#count2").val())){
                    findMaxID();
                }
            }
        });
} 
function isEmptyTab(){
    var c = 0;
     $('#rspTab tbody tr').each(function (){
         c++;
    });
    var stat = (c == 0)?true:false;
    return stat;
}
function getMaxOfArray(numArray) {
  return Math.max.apply(null, numArray);
}
function findMaxID(){
    var listID = [];
    $('#rspTab tbody tr').each(function (){
       listID.push(parseInt(this.id.replace('rowbhn','')));
    });
    $('#count2').val(getMaxOfArray(listID));
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
function changeField(next, result){
      $( '#sat-'+next ).text(result.satuan);
}
function genereateFieldBarang(){
    var fnc = getListBarang(function (listMod){
      if(listMod.length > 0){
        var next = 1;  
        var myField = "";
        $('#count2').val(listMod.length);
        $.each(listMod,function (index, item){
            myField += generateField(next);
            next++;
        });
        $("#rspTab tbody").html(myField);
        generateSelect22(listMod);
        deleteBtnFnc();
      }else{
          $('#count2').val('0');
      }  
      
    });
}
function getListBarang(result){
    $.ajax({
            url : site_url+"stok_keluar/getListBarang/"+editID,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
               result(data);
            }
        });  
}  
function generateSelect22(listMod){
    var i = 0;
    $('#rspTab tbody tr').each(function (i, row){
        var next = row.id;
        next = next.replace(/\D/g,'');
        generateSelect2(next);
        $( '#bhn-'+next ).val(listMod[i].id_om).trigger('change');
        $( '#qty-'+next ).val(listMod[i].jumlah);
    });
   
}