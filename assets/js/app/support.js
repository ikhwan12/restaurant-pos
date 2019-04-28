$(document).ready(function (){
    
    $.ajax({
       url:  site_url+"support/detail/"+previlage,
       type: 'GET',
       dataType: 'json',
       success: function(data){
            if(data.posisi == "Admin"){
                $("#updateBtn").show();
            }else{
                $("#updateBtn").hide();
            }
        }
    });
    
    $('#updateBtn').click(function (){
         $('#modal-confirm').modal('show');
    });
    $('#myfile').change(function (){
       $('#filename').val(this.value); 
    });
    $('#uploadSubmitBtn').on('click', function() {
        var file_data = $('#myfile').prop('files')[0];   
        var form_data = new FormData();
        form_data.append('file', file_data);                        
        $.ajax({
            url:  site_url+"support/updateApp",
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: $("#uploadForm").serialize(),                         
            data: form_data,                         
            type: 'post',
            success: function(data){
                if(data.status){
                    location.replace(site_url+'support');
                }else{
                    alert(data.message);
                }
            }
        });
            
        }); 
        
        $('#noBtn').click(function (){
           $('#uploadForm')[0].reset(); 
        });
});