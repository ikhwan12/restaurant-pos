var menuTable;
var menuOutletTable;
var action;
 $(function () {
         
         menuTable = $('#menu').DataTable({
          "dom": 'rt',
          "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>',
            },
          "paging": false,
          "lengthChange": false,
          "searching": true,
          "ordering": false,
          "info": false,
          "autoWidth": false,
          "processing": true, //Feature control the processing indicator.
          "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"menu_outlet/view_menu",
                "type": "POST",
                data:{ajaxreq:true}
            },
          "columnDefs": [
            {
                "targets": [ 0, 3, 4 ],
                "visible": false
            }
            ]
        });
        
         $('#menu tbody').on( 'click', 'tr', function () {
            
            if ( $(this).hasClass('active') ) {
            $(this).removeClass('active');
            }
            else {
                menuTable.$('tr.active').removeClass('active');
                $(this).addClass('active');
            }
            var id = menuTable.row( this ).data()[0];
            var price = menuTable.row( this ).data()[3];
            var gojek_price = menuTable.row( this ).data()[4];
            if(outlet == ""){
                $('#modal-alert').modal('show')
            }else{
                check_added(id, function (output){
                    if(output.status){
                         $("#priceTitle").text("Tambah Menu Outlet");
                         action = 'Add';
                         $('#id_menu').val(id);
                         $('#harga').val(price);
                         $('#harga_gojek').val(gojek_price);
                         $('#modal-confirm').modal('show');
                     }else{
                         $('#modal-info').modal('show');
                     }
                 });
            }
        } );
        
        menuOutletTable = $('#menu-outlet').DataTable({
          "dom": 'rt',
          "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>',
            },
          "paging": false,
          "lengthChange": false,
          "searching": true,
          "ordering": false,
          "info": false,
          "autoWidth": false,
          "processing": true, //Feature control the processing indicator.
          "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"menu_outlet/view_menu_outlet/",
                "type": "POST",
                data:{ajaxreq:true}
            },
          "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false
            },
            { "className": "text-right", "targets": [3,4] }
            ]
        });
        
         $('#menu-outlet tbody').on( 'click', 'tr', function () {
            
            if ( $(this).hasClass('active') ) {
            $(this).removeClass('active');
            }
            else {
                menuOutletTable.$('tr.active').removeClass('active');
                $(this).addClass('active');
            }
            var id = menuOutletTable.row( this ).data()[0];
            change(id);
        } );
        
        
        $("#searchmenu").keyup(function(){
                menuTable.search(this.value).draw();
        });
        
        $.ajax({
            url : site_url+"outlet/daftar_outlet",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $.each(data, function(key, value){
                        $('#outlet').append("<option value='"+key+"'>"+value+"</option>");
                });
                $('#outlet').val('');
                $('#outlet').select2();
            }
        });  
        
        $('#outlet').change(function (){
           menuOutletTable.ajax.url( site_url + "menu_outlet/view_menu_outlet/" + this.value).load(); 
        });
        
        
        $('#addUserForm').formValidation({
           icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
            harga: {
                    row: '.col-sm-9',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        },
                        integer:{
                            message:"Only integer allowed"
                        }
                    }
                },
            harga_gojek: {
                row: '.col-sm-9',
                validators: {
                    integer:{
                        message:"Only integer allowed"
                    }
                }
            }
            
            }
        });
        
        var fv =  $('#addUserForm').data('formValidation');
        
        $('#saveBtn').click(function (){
            fv.validate();
            if(fv.isValid()){
                addUser(fv);
            }
        });
        
      });
      
function reload_table(){
menuOutletTable.ajax.reload(null,false); //reload datatable ajax 
} 

function resetForm(fv){
   fv.resetForm();
   $('#addUserForm')[0].reset();
   $('#modal-confirm').modal('hide');
}

function changeAddBtn(){
   $("#saveBtn").prop("disabled", false);
   if(action=="Update"){
       $("#priceTitle").text("Tambah Menu Outlet");
   }
}

function addUser(fv){
         
         var url;
         if(action == "Add"){
             url = site_url+"menu_outlet/add";
         }else{
             url = site_url+"menu_outlet/update";
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
 
 function check_added(id, handleData){
     $.ajax({
            url : site_url+"menu_outlet/cek_added",
            type: "POST",
            data: {outlet: outlet , menu: id},
            dataType: "JSON",
            success: function(data)
            {
                handleData(data); 
            }
        });
 }
 
 function change(id){
    action = "Update";
    $('#id').val(id);
    $.ajax({
            url : site_url+"menu_outlet/detail/"+id ,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('#harga').val(data.harga);
                $('#harga_gojek').val(data.harga_gojek);
                $("#priceTitle").text("Ubah Harga");
                $("#modal-confirm").modal('show');
            }
        });

}