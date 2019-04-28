//$(document).ajaxStart(function() { Pace.restart(); });
$(function() {
     var pgurl = window.location.href;
             $("#control-sidebar-home-tab ul li a").each(function(){
                  if($(this).attr("href") == pgurl || $(this).attr("href") == '' )
                  $(this).parent().addClass("active");
             })
    
    });
    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('txt').innerHTML =
        h + ":" + m + ":" + s;
        var t = setTimeout(startTime, 500);
    }
    
    function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
    }
    