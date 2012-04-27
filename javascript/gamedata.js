var current_hash = true;
var last_name = false;

$(document).ready(function() {
    setInterval(function() {
        if(window.location.hash != current_hash) {
            current_hash = window.location.hash;
            if(current_hash==false) {
                $('#ajax').load("ajax.php?module=game_data");
            } else {
                name = current_hash.substring(1);
                $('#ajax').load("ajax.php?module=game_data&name="+name);
                name = name.replace('+','_');
                if(last_name!=false) {
                    $('#'+last_name+'_link').removeClass('selected_link');
                }
                $('#'+name+'_link').addClass('selected_link');
                last_name = name;
            }
        }        
    }, 100); 
});

