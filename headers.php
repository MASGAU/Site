<?php
    // Includes 
    $folder =  dirname(__FILE__);
    //require_once $folder.'/libs/geshi/geshi.php';
    
    function __autoload($class_name) {
        $folder =  dirname(__FILE__);
        if(is_file($folder.'/libs/smj/'.$class_name.'.php')) {
            include_once $folder.'/libs/smj/'.$class_name.'.php';
        }
        if(is_file($folder.'/libs/gsi/data/'.$class_name.'.php')) {
            include_once $folder.'/libs/gsi/data/'.$class_name.'.php';
        }
        if(is_file($folder.'/libs/gsi/api/'.$class_name.'.php')) {
            include_once $folder.'/libs/gsi/api/'.$class_name.'.php';
        }
        if(is_file($folder.'/libs/gsi/exporters/'.$class_name.'.php')) {
            include_once $folder.'/libs/gsi/exporters/'.$class_name.'.php';
        }
    }
    
    include_once $folder.'/config.php';
    include_once $folder.'/libs/smj/Database.php';
    
    global $test_mode;
    $url = $_SERVER["SERVER_NAME"];
    if(strstr($url,"tardis")) {
            $test_mode = true;
    } else {
            $test_mode = false;
    }
    
    
    global $gdb;
    $gdb = Databases::$gamesaveinfo;
    $gdb->connect();

    if(isset($_GET["module"])) {
        $module = $_GET["module"];
    }
    
    if(isset($module)) {
        include_once 'modules/AModule.php';
        $module = AModule::LoadModule($module);
    }

?>
