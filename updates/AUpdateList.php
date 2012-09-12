<?php
@include_once '../gamesaveinfo/api/exporters/AExporter.php';
abstract class AUpdateList {
    
    public static $latest_program_version = array(
        "name"=>"MASGAU 1.0.0",
        "major"=>1,
        "minor"=>0,
        "revision"=>0,
        "url"=>"https://github.com/downloads/MASGAU/MASGAU/MASGAU-1.0.0-Release-Setup.exe",
        "os"=>"windows",
        "release_date"=>"2012-09-04T08:00:00"
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
    
    public function curPageURL() {
        $pageURL = 'http';
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"];// . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"];// . $_SERVER["REQUEST_URI"];
        }
        return $pageURL.'/updates';
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