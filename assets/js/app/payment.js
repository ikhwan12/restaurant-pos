var clear = true;
$(function (){
    
    $('#print').val('Rp. 0');
    $('#tunai').attr('checked', true);
    $('input').iCheck({
        checkboxClass: 'icheckbox_square',
        radioClass: 'iradio_square-green',
        increaseArea: '20%' // optional
      });
  $('[name="iCheck"]').on('ifChecked', function(event){
         if(this.value === 'tunai'){
             $('#dk-detail').hide();
         }else{
             $('#dk-detail').show();
         } 
  });
  
   $.ajax({
        url : site_url+"order/cek_paid/"+id_order,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            
           if(data.paid){
               $('#cara').text(data.cara);
               $('#kembali').text('Rp. '+$.number(data.kembali,0,',','.'));
               $('#payment_form').hide();
               $('#info_form').show();
                printReceipt(id_order);
           }else{
               $('#payment_form').show();
               $('#info_form').hide();
           }
        }
    });
  $.ajax({
        url : site_url+"order/get_total/"+id_order,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
           if(data.status){
               $('[name="total"]').val("Rp. " + $.number(data.total,0,',','.'));
           }
        }
    });
    
    $("#selesai").click(function (){
        location.replace(site_url+"order");
    });
    
    $('#pay').click(function (){
        if(id_order != ''){
            var metode = $('[name="iCheck"]:checked').val();
            var total = $('#total').val();
            var bayar = $('#print').val();
            var bank =  $('#bank').val();
            var kartu = $('#kartu').val();
            var catatan = $('#catatan').val();
                if(check_bayar()){
                    if(check_metode(metode, bank, kartu)){
                        $.ajax({
                        url : site_url+"order/bayar",
                                type: "POST",
                                data:{
                                    id:id_order,
                                    metode:metode, 
                                    bayar:bayar.replace(/[^0-9]/g,''), 
                                    total:total.replace(/[^0-9]/g,''),
                                    bank:bank,
                                    kartu:kartu,
                                    catatan:catatan
                                  },
                                dataType: "JSON",
                                success: function(data)
                                {
                                   if(data.status){
                                       $('#cara').text(data.cara);
                                       $('#kembali').text('Rp. '+$.number(data.kembali,0,',','.'));
                                       $('#payment_form').hide();
                                       $('#info_form').show();
//                                       if(confirm("Print Receipt?")){
//                                           printReceipt(id_order);
//                                       }
                                       alertPrint(id_order);
                                   }
                                }
                        });
                    }else{
                        alert("Isikan detail pembayaran Debit/Kredit.");
                    }
                }else{
                    alert("Jumlah dibayar lebih kecil dari total belanja.");
                }
            }
    });
    
    $("#yPrint").click(function (){
        $("#print-alert").modal("hide");
        printReceipt(id_order);
    });
    
});
function go(x) {
        if(x === 'clear'){
            format_value('');
            clear = true;
        }else{
            if($('#print').val() == 0 && $('#print').val().length === 1){
                format_value('');
            }
            var val = $('#print').val();
            val = val.replace(/[^0-9]/g,'');
            val = val + x;
            format_value(val);
            clear = false;
        }
        if(clear){
            format_value(0);
        }
    };

function format_value(value){
    $('#print').val('Rp. '+$.number(value,0,',','.'));
}

function check_bayar(){
    var total = $('#total').val();
    total = parseInt(total.replace(/[^0-9]/g,''));
    var bayar = $('#print').val();
    bayar = parseInt(bayar.replace(/[^0-9]/g,''));
    if(bayar >= total){
        return true;
    }
    return false;
}

function check_metode(metode, bank, kartu){
    if(metode !== "tunai"){
        if(bank === '' || kartu === ''){
            return false;
        }
        return true;
    }
    return true;
}

function printReceipt(id){
    $.ajax({
        url: site_url+"order/strukPrint/"+id,
        dataType:"json",
        success: function (data, textStatus, jqXHR) {
            if(!data.connected){
                alert(data.message);
            }
        }
    });
}

function  alertPrint(id){
    $("#print-alert").modal("show");
}