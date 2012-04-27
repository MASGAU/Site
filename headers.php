<?php
    ini_set('default_charset', 'UTF-8');

    
    // Includes 
    include_once 'DBSettings.php';
    include_once 'libs/geshi/geshi.php';

    $con = mysql_connect($db_server,$db_user,$db_password);
    
    if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }
    mysql_select_db("masgau_game_data", $con);    
    mysql_set_charset('utf8', $con);


    if(isset($_GET["module"])) {
        $module = $_GET["module"];
    }
    
    if(isset($module)) {
        include_once 'modules/AModule.php';
        $module = AModule::LoadModule($module, $con);
    }

?>