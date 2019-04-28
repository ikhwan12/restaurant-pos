var selectID;
var tabID;
$(function(){
    selectID = "";
    tabID = "";
    
    
    $("#printBtn").click(function (){
       if(selectID != ""){
            $.ajax({
                url : site_url+"order/kitchenPrint/"+selectID,
                dataType:"json",
                success: function (data, textStatus, jqXHR) {
                    if(!data.connected){
                        alert(data.message);
                    }
                }
            });
       }else{
            showWarning("Pilih Meja atau meja yang Anda pilih Kosong.");
       } 
    });
    
    $("#detailBtn").click(function (){
       if(selectID != ""){
           location.replace(site_url+'order/myorder/'+selectID);
       }else{
          showWarning("Pilih Meja atau meja yang Anda pilih Kosong.");
       } 
    });
    
    $("#delBtn").click(function (){
       if(tabID != ""){
           var color = $("#t"+tabID+" a div").hasClass('bg-aqua');
           if(color){
               deleteMeja(tabID);
           }else{
               showWarning("Meja Dipakai.");
           }
       }else{
           showWarning("Pilih Meja atau meja yang Anda pilih Kosong.");
       } 
    });
    
    $('#addUserForm').formValidation({
           icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
            no: {
                    row: '.col-sm-9',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        },
                        regexp:{
                            regexp: /^[a-zA-z 0-9]*$/,
                            message: "Character not allowed"
                        },
                        stringLength: {
                            max: 2,
                            message: 'ID must be less than 2 characters'
                        }
                    }
                },
            
            }
        });
        
        var fv =  $('#addUserForm').data('formValidation');
    
    $('#addBtn').click(function (){
        $('#addUserForm')[0].reset();
        if(outlet == ''){
            $('#modal-alert').modal('show'); 
        }else{
            $('#modal-info').modal('show'); 
        }
    });
    
    $('#saveBtn').click(function (){
        fv.validate();
        if(fv.isValid()){
            $.ajax({
                url : site_url+"order/add_meja",
                data: $('#addUserForm').serialize(),
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                   if(data.status){
                       location.replace(location.href);
                   }else{
                       alert(data.message);
                   }
                }
            });
        }
         
    });
});

function chBo(order,id){
    $(".trans").css("border","");
    $("#dv"+id).css("border","5px solid yellow");
    selectID = order;
    tabID = id;
}

function allowDrop(ev) {
    ev.preventDefault();
}

function drag(order, id, ev) {
    var color = $("#t"+id+" a div").hasClass('bg-aqua');
    if(color){
        ev.dataTransfer.setData("data", '');
        $("#t"+id+" a div").attr('ondragstart',"drag('','"+id+"',event)");
    }else{
        ev.dataTransfer.setData("data", order+'+'+id);
        $("#t"+id).attr('ondragstart',"drag('','"+id+"',event)");
    }
   
}

function drop(id, ev) {
    
    ev.preventDefault();
    var data = ev.dataTransfer.getData("data");
    data = data.split('+');
    var color = $("#t"+id+" a div").hasClass('bg-red');
    if(data != ""){
        if(color){
            alert("Meja dipakai");
        }else{
             $.ajax({
                url : site_url+"order/update_meja",
                data: {id_order:data[0],meja:id},
                type: "POST",
                dataType: "JSON",
                beforeSend: function (xhr) {
                    $('#loader').addClass('loader');
                    $('#loader-c').addClass('olay');
                },
                success: function(data)
                {
                   if(data.status){
                        location.replace(location.href);
                   }
                }
            });
        }
    }
    
}

function cetak(){
    var data = ev.dataTransfer.getData("data");
    data = data.split('+');
    alert(data[1]);
}

function showWarning(text){
    $("#warnTxt").text(text);
    $("#modal-warn").modal("show");
}

function deleteMeja(id){
    $.ajax({
                url : site_url+"order/delMeja",
                data: {no_meja:id},
                type: "POST",
                dataType: "JSON",
                beforeSend: function (xhr) {
                    $('#loader').addClass('loader');
                    $('#loader-c').addClass('olay');
                },
                success: function(data)
                {
                   if(data.status){
                        location.replace(location.href);
                   }
                }
            });
}