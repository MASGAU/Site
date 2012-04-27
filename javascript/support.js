var current_hash = false;
var loaded = false;
$(document).ready(function() {
    setInterval(function() {
        if(!window.location.hash&&!loaded) {
            $('#ajax').load("ajax.php?module=support&filter=A");
            loaded = true;
        } else {
            if(window.location.hash != current_hash) {
                current_hash = window.location.hash;
                name = current_hash.substring(1);
                $('#ajax').load("ajax.php?module=support&filter="+name);
            }  
        }
        
    }, 100); 
});

