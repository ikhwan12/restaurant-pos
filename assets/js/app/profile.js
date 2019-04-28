$(document).ready(function() {
        
        $.ajax({
            url : site_url+"profile/detail2",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('#username').val(data.username);
                $('#nama').val(data.nama);
                $('#alamat').val(data.alamat);
                $('#no_telp').val(data.no_telp);
                $('#address_txt').text(data.alamat);
                $('#telp_txt').text(data.no_telp);
                $('#nama_txt').text(data.nama);
                $('#posisi_txt').text(data.posisi);
            }
        });
        
         $('#form1').formValidation({
           icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
            nama: {
                    row: '.col-sm-9',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
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
                        }
                    }
                }
            }
        });
        
         $('#form2').formValidation({
           icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
            pass: {
                    row: '.col-sm-8',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                },
            v_pass: {
                    row: '.col-sm-8',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        },
                        identical: {
                            field: 'pass',
                            message: 'The password and its confirm are not the same'
                        }
                    }
                }
            }
        });
        
        
} );

