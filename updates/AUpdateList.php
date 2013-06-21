<?php
@include_once '../gamesaveinfo/api/exporters/AExporter.php';
abstract class AUpdateList {
    
    public static $latest_program_version = array(
        "name"=>"MASGAU 1.0.6",
        "major"=>1,
        "minor"=>0,
        "revision"=>6,
        "filename"=>"MASGAU-1.0.6-Release-Setup.exe",
        "os"=>"windows",
        "release_date"=>"2013-06-20T12:00:00",
        "features"=>array(
            "Portable AND Desktop version in one installer! Just choose which kind of install you want!",
            'Support for <a href="http://gamesave.info/">GameSave.Info</a> data!',
            "The ability to add custom games, and a new automated analyzer system!",
            "Support for Steam's new install-wherever-you-want feature!",
            "More issue fixes than you can shake a stick at! Check the Changelog for details!"
            )
        );
    public static $old_program_versions = array(
        "MASGAU-1.0.4-Release-Setup.exe",
        "MASGAU-1.0.2-Release-Setup.exe",
        "MASGAU-1.0.0-Release-Setup.exe",
        "MASGAU-0.9.1-Setup.exe",
        "MASGAU-0.9.1-Portable.zip"
        );
    
    protected $xml;
    protected $root;
    private $gamelink;
    protected abstract function exporterName();
    
    protected $last_updated;
    
    public function __construct($gamelink) {
        if(is_null($gamelink))
            return;
        
        $this->gamelink = $gamelink;
        
        $this->xml = new DOMDocument();
        $this->xml->encoding = 'utf-8';
        $this->xml->formatOutput = true;
        $this->root = $this->xml->appendChild($this->xml->createElement("files"));
        
        $this->addProgramElements($this->root);
                
        $this->last_updated = $this->gamelink->Select("update_history",null,null,"timestamp desc");
        $this->last_updated = $this->last_updated[0];
        $this->last_updated = $this->last_updated->timestamp;        
        
        global $test_mode;
        if($test_mode)
            $this->last_updated = '2020-01-01';
        
                
                $files = $this->getFiles();
        foreach (array_keys($files) as $name) {
            $this->createFileElement($name,$files[$name] );
        }
    }
    
    public abstract function getFiles();

    
    protected abstract function programCriteria();
    
    protected abstract function createFileElement($row, $info);
    protected abstract function createProgramElement();
    
    
    protected function addProgramElements($root) {
            $root->appendChild($this->createProgramElement());
    }
    
    public function pageURL() {
        $pageURL = 'http';
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"];// . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"];// . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }
    
    public function curPageURL() {
        return $this->pageURL().'/updates';
    }

    public function drawPage() {
        header("Content-Type:text/xml; charset=UTF-8'");
        
        $folder =  dirname(__FILE__);
        $schema = $folder . '/schemas/' . get_class($this).'.xsd';
        
        if (!file_exists($schema)) {
            throw new Exception("Can't find schema file ".$schema);
        }
        
        if (!$this->xml->schemaValidate($schema)) {
            echo $text;
            $this->error_occured = true;
            throw new Exception("XML DID NOT PASS VALIDATION: " . $schema);
        }


        $output = $this->xml->saveXML();
        echo $output;
    }
}

?>
