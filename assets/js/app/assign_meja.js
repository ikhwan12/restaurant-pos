$(function(){
    $('#addBtn').click(function (){
       if(outlet == ''){
            $('#modal-alert').modal('show'); 
        }else{
            $('#modal-info').modal('show'); 
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
    $("#t"+id+" div").removeClass('bg-aqua');
    $("#t"+id+" div").addClass('bg-blue');
     $.ajax({
            url : site_url+"order/update_meja",
            type: "POST",
            data: {id_order:id_order, meja:id},
            dataType: "JSON",
            beforeSend: function (xhr) {
                    $('#loader').addClass('loader');
                    $('#loader-c').addClass('olay');
                },
            success: function(data)
            {
                if(data.status){
                    location.replace(site_url+'order/myorder/'+id_order);
                }
            }
        });
    
    
}