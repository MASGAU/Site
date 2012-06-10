<?php

	include_once "../../DBSettings.php";
	
    include_once '../headers.php';
    include_once '../shared/gamedata/AXmlData.php';
   

	$db = $settings['sql_database'];

    if(isset($_POST['erase_game_safety'])) {
        if($_POST['erase_game']=="ALL GAME IN DATABASE") {
            AXmlData::DeleteRow($db.'.games',null,$con,"Deleting All Games From Database");
	AXmlData::DeleteRow($db.'.game_contributors',null,$con,"Deleting All Contributors From Database");
AXmlData::ResetAutoIncrement($db.".game_versions",$con,"Resetting Game Version AI to 0");
AXmlData::ResetAutoIncrement($db.".game_locations",$con,"Resetting Game Locations AI to 0");
        } else {
            $game = $_POST['erase_game'];
            if($_POST[$game]=="ALL") {
                AXmlData::DeleteRow($db.'.games',array('name'=>$_POST['erase_game']),$con,"Deleting Game ".$_POST['erase_game']." From the Database");
            } else {
                AXmlData::DeleteRow($db.'.game_versions',array('id'=>$_POST[$game]),$con,"Deleting Game ".$_POST['erase_game']."'s version ID ".$_POST[$game]." From the Database");
            }
        }
    }
?>
<style>
details details {
    margin-left:15px;
}
.version_select {
    display:none;
}
</style>
<script type="text/javascript" src="../javascript/jquery-1.7.2.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {
    $('#game_select').change(function() {
        $('.version_select').hide();
        if($(this).val()!="ALL GAME IN DATABASE") {
            $('#'+$(this).val()).show();
        }
    });
    
    $('.version_select').load("ajax.php?module=game_data");
});
</script>

<body style="background-color:black;color:white;">
<div style="width:50%;float:left;">

XML File Import From Data Branch Of GitHub
<form enctype="multipart/form-data" method="post">
<input type="hidden" name="action" value="upload" />
<input name='overwrite' type='checkbox' />Overwrite Existing
<input name='update_time' type='checkbox' />Update File Modified Time
<?php
    $data = AXmlData::RunQuery("SELECT * FROM ".$db.".xml_files ORDER BY name ASC",$con);
    while ($row = mysql_fetch_assoc($data)) {
        echo '<br /><input type="radio" name="file"  value="'.$row['git_path'].'">' . $row['git_path'] . ' (Last Updated '.$row['last_updated'].')</input>';

    }

?>
</select>
<input type="submit" />
</form>
</div>
<div style="width:50%;float:left;">
DATA PURGE, BEEYOTCH!<br />
<form enctype="multipart/form-data" method="post">
Erase game
<input type="checkbox" name="erase_game_safety" />Safety<br />
<select name="erase_game" id="game_select">
<option selected="true">ALL GAME IN DATABASE</option>
<?php 
    $data = AXmlData::RunQuery("SELECT * FROM ".$db.".games ORDER BY name ASC",$con);
    while ($row = mysql_fetch_assoc($data)) {
        echo '<option value="'.$row['name'].'">' . $row['name'] . '</option>';
    }
?>
</select><br />
<?php
    if(mysql_num_rows($data)>0) {
        mysql_data_seek($data,0);
        while ($row = mysql_fetch_assoc($data)) {
            $datas = AXmlData::RunQuery("SELECT * FROM ".$db.".game_versions WHERE name = '".$row['name']."'",$con);
            echo '<select name="'.$row['name'].'" id="'.$row['name'].'" class="version_select">';
            echo '<option selected="true">ALL</option>';
            while ($row = mysql_fetch_assoc($datas)) {
                echo '<option value="'.$row['id'].'">' . $row['platform'].'|'.$row['region'] . '</option>';            
            }        
            echo '</select>';
        }
    }
?><br />
<input type="submit" /></form><br/>

</div>
<?php

    
    function doImport($file,$schema,$con) {

    }
    
    
    if(isset($_POST['file'])) {
        $file = $_POST['file'];
        $base_url = "https://raw.github.com/MASGAU/Data/update/";
        $schema_url = $base_url.'games.xsd';
        
        echo "<details open='true' style='clear:both;'><summary>".$file."</summary>";
        $url = $base_url.$file;
        
        echo '<div style="width:50%;float:left;">File Load:<br />';
        require_once('../shared/gamedata/Games.php');
        $games = new Games();
        $games->loadFromXml($url,$schema_url);
        echo '</div>';
        echo '<div style="width:50%;float:left;">';
        if (isset($_POST['overwrite']))
            $games->writeToDb(true,$con,$file);
        else
            $games->writeToDb(false,$con,$file);
        echo '</div>';
        if(isset($_POST['update_time'])) {
		date_default_timezone_set("UTC");
            AXmlData::UpdateRow($db.'.xml_files',
                                array('git_path'=>$file),
                                array('last_updated'=>date("Y-m-d H:i:s")),
                                $con,"Updating modified time for ".$file);
        }

echo "</details>";
        
    }

?>
</body>
