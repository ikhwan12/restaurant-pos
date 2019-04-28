var userTable;
var deletedId;
var action;
var editID;
var listModifier;
var listBahan;
var listKategori;
$(document).ready(function() {
      
       $('#modal-confirm').on('hidden.bs.modal', function () {
           $("#uploadForm")[0].reset();
        });
      
        var kategori = getKategori(function (data){
            listKategori = data;
            $("#kategori").autocomplete({
                source:listKategori
            });
        });
         $('#importBtn').click(function (){
             $('#modal-confirm').modal('show');
        });
        
        $('#exportBtn').click(function (){
            window.open(site_url+'menu/export');
        });
        
        $('#myfile').change(function (){
            $('#filename').val(this.value); 
         });
        
        $('#uploadSubmitBtn').on('click', function() {
            var file_data = $('#myfile').prop('files')[0];   
            var form_data = new FormData();
            form_data.append('file', file_data);                        
            $.ajax({
                url:  site_url+"menu/import",
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: $("#uploadForm").serialize(),                         
                data: form_data,                         
                type: 'post',
                beforeSend: function (xhr) {
                    $("#modal-confirm").modal("hide");
                    $('#loader').addClass('loader');
                    $('#loader-c').addClass('olay');
                },
                success: function(data){
                    if(data.status){
                        location.replace(site_url+'menu');
                    }else{
                        alert(data.message);
                    }
                }
            });
            
        });
        
        $("#expand-btn").click(function (){
            $( "#kategori" ).autocomplete( "option", "minLength", 0 ).autocomplete("search", "");
        });
        
        var lm = getModifier(function(data){
            listModifier = data;
        }); 
        var lm = getBahan(function(data){
            listBahan = data;
        }); 
        
        $("#piltam").click(function (){
           if($("#piltam").prop("checked")){
               $("#pnt").show();
               addField();
           }else{
               $("#pnt").hide();
               $("#pntTab tbody").empty();
               $('#count').val(0);
           } 
        });
        
        $("#resep").click(function (){
           if($("#resep").prop("checked")){
               $("#rsp").show();
               addFieldResep();
           }else{
               $("#rsp").hide();
               $("#rspTab tbody").empty();
               $('#count2').val(0);
           } 
        });
        
        $("#manage_stock").click(function (){
            showHideSatuan();
            
        });
        
        $("#addField").click(function (e){
            e.preventDefault();
            addField();
        });
        $("#addField2").click(function (e){
            e.preventDefault();
            addFieldResep();
        });
        
        
        $('[name="product-image"]').change(function(){
           read_image(this);
        });
        
        $('#form-box').hide();
        show_hide_btn('addBtn');
        dis_en_input(true);
        
        userTable = $('#example').DataTable({ 
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "autoWidth": false,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"menu/view",
                "type": "POST",
                data:{ajaxreq:true}
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], //last column
                "orderable": false, //set not orderable
            },
            {
                "targets": [ 0 ],
                "visible": false
            },
            { "className": "text-right", "targets": [2,3] }
            
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
            menu: {
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
            price: {
                    row: '.col-sm-6',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        },
                        integer:{
                            message:"Only integer allowed"
                        }
                    }
                },
            gojek_price: {
                    row: '.col-sm-6',
                    validators: {
                        integer:{
                            message:"Only integer allowed"
                        }
                    }
                },
            satuan: {
                    enabled: false,
                    row: '.col-sm-6',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        },
                         integer:{
                            message:"Only integer allowed"
                        }
                    }
                }
            
            }
        });
        
        var fv =  $('#addUserForm').data('formValidation');
        
         $("#addBtn").click(function (e){
            $("#count").val(0) 
            $("#count2").val(0) 
            show_hide_btn();
            show_div('form-box');
            action = "Add";
            dis_en_input(false);
        });
        
         $("#editBtn").click(function (e){
            show_hide_btn();
            change(editID);
            show_div('form-box');
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
        
        $("#menu, #deskripsi, #price, #gojek_price").keypress(function (e){
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
   $("#sold, #manage_stock, #auto_assign, #piltam").prop("checked",false);
   $("#pnt").hide();
   $("#pntTab tbody").html("");
   $("#rsp").hide();
   $("#rspTab tbody").html("");
   $("#div-satuan").hide();
   $("#count").val(0);
   $("#count2").val(0);
   userTable.$('tr.active').removeClass('active');
   dis_en_input(true);
}

function changeAddBtn(){
   show_div('table-box');
   show_hide_btn('addBtn');
}

    
function addUser(fv){
         
         var url;
         if(action == "Add"){
             url = site_url+"menu/add";
         }else{
             url = site_url+"menu/update";
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
                        location.replace(site_url + "menu");
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
            url : site_url+"menu/detail/"+id ,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                dis_en_input(false);
                getDetailKategori(data.id_kategori);
                $('#menu').val(data.menu);
                $('#deskripsi').val(data.deskripsi);
                $('#price').val(data.price);
                $('#gojek_price').val(data.gojek_price);
                $('#satuan').val(data.satuan);
                setChecked("#sold",data.sold);
                setChecked("#auto_assign",data.auto_assign);
                setChecked("#manage_stock",data.manage_stock);
                showHideSatuan();
            }
        });
    genereateModifierField();    
    genereateResepField();    
}
function dis_en_input(status){
    $('#menu, #kategori, #deskripsi, #saveBtn, #price, #gojek_price').prop('disabled',status);
}

function getKategori(kategori){
    $.ajax({
            url : site_url+"kategori/daftar_kategori2",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                kategori(data);
            }
        });  
} 

function getDetailKategori(id){
    $.ajax({
            url : site_url+"kategori/detail/"+id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $("#kategori").val(data.kategori);
            }
        });
}


function show_div(div_id){
    $("#table-box, #form-box").hide();
    $("#"+div_id).show();
}
function show_hide_btn(st){
    $('#addBtn, #editBtn').hide();
    if(st == "*"){
        $('#addBtn, #editBtn').show();
    }else if(typeof st != 'undefined'){
        $('#'+st).show();
    }
}

function read_image(input){
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#image').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
/*Pilihan dan Tambahan*/
function addField(){
    var next = parseInt($("#count").val());
    if(next == 0){
        next = next + 1;
        newRow = generateField(next);
        $("#pntTab tbody").html(newRow);
        $('#count').val(next);
    }else{
        var addTo = "#pntTab tbody #row"+next;
        next = next + 1;
        var newRow = generateField(next);
        $(addTo).after(newRow);
        $('#count').val(next);
    }
    generateAutocomplete(next);  
    deleteBtnFnc();
   
}
/*Resep*/
function addFieldResep(){
    var next = parseInt($("#count2").val());
    if(next == 0){
        next = next + 1;
        newRow = generateFieldResep(next);
        $("#rspTab tbody").html(newRow);
        $('#count2').val(next);
    }else{
        var addTo = "#rspTab tbody #rowbhn"+next;
        next = next + 1;
        var newRow = generateFieldResep(next);
        $(addTo).after(newRow);
        $('#count2').val(next);
    }
    generateSelect2Resep(next);  
    deleteBtnFncResep();
   
}

function getMaxOfArray(numArray) {
  return Math.max.apply(null, numArray);
}

function findMaxID(){
    var listID = [];
    $('#pntTab tbody tr').each(function (){
       listID.push(parseInt(this.id.replace('row','')));
    });
    $('#count').val(getMaxOfArray(listID));
}
function findMaxIDResep(){
    var listID = [];
    $('#rspTab tbody tr').each(function (){
       listID.push(parseInt(this.id.replace('rowbhn','')));
    });
    $('#count2').val(getMaxOfArray(listID));
}

function isEmptyTab(){
    var c = 0;
     $('#pntTab tbody tr').each(function (){
         c++;
    });
    var stat = (c == 0)?true:false;
    return stat;
}
function isEmptyTabResep(){
    var c = 0;
     $('#rspTab tbody tr').each(function (){
         c++;
    });
    var stat = (c == 0)?true:false;
    return stat;
}

function generateField(next){
    return  '<tr id="row'+next+'">'+
                '<td><input id="mod-'+next+'" type="text" name="modifier[]" class="form-control input-sm"></td>'+
                '<td><input id="tam-'+next+'" type="text" name="tampilan[]" class="form-control input-sm"></td>'+
                '<td><input id="har-'+next+'" type="text" name="harga[]" class="form-control input-sm"></td>'+
                '<td><button  type="button" id="del-'+next+'" class="btn btn-xs btn-flat btn-danger del-btn"><i class="fa fa-close"></i></button>'+
                '</td></tr>';
}
function generateFieldResep(next){
    return  '<tr id="rowbhn'+next+'">'+
                '<td><select style="width:100%" id="bhn-'+next+'"  name="bahan[]" class="form-control input-sm"></select></td>'+
                '<td><div class="input-group"><input id="qty-'+next+'" type="text" name="qty[]" class="form-control"><span class="input-group-addon" id="sat-'+next+'"></span></div></td>'+
                '<td><button  type="button" id="delbhn-'+next+'" class="btn btn-s btn-flat btn-danger del-bhn-btn"><i class="fa fa-close"></i></button>'+
                '</td></tr>';
}

function generateAutocomplete(next){
    $( '#mod-'+next ).autocomplete({
      source: listModifier,
      minLength:2,
      select: function( event, ui ) {
          var d = getModDetail(ui.item.value, function (result){
              changeField(next, result);
          });
      }
    });
   
    $( '#mod-'+next ).change(function (){
        var d = getModDetail(this.value, function (result){
            if(result != 0){
                changeField(next, result);
            }else{
                $( '#tam-'+next ).val('');
                $( '#tam-'+next ).removeAttr('readonly');
                $( '#har-'+next ).val('');
                $( '#har-'+next ).removeAttr('readonly');
            }
          });
    });
}
function generateSelect2Resep(next){
   $( '#bhn-'+next ).select2({
       data:listBahan
   });
   
    $( '#bhn-'+next ).change(function (){
        var d = getModDetailResep(this.value, function (result){
            if(result != 0){
                changeFieldResep(next, result);
            }else{
                $( '#qty-'+next ).val('');
            }
          });
    });
}

function deleteBtnFnc(){
     $('.del-btn').click(function(e){
            e.preventDefault();
            var fieldNum = this.id.split("-");
            var fieldID = "#pntTab tbody #row" + fieldNum[1];
            $(fieldID).remove();
            
            var stat = isEmptyTab();
            if(stat){
                $('#count').val(0);
                $('#piltam').removeAttr('checked');
                $('#pnt').hide();
            }else{
                if(fieldNum[1] == parseInt($("#count").val())){
                    findMaxID();
                }
            }
        });
} 
function deleteBtnFncResep(){
     $('.del-bhn-btn').click(function(e){
            e.preventDefault();
            var fieldNum = this.id.split("-");
            var fieldID = "#rspTab tbody #rowbhn" + fieldNum[1];
            $(fieldID).remove();
            
            var stat = isEmptyTabResep();
            if(stat){
                $('#count2').val(0);
                $('#resep').removeAttr('checked');
                $('#rsp').hide();
            }else{
                if(fieldNum[1] == parseInt($("#count2").val())){
                    findMaxIDResep();
                }
            }
        });
} 

function getModifier(listModifier){
    $.ajax({
            url : site_url+"menu/modifierData",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
               listModifier(data);
            }
        });  
}
function getBahan(listBahan){
    $.ajax({
            url : site_url+"menu/resepData",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
               listBahan(data);
            }
        });  
}

function getModDetail(value, result){
    $.ajax({
            url : site_url+"menu/get_modifier_detail",
            type: "POST",
            data: {mod:value},
            dataType: "JSON",
            success: function(data)
            {
               result(data);
            }
        });  
}
function getModDetailResep(value, result){
    $.ajax({
            url : site_url+"menu/get_resep_detail",
            type: "POST",
            data: {resep:value},
            dataType: "JSON",
            success: function(data)
            {
               result(data);
            }
        });  
}

function changeField(next, result){
      $( '#tam-'+next ).val(result.tampilan);
      $( '#tam-'+next ).attr('readonly','readonly');
      $( '#har-'+next ).val(result.harga_modifier);
      $( '#har-'+next ).attr('readonly','readonly');
}
function changeFieldResep(next, result){
      $( '#sat-'+next ).text(result.satuan);
}

function setChecked(field, val){
    if(val == "1"){
        $(field).prop("checked",true);
    }else{$(field).prop("checked",false);}
}

function showHideSatuan(){
    if($("#manage_stock").prop("checked")){
        $("#div-satuan").show();
        $('#addUserForm')
                    .formValidation('enableFieldValidators', 'satuan', true);
    }else{$("#div-satuan").hide();$('#addUserForm')
                    .formValidation('enableFieldValidators', 'satuan', false);}
}

function getMenuModifier(result){
    $.ajax({
            url : site_url+"menu/getMenuModifier/"+editID,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
               result(data);
            }
        });  
}
function getMenuResep(result){
    $.ajax({
            url : site_url+"menu/getMenuResep/"+editID,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
               result(data);
            }
        });  
}

function genereateModifierField(){
    var fnc = getMenuModifier(function (listMod){
      if(listMod.length > 0){
        var next = 1;  
        var myField = "";
        $('#piltam').prop("checked",true); 
        $("#pnt").show();
        $('#count').val(listMod.length);
        $.each(listMod,function (index, item){
            myField += generateField2(next, item);
            next++;
        });
        $("#pntTab tbody").html(myField);
        generateAutocomplete2();
        deleteBtnFnc();
      }else{
          $('#count').val('0');
      }  
      
    });
}
function genereateResepField(){
    var fnc = getMenuResep(function (listMod){
      if(listMod.length > 0){
        var next = 1;  
        var myField = "";
        $('#resep').prop("checked",true); 
        $("#rsp").show();
        $('#count2').val(listMod.length);
        $.each(listMod,function (index, item){
            myField += generateFieldResep(next);
            next++;
        });
        $("#rspTab tbody").html(myField);
        generateSelect2Resep2(listMod);
        deleteBtnFncResep();
      }else{
          $('#count2').val('0');
      }  
      
    });
}

function generateField2(next, item){
    return  '<tr id="row'+next+'">'+
                '<td><input id="mod-'+next+'" type="text" name="modifier[]" class="form-control input-sm" value="'+item.id_modifier+'"></td>'+
                '<td><input id="tam-'+next+'" type="text" name="tampilan[]" class="form-control input-sm" value="'+item.tampilan+'"></td>'+
                '<td><input id="har-'+next+'" type="text" name="harga[]" class="form-control input-sm" value="'+item.harga_modifier+'"></td>'+
                '<td><button type="button" id="del-'+next+'" class="btn btn-xs btn-flat btn-danger del-btn"><i class="fa fa-close"></i></button>'+
                '</td></tr>';
}


function generateAutocomplete2(){
    $('#pntTab tbody tr').each(function (i, row){
        var next = row.id;
        next = next.replace(/\D/g,'');
        generateAutocomplete(next);
        $("#tam-"+next).prop("readonly",true);
        $("#har-"+next).prop("readonly",true);
    });
}

function generateSelect2Resep2(listMod){
    var i = 0;
    $('#rspTab tbody tr').each(function (i, row){
        var next = row.id;
        next = next.replace(/\D/g,'');
        generateSelect2Resep(next);
        $( '#bhn-'+next ).val(listMod[i].id_bahan).trigger('change');
        $( '#qty-'+next ).val(listMod[i].jumlah);
    });
   
}

