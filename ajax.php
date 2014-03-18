<?php
    require_once 'libs/smj/Database.php';
	include_once 'config.php';
    include_once 'headers.php';    
    if(isset($module)) {
        echo $module->ajax();
    }


?>
