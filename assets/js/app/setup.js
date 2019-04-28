$(document).ajaxStart(function() { Pace.restart(); });
$(function (){
   
   //Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();
    
    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        var $target = $(e.target);
    
        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });
    
   $('.wizard .nav-tabs li').addClass('disabled');
   
   $.ajax({
        url : site_url+"setup/cek_setup_status",
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
           if(!data.db_config && !data.activation && !data.registration){
                $('[data-form="db"]').removeClass('disabled');
                $('[data-form="db"]').find('a[data-toggle="tab"]').click();
           }else if(data.db_config && !data.activation && !data.registration){
               $('[data-form="activation"]').removeClass('disabled');
               $('[data-form="activation"]').find('a[data-toggle="tab"]').click();
           }else if(data.db_config && data.activation && !data.registration){
                list_position();
               $('[data-form="registration"]').removeClass('disabled');
               $('[data-form="registration"]').find('a[data-toggle="tab"]').click();
           }else{
               changFinish();
               $('[data-form="success"]').removeClass('disabled');
               $('[data-form="success"]').find('a[data-toggle="tab"]').click();
           }
        }
    });
    
   
   $('#setting').formValidation({
           icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
            host: {
                    row: '.col-sm-10',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                },
            username: {
                    row: '.col-sm-10',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                },
            database: {
                    row: '.col-sm-10',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                }
            
            }
        });
        var fv =  $('#setting').data('formValidation');
        
        $('#activation').formValidation({
           icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
            serial: {
                    row: '.col-sm-10',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                },
            
            }
        });
        var fv2 =  $('#activation').data('formValidation');
        
        $('#registration').formValidation({
           icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
            id_posisi: {
                    row: '.col-sm-10',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                },
            nama: {
                    row: '.col-sm-10',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                },
            user_pass: {
                    row: '.col-sm-10',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                }
            }
        });
        var fv3 =  $('#registration').data('formValidation');
        
        $('#saveBtn').on('click', function(e){
            var $active = $('.wizard .nav-tabs li.active');
            var data_form = $('.wizard .nav-tabs li.active').attr('data-form');
            if( data_form === 'registration'){
                fv3.validate();
                if(fv3.isValid()){
                    var registered = addAdmin(function (resp){
                        if(resp.status){
                            changFinish();
                            disableTab($active);
                        }else{
                            alert("Registration Fail.");
                        } 
                     });
                }
            }else if(data_form === 'success'){
                location.replace(site_url+'login');
            }
            else if(data_form === 'db'){
                fv.validate();
                if(fv.isValid()){
                     var saveDB = saveDBConfig(function (resp){
                        if(resp.status){
                            disableTab($active);
                        }else{
                            $('#message').html(resp.message);
                            $('#modal-info').modal('show');
                        } 
                     });
                }
            }
            else if(data_form === 'activation'){
                fv2.validate();
                if(fv2.isValid()){
                     var activation = activateProduct(function (resp){
                        if(resp.status){
                            list_position()
                            disableTab($active);
                        }else{
                            $('#message').html("Wrong Serial Key!");
                            $('#modal-info').modal('show');
                        } 
                     });
                }
            }
        });
        
        $('[name="id_posisi"]').change(function (){
                fv3.resetForm();
                if(this.value != ''){
                    var selected_text = this.options[this.selectedIndex].innerHTML;
                    generateID(selected_text); 
                }else{
                    $('[name="id_user"]').val('');
                    $('[name="user_pass"]').val('');
                }
        });
    
});

function disableTab($active){
    $('.wizard .nav-tabs li').addClass('disabled');
    $active.next().removeClass('disabled');
    nextTab($active);
}

function changFinish(){
    $('#saveBtn').text("Finish");
    $('#saveBtn').removeClass("btn-primary");
    $('#saveBtn').addClass("btn-success");
}

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}

function saveDBConfig(handleData){
    $.ajax({
        url : site_url+"setup/saveDBConfig",
        type: "POST",
        data: $("#setting").serialize(),
        dataType: "JSON",
        beforeSend: function() { 
            $('#loader').addClass('loader');
            $('#loader-c').addClass('olay');
            $("#saveBtn").text("Saving...");
            $("#saveBtn").prop('disabled', true); // disable button
        },
        success: function(data)
        {
            $('#loader').removeClass('loader');
            $('#loader-c').removeClass('olay');
            $("#saveBtn").text("Next");
            $("#saveBtn").prop('disabled', false);
            handleData(data);
        }
    });
}

function activateProduct(handleData){
    $.ajax({
        url : site_url+"setup/activate",
        type: "POST",
        data: $("#activation").serialize(),
        dataType: "JSON",
        beforeSend: function() { 
            $('#loader').addClass('loader');
            $('#loader-c').addClass('olay');
            $("#saveBtn").text("Saving...");
            $("#saveBtn").prop('disabled', true); // disable button
        },
        success: function(data)
        {
            $('#loader').removeClass('loader');
            $('#loader-c').removeClass('olay');
            $("#saveBtn").text("Next");
            $("#saveBtn").prop('disabled', false);
            handleData(data);
        }
    });
}

function addAdmin(handleData){
    $.ajax({
        url : site_url+"setup/add_admin",
        type: "POST",
        data: $("#registration").serialize(),
        dataType: "JSON",
        beforeSend: function() { 
            $('#loader').addClass('loader');
            $('#loader-c').addClass('olay');
            $("#saveBtn").text("Saving...");
            $("#saveBtn").prop('disabled', true); // disable button
        },
        success: function(data)
        {
            $('#loader').removeClass('loader');
            $('#loader-c').removeClass('olay');
            $("#saveBtn").text("Next");
            $("#saveBtn").prop('disabled', false);
            handleData(data);
        }
    });
}

function list_position(){
    $.ajax({
            url : site_url+"setup/daftar_posisi",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $.each(data, function(key, value){
                        $('[name="id_posisi"]').append("<option value='"+key+"'>"+value+"</option>");
                });
                $('[name="id_posisi"]').val('');
            }
        });   
}

function generateID(text){
        
        $.ajax({
                url : site_url+"setup/generateID",
                type: "POST",
                data: {posisi: text},
                dataType: "JSON",
                success: function(data)
                {
                        $('[name="id_user"]').val(data.id);
                        $('[name="user_pass"]').val(data.id);
                }
            });
        
    }