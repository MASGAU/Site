<?php
    include_once 'headers.php';    

    if(isset($module)) {
        echo $module->ajax();
    }


?>