var userTable;
var deletedId;
var action;
$(document).ready(function() {
        
         $.ajax({
            url : site_url+"pengaturan/detail",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                findPrinters(data.printer)
            }
        });
        
} );


function findPrinters(value) {
   connect().then(function() {
        qz.printers.find().then(function(data) {
            get_printer(data, value);
        }).catch(function(e) { console.error(e); });
    }).then(function() {
        success();            // exceptions get thrown all the way up the stack
    }).catch(fail);             // so one catch is often enough for all promises
  
}

function get_printer(data, value){
    $('#printer').text("");
    $('#printer').append("<option value=''>Pilih Printer...</option>");
    for(var i = 0; i < data.length; i++) {
               $('#printer').append("<option value='"+data[i]+"'>"+data[i]+"</option>");
           }
    $('#printer').val(value);  
}
