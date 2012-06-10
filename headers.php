<?php
    ini_set('default_charset', 'UTF-8');

	include_once "config.php";    
    // Includes 
    include_once 'libs/geshi/geshi.php';

    $con = mysql_connect($db_server,$db_user,$db_password);
    
    if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }
	
    mysql_select_db($settings['sql_database'], $con);    
    mysql_set_charset('utf8', $con);


    if(isset($_GET["module"])) {
        $module = $_GET["module"];
    }
    
    if(isset($module)) {
        include_once 'modules/AModule.php';
        $module = AModule::LoadModule($module, $con);
    }

?>
