<?php
require_once '../gamesaveinfo/api/exporters/AExporter.php';
abstract class AUpdateList {
    
    protected $xml;
    protected $root;
    private $gamelink;
    private $sitelink;
    
    protected abstract function exporterName();
    
    protected $last_updated;
    
    public function __construct($sitelink,$gamelink) {
        $this->gamelink = $gamelink;
        $this->sitelink = $sitelink;
        $this->xml = new DOMDocument();
        $this->xml->encoding = 'utf-8';
        $this->xml->formatOutput = true;
        $this->root = $this->xml->appendChild($this->xml->createElement("files"));
        
        $this->addProgramElements($this->root);
                
        $this->last_updated = $this->gamelink->Select("update_history",null,null,"timestamp desc");
        $this->last_updated = $this->last_updated[0];
        $this->last_updated = $this->last_updated->timestamp;        
        
        $result = $this->sitelink->Select("xml_files",null,array("exporter"=>$this->exporterName()),"file");
                
        foreach ($result as $row) {
            $this->createFileElement($row);
        }
    }
    
    
    protected abstract function programCriteria();
    
    protected abstract function createFileElement($row);
    protected function createProgramElement($row) {
        $file = $this->xml->createElement("program");
        $file->appendChild($this->xml->createAttribute("majorVersion"))->
                appendChild($this->xml->createTextNode($row->major));
        $file->appendChild($this->xml->createAttribute("minorVersion"))->
                appendChild($this->xml->createTextNode($row->minor));
        $file->appendChild($this->xml->createAttribute("revision"))->
                appendChild($this->xml->createTextNode($row->revision));
        $file->appendChild($this->xml->createAttribute("url"))->
                appendChild($this->xml->createTextNode($row->url));
        $file->appendChild($this->xml->createAttribute("date"))->
                appendChild($this->xml->createTextNode(AExporter::formatDate($row->release_date)));
        return $file;
    }
    
    
    protected function addProgramElements($root) {
        $result = $this->sitelink->Select("program_versions",null,$this->programCriteria(),array("major"=>"desc","minor"=>"desc","revision"=>"desc"));
        
        foreach($result as $row) {
            $root->appendChild($this->createProgramElement($row));
        }
        
    }
    
    public function curPageURL() {
        $pageURL = 'http';
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }

    public function drawPage() {
        header("Content-Type:text/xml; charset=UTF-8'");
        $output = $this->xml->saveXML();
        echo $output;
    }
}

?>