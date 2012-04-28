<?php
include_once '../shared/gamedata/AXmlData.php';
include_once '../shared/gamedata/Games.php';

function curPageURL() {
    $pageURL = 'http';
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

ini_set('default_charset', 'UTF-8');
define('MASGAU', 'whut');
require_once '../DBSettings.php';
$link = mysql_connect($db_server, $db_user, $db_password);
mysql_set_charset('utf8', $link);

if (isset($_GET['version'])) {
    header("Content-Type:text/xml; charset=UTF-8'");
    $version = $_GET['version'];



    if (isset($_GET['file'])) {
        //iconv_set_encoding("internal_encoding", "UTF-8");
        //iconv_set_encoding("output_encoding", "UTF-8");
        require_once '../shared/exporters/MASGAU-' . $_GET['version'] . '.php';

        require_once '../shared/gamedata/Games.php';
        $games = new Games();

        $games->loadFromDb($_GET['file'],$version,$link);

        $exporter = new Exporter($_GET['file']);
        echo $exporter->export($games);
        
    } else {
        $xml = new DOMDocument();
        $xml->encoding = 'utf-8';
        $xml->formatOutput = true;
        $root = $xml->appendChild($xml->createElement("files"));

        require_once '../shared/exporters/MASGAUBase.php';
        
        if($version=='1.1') {
            $sql = "select * from masgau_game_data.program_versions where edition = 'installable' order by major desc, minor desc, revision desc";
        } else {
            $sql = 'select * from masgau_game_data.program_versions order by major desc, minor desc, revision desc';
        }
        $result = AXmlData::RunQuery($sql,$link);
        
        while($row = mysql_fetch_assoc($result)) {
            $file = $root->appendChild($xml->createElement("program"));
            $file->appendChild($xml->createAttribute("majorVersion"))->
                    appendChild($xml->createTextNode($row['major']));
            $file->appendChild($xml->createAttribute("minorVersion"))->
                    appendChild($xml->createTextNode($row['minor']));
            $file->appendChild($xml->createAttribute("revision"))->
                    appendChild($xml->createTextNode($row['revision']));
            $file->appendChild($xml->createAttribute("url"))->
                    appendChild($xml->createTextNode($row['url']));
            $file->appendChild($xml->createAttribute("date"))->
                    appendChild($xml->createTextNode(MASGAUBase::formatDate($row['release_date'])));
            if($version!='1.1') {
                $file->appendChild($xml->createAttribute("edition"))->
                        appendChild($xml->createTextNode($row['edition']));
                $file->appendChild($xml->createAttribute("os"))->
                        appendChild($xml->createTextNode($row['os']));
            }
        }
        $ver_id = $ver_id = Games::getVersionId($version,$link);

        $sql = "select * from masgau_game_data.xml_files xml"
                .", masgau_game_data.xml_file_versions file"
                ." where version in (0,".$ver_id.")"
                ." AND xml.name = file.file"
                ." order by name asc";
        $result = AXmlData::RunQuery($sql,$link);
        while ($row = mysql_fetch_assoc($result)) {
            $file = $root->appendChild($xml->createElement("file"));
            $file->appendChild($xml->createAttribute("name"))->
                    appendChild($xml->createTextNode($row['name']));
            $file->appendChild($xml->createAttribute("last_updated"))->
                    appendChild($xml->createTextNode(
                                    MASGAUBase::formatDate($row['last_updated'])));
            $file->appendChild($xml->createAttribute("url"))->
                    appendChild($xml->createTextNode(curPageURL() . '&file=' . $row['name']));
        }

        $output = $xml->saveXML();
        echo $output;
    }
} else {
    echo "VERSION NOT PROVIDED, RUNNING IN TEST MODE<br />";

    $result = AXmlData::RunQuery('select * from masgau_game_data.xml_files order by name asc',$link);
    $result_ver = AXmlData::RunQuery('select * from masgau_game_data.xml_versions order by string asc',$link);

    echo "<ul>";
    while ($row_ver = mysql_fetch_assoc($result_ver)) {
        $result_file = AXmlData::RunQuery('select * from masgau_game_data.xml_file_versions WHERE version in (0,'.$row_ver['id'].') order by file asc',$link);

        if($row_ver['string']=="No Version")
            continue;
        echo "<li><a href='?version=" . $row_ver['string'] . "'>" . $row_ver['string'] . "</a></li>";
        echo "<ul>";
        while ($row = mysql_fetch_assoc($result_file)) {
            echo "<li><a href='?version=" . $row_ver['string'] . "&file=" . $row['file'] . "'>" . $row['file'] . "</li>";
        }
        echo "</ul>";
        mysql_data_seek($result, 0);
    }
    echo "</ul>";
}
?>