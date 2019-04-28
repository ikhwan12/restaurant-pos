 var kategoriTable;
 var menuTable;
 var orderTable;
 var id_order;
 var sub;
 $(function () {
        if(outlet == ""){
                outlet = "null";
            }
         
        if(outlet == 'null')show_info();
       
         
        $('#box-kategori').slimScroll({
            color: '#ff3232',
            size: '10px',
            height: 'auto',
            railVisible: true,
            railColor: '#222',
            alwaysVisible: false,
            disableFadeOut: true
        });
        $('#box-menu').slimScroll({
            color: '#ff3232',
            size: '10px',
            height: 'auto',
            railVisible: true,
            railColor: '#222',
            alwaysVisible: false,
            disableFadeOut: true
        });
        $('#box-order').slimScroll({
            color: '#ff3232',
            size: '10px',
            height: 'auto',
            railVisible: true,
            railColor: '#222',
            alwaysVisible: false,
            disableFadeOut: true
        });
         
        $('#diskon').number(true, 0, ',','.')
        get_detail($('#id_order').val());
        
        $('#list-order').click(function (){
           location.replace(site_url+'order/list_order'); 
        });
        $('#meja').click(function (){
           var c = (outlet == 'null') ?  show_info():location.replace(site_url+'order/table'); 
           
        });
        
        id_order = $('#id_order').val();
        $("#noNota").text($('#id_order').val());
         kategoriTable = $('#kategori').DataTable({
          "dom": 'rt',
          "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
          "paging": false,
          "lengthChange": false,
          "searching": false,
          "ordering": false,
          "info": false,
          "autoWidth": false,
          "ajax": {
                "url": site_url+"order/view_kategori",
                "dataSrc": ""
              },
          "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false
            }
            ]
        });
        
         $('#kategori tbody').on( 'click', 'tr', function () {
            
            if ( $(this).hasClass('active') ) {
            $(this).removeClass('active');
            }
            else {
                kategoriTable.$('tr.active').removeClass('active');
                $(this).addClass('active');
            }
            var id = kategoriTable.row( this ).data()[0];
            menuTable.ajax.url( site_url + "order/view_menu_outlet/" + outlet + "/" + id).load();
        } );
        
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
                "url": site_url+"order/view_menu_outlet/"+outlet,
                "type": "POST",
                data:{ajaxreq:true}
            },
          "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false
            },
            { "className": "text-right", "targets": 3 }
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
            var harga = menuTable.row( this ).data()[3];
            harga = harga.replace(/[^0-9]/g,'');
            haveOption(id, harga)
            
        } );
        
        orderTable = $('#order').DataTable({
          "dom": 'rt',
          "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>',
            },
          "paging": false,
          "lengthChange": false,
          "searching": false,
          "ordering": false,
          "info": false,
          "autoWidth": false,
          "processing": true, //Feature control the processing indicator.
          "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"detail_order/view",
                "type": "POST",
                data:{ajaxreq:true,id_order:id_order}
            },
          "columnDefs": [
            { "className": "text-right", "targets": 2 },
            {
                "targets": [ 0 ],
                "visible": false
            }
            ]
        });
        $('#order tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('active') ) {
            $(this).removeClass('active');
            }
            else {
                orderTable.$('tr.active').removeClass('active');
                $(this).addClass('active');
            }
            var id = orderTable.row( this ).data()[0];
            get_detail_order(id);
        } );
        
        $("#searchmenu").keyup(function(){
                menuTable.search(this.value).draw();
        });
        
        $('#p_diskon').keyup(function (){
            var diskon = parseInt(sub)*(this.value/100);
            $('#diskon').val(diskon);
        });
        $('#diskon').keyup(function (){
            var diskon = this.value.replace(/[^0-9]/g,'')/sub*100;
            $('#p_diskon').val(diskon.toFixed(2));
        });
        
        $('#simpanBtn').click(function (){
            if(outlet != 'null'){ 
                var customer = $('#customer').val();
                var meja = $('#no_meja').val();
                var ppn = $('#ppn').text();
                var diskon = $('#diskon').val();
                $.ajax({
                    url : site_url+"order/update",
                    data: {customer:customer, meja:meja, ppn:ppn, id_order:id_order, diskon:diskon},
                    type: "POST",
                    dataType: "JSON",
                    success: function(data)
                    {
                       if(data.status){
                           location.replace(site_url+'order');
                       }
                    }
                });
            }else{show_info()}
        });
        
        $('#addUserForm').formValidation({
           icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
            qty: {
                    row: '.col-sm-9',
                    validators: {
                        integer: {
                            message: 'Masukkan angka'
                        },
                        notEmpty: {
                            message: 'Mohon diisi.'
                        }
                    }
                },
            
            }
        });
        
        var fv =  $('#addUserForm').data('formValidation');
        $('#opsiForm').formValidation({
           icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
            jml: {
                    row: '.col-sm-9',
                    validators: {
                        integer: {
                            message: 'Masukkan angka'
                        },
                        notEmpty: {
                            message: 'Mohon diisi.'
                        }
                    }
                },
            
            }
        });
        
        var fv2 =  $('#opsiForm').data('formValidation');
    
    $('#saveBtn').click(function (){
        fv.validate();
        if(fv.isValid()){
            $.ajax({
                url : site_url+"detail_order/update_qty",
                data: $('#addUserForm').serialize(),
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                   if(data.status){
                        $("#modal-info").modal('hide');
                        get_detail(id_order);
                        reset_form(fv);
                        reload_table();
                   }
                }
            });
        }
         
    });
    
    $('#hapusBtn').click(function (){
        if(outlet != 'null'){
            if(confirm("Anda Yakin?")){
                $.ajax({
                    url : site_url+"order/delete/"+id_order,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data)
                    {
                       if(data.status){
                           location.replace(site_url+'order');
                       }
                    }
                });
            }
        }else{show_info();}
    });
    
    $('#bayarBtn').click(function (){
        if(outlet != 'null'){
            var customer = $('#customer').val();
            var meja = $('#no_meja').val();
            var ppn = $('#ppn').text();
            var diskon = $('#diskon').val();
            $.ajax({
                url : site_url+"order/update2",
                data: {customer:customer, meja:meja, ppn:ppn, id_order:id_order, diskon:diskon},
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                   if(data.status){
                       location.href = site_url+'order/payment/'+id_order;
                   }
                }
            });
        }else{show_info();}
    });
    
    $("#opsiOKBtn").click(function (){
         $.ajax({
                url : site_url+"detail_order/addWithOption/",
                data: $("#opsiForm").serialize(),
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                   if(data.status){
                       get_detail(id_order);
                       reload_table();
                       $("#modal-option").modal('hide');
                   }
                }
            });
    });
     
});

function reload_table(){
    orderTable.ajax.reload(null,false); //reload datatable ajax 
}  

function haveOption(id, harga){
    $.ajax({
            url : site_url+"order/haveOption/"+id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $("#opsiForm")[0].reset();
                $('#opsi').html('');
                if(data.length > 0){
                    $('#opsi').append("<option value=''>Pilih Opsi Menu</option>");
                    $.each(data, function(key, value){
                        $('#opsi').append("<option value='"+value.id_modifier+"'>"+value.tampilan+"</option>");
                    });
                    $('#opsi').change(function (){
                        var o = this.value;
                        $.each(data, function(key, item){
                            if(item.id_modifier == o){
                                $("#harga_modifier").val(item.harga_modifier);
                            }
                        });
                    });
                    $("#harga_om").val(harga);
                    $("#id_order_wo").val(id_order);
                    $("#jml").val(1);
                    $("#idOm").val(id);
                    $("#modal-option").modal('show');
                }else{
                    add(id, harga);
                }
            }
        });
}
 
function add(id, harga){
    $.ajax({
            url : site_url+"detail_order/add/",
            type: "POST",
            data: {id_order:id_order, id_om:id, harga:harga},
            dataType: "JSON",
            success: function(data)
            {
                if(data.status){
                    get_detail(id_order);
                    reload_table();
                }
            }
        });
}

function get_detail(id){
    $.ajax({
            url : site_url+"order/detail/"+id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
               sub = data.subtotal;
               if(sub == null){
                   sub = 0;
               }
               var ppn = data.o_ppn;
               if(ppn == null){
                   ppn = data.ppn;
               }
               var pd;
               if(data.diskon != 0){
                  pd  = data.diskon/sub*100;
               }else{
                  pd = 0; 
               }
               pd = pd.toFixed(2);
               if(data.meja!=null){
                   $('#assign_table').removeAttr('href');
               }
               
               
               $('#diskon').val(data.diskon);
               $('#p_diskon').val(pd);
               $('#customer').val(data.customer);
               $('#no_meja').val(data.meja);
               $('#ppn').text(ppn);
               $('#ppn_value').text($.number(ppn/100 * (sub - data.diskon),0,',','.'));
               $('#subtotal').text($.number(sub - data.diskon,0,',','.'));
               $('#total').text($.number(parseInt(sub) - data.diskon  + (ppn/100 * (sub-data.diskon)),0,',','.'));
            }
        });
}

function get_detail_order(id){
    $('#id').val(id);
    $.ajax({
                url : site_url+"detail_order/detail/"+id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                   if(data){
                        $('#qty').val(data.jumlah);
                        $("#modal-info").modal('show');
                   }
                }
            });
}

function reset_form(fv){
   fv.resetForm();
   $('#addUserForm')[0].reset();
}

function show_info(){
    $('#modal-alert').modal('show');
}
