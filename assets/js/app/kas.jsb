var rekapTable;
var masukTable;
var keluarTable;
var resumeTable;
var detailTable;
var detailTable;
var changeId;
var action;
var selectedID;
$(document).ready(function() {
       
       $("#printReport").click(function (){
           if(typeof selectedID !== "undefined"){
               window.open(site_url+"kas/printRekap/"+selectedID); 
           }else{
               alert("Pilih Rekap Kas.")
           }
           
       });
       
        masukTable = $('#kas-masuk').DataTable({ 
            dom: "B<'row'<'col-md-6'l><'col-md-6'f>>rtip",
             buttons: [
                {
                    extend: 'print',
                    message: 'Kas Masuk',
                    text:      '<i class="fa fa-print"></i>',
                    titleAttr: 'Print',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excelHtml5',
                    text:      '<i class="fa fa-file-excel-o"></i>',
                    titleAttr: 'Excel',
                    exportOptions: {
                        columns: ':visible'
                }
                },
                {
                    extend: 'colvis',
                    text:      '<i class="fa fa-filter"></i>',
                    titleAttr: 'Column Visibility',
                    collectionLayout: 'fixed three-column',
                    postfixButtons: [ 'colvisRestore' ]
                }
            ],
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "autoWidth": false,
            "ajax": {
                "url": site_url+"kas/view/masuk",
                "dataSrc": ""
             },
            "columnDefs": [
            
            {
                "targets": [ 0 ],
                "visible": false
            }
            
            ],
        } );
          $('#kas-masuk tbody').on( 'click', 'tr', function () {
            
            if ( $(this).hasClass('active') ) {
            $(this).removeClass('active');
            }
            else {
                masukTable.$('tr.active').removeClass('active');
                $(this).addClass('active');
            }
            var id = masukTable.row( this ).data()[0];
            changeId = id;
            change(id);
        } );
        
          masukTable.buttons().container()
        .appendTo( '#tableBtn2');
        
        keluarTable = $('#kas-keluar').DataTable({ 
            dom: "B<'row'<'col-md-6'l><'col-md-6'f>>rtip",
             buttons: [
                {
                    extend: 'print',
                    message: 'Kas Keluar',
                    text:      '<i class="fa fa-print"></i>',
                    titleAttr: 'Print',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excelHtml5',
                    text:      '<i class="fa fa-file-excel-o"></i>',
                    titleAttr: 'Excel',
                    exportOptions: {
                        columns: ':visible'
                }
                },
                {
                    extend: 'colvis',
                    text:      '<i class="fa fa-filter"></i>',
                    titleAttr: 'Column Visibility',
                    collectionLayout: 'fixed three-column',
                    postfixButtons: [ 'colvisRestore' ]
                }
            ],
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "autoWidth": false,
            "ajax": {
                "url": site_url+"kas/view/keluar",
                "dataSrc": ""
             },
            "columnDefs": [
            
            {
                "targets": [ 0 ],
                "visible": false
            }
            
            ],
        } );
        
          $('#kas-keluar tbody').on( 'click', 'tr', function () {
            
            if ( $(this).hasClass('active') ) {
            $(this).removeClass('active');
            }
            else {
                keluarTable.$('tr.active').removeClass('active');
                $(this).addClass('active');
            }
            var id = keluarTable.row( this ).data()[0];
            changeId = id;
            change(id);
        } );
        
        keluarTable.buttons().container()
        .appendTo( '#tableBtn1');
        
        rekapTable = $('#rekapTable').DataTable({ 
            "dom": 'rt',
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "paging": false,
            "autoWidth": false,
            "ajax": {
                "url": site_url+"kas/view_rekap",
                "dataSrc": ""
             },
            "columnDefs": [
            
            {
                "targets": [ 0 ],
                "visible": false
            }
            
            ],
        } );
        $('#rekapTable tbody').on( 'click', 'tr', function () {
            
            if ( $(this).hasClass('active') ) {
            $(this).removeClass('active');
            }
            else {
                rekapTable.$('tr.active').removeClass('active');
                $(this).addClass('active');
            }
            var id = rekapTable.row( this ).data()[0];
            selectedID = id;
            resumeTable.ajax.url( site_url+"kas/view_resume"+'/'+id).load();
            detailTable.ajax.url( site_url+"kas/view_detail"+'/'+id).load();
            rekapDetail(id);
        } );
        
        resumeTable = $('#resumeTable').DataTable({ 
            "dom": 'rt',
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "ordering" : false,
            "paging": false,
            "autoWidth": false,
            "ajax": {
                "url": site_url+"kas/view_resume",
                "dataSrc": ""
             },
             "columnDefs": [
                  { 
                      "className": "text-right", "targets": [1,2,3] 
                  }
            ]
        } );
        detailTable = $('#detailTable').DataTable({ 
            "dom": 'rt',
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "ordering" : false,
            "paging": false,
            "autoWidth": false,
            "ajax": {
                "url": site_url+"kas/view_detail",
                "dataSrc": ""
             },
             "columnDefs": [
                  { 
                      "className": "text-right", "targets": [1] 
                  }
            ]
        } );
        
         $('#addUserForm').formValidation({
           icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
            catatan: {
                    row: '.col-sm-9',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                },
            jumlah: {
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
         $('#addUserForm2').formValidation({
           icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
            kartu: {
                    row: '.col-sm-5',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                },
            tunai: {
                    row: '.col-sm-5',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                }
            }
        });
        
        var fv2 =  $('#addUserForm2').data('formValidation');
        
         $("#addMasukBtn").click(function (e){
            action = "AddMasuk";
            $(".modal-title").text("Kas Masuk");
            $("#addMasukBtn").prop("disabled", true);
            $("#modal-masuk").modal("show");
        });
         $("#addKeluarBtn").click(function (e){
            action = "AddKeluar";
            $(".modal-title").text("Kas Keluar");
            $("#addKeluarBtn").prop("disabled", true);
            $("#modal-masuk").modal("show");
        });
        
        $('#saveBtn').on('click', function(){
            fv.validate();
            if(fv.isValid()){
                addUser(fv);
            }
        });
        
        $('#saveRekap').on('click', function(){
            fv2.validate();
            if(fv2.isValid()){
                addUser2(fv2);
            }
        });
        
        $("#cancelBtn").click(function (e){
           resetForm(fv);
           changeAddBtn();
        });
        
} );

function reload_table(){
    masukTable.ajax.reload(null,false); //reload datatable ajax 
    keluarTable.ajax.reload(null,false); //reload datatable ajax 
} 
function reload_table2(){
    rekapTable.ajax.reload(null,false); //reload datatable ajax 
} 

function resetForm(fv){
   fv.resetForm();
   $('#addUserForm')[0].reset();
   action = "";
}
function resetForm2(fv){
   fv.resetForm();
   $('#addUserForm2')[0].reset();
}

function changeAddBtn(){
   $("#addMasukBtn").prop("disabled", false);
   $("#addKeluarBtn").prop("disabled", false);
}

    
function addUser(fv){
         var url;
         if(action == "AddMasuk"){
             url = site_url+"kas/add/masuk";
         }else if(action == "AddKeluar"){
             url = site_url+"kas/add/keluar";
         }else{
             url = site_url+"kas/update";
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
                        $("#modal-masuk").modal("hide");
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
function addUser2(fv){
         $.ajax({
                url : site_url+"kas/addRekap",
                type: "POST",
                data: $("#addUserForm2").serialize(),
                dataType: "JSON",
                beforeSend: function() { 
                    $("#saveRekap").text("Saving...");
                    $("#saveRekap").prop('disabled', true); // disable button
                },
                success: function(data)
                {
                    if(data.status){
                        reload_table2();
                        resetForm2(fv);
                        $("#saveRekap").text("Save");
                        $("#saveRekap").prop('disabled', false);
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
            url : site_url+"kas/detail/"+id ,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('#catatan').val(data.catatan);
                $('#jumlah').val(data.jumlah);
                $("#addBtn").prop("disabled", true);
                $("#modal-masuk").modal("show");
            }
        });
}

function rekapDetail(id){
    $.ajax({
            url : site_url+"kas/rekapDetail/"+id ,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('#dateTime').text(data.date);
                $('#jumlahJual').text(data.jumlah);
            }
        });
}