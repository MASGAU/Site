<?php
require_once 'AUpdateList.php';
class MASGAU11UpdateList extends AUpdateList {
    
    public function __construct($sitelink,$gamelink) {
        parent::__construct($sitelink,$gamelink);
    }
    protected function programCriteria() {
        return array("edition"=>"installable",
                    "stable"=>true);   
    }

    protected function exporterName() {
        return "MASGAU11";
    }
    protected function createFileElement($row) {
            $file = $this->xml->createElement("file");
            $file->appendChild($this->xml->createAttribute("name"))->
                    appendChild($this->xml->createTextNode($row->file));
            $file->appendChild($this->xml->createAttribute("last_updated"))->
                    appendChild($this->xml->createTextNode(
                                    AExporter::formatDate($this->last_updated)));
            $file->appendChild($this->xml->createAttribute("url"))->
                    appendChild($this->xml->createTextNode($this->curPageURL() . '&file=' . $row->file));
            $this->root->appendChild($file);        
    }



}
?>