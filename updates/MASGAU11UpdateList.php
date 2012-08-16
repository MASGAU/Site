<?php
require_once 'AUpdateList.php';
class MASGAU11UpdateList extends AUpdateList {
    
    public function __construct($gamelink) {
        parent::__construct($gamelink);
    }
    protected function programCriteria() {
        return array("edition"=>"installable",
                    "stable"=>true);   
    }

    protected function exporterName() {
        return "MASGAU11";
    }
    
     public function getFiles() {
         return array(
          "system.xml"=>"",
          "deprecated.xml"=>"",
          "games.xml"=>""
          );
     }
     
     
    protected function createFileElement($name, $info) {
            $file = $this->xml->createElement("file");
            $file->appendChild($this->xml->createAttribute("name"))->
                    appendChild($this->xml->createTextNode($name));
            $file->appendChild($this->xml->createAttribute("last_updated"))->
                    appendChild($this->xml->createTextNode(
                                    AExporter::formatDate($this->last_updated)));
            $file->appendChild($this->xml->createAttribute("url"))->
                    appendChild($this->xml->createTextNode($this->curPageURL() . '/MASGAU11/' . $row->file));
            $this->root->appendChild($file);        
    }



}
?>