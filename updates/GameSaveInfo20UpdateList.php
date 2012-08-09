<?php
require_once 'AUpdateList.php';
class GameSaveInfo20UpdateList extends AUpdateList {
    
    public function __construct($sitelink,$gamelink) {
        parent::__construct($sitelink,$gamelink);
    }
    protected function programCriteria() {
        return null;   
    }

    protected function exporterName() {
        return "GameSaveInfo20";
    }

    protected function createFileElement($row) {
            $file = $this->xml->createElement("file");
            $file->appendChild($this->xml->createAttribute("name"))->
                    appendChild($this->xml->createTextNode($row->file));
            $file->appendChild($this->xml->createAttribute("date"))->
                    appendChild($this->xml->createTextNode(
                                    AExporter::formatDate($this->last_updated)));
            $file->appendChild($this->xml->createAttribute("url"))->
                    appendChild($this->xml->createTextNode($this->curPageURL() . '/GameSaveInfo20/' . $row->file));
            $this->root->appendChild($file);        
    }


    protected function createProgramElement($row) {
        $file = parent::createProgramElement($row);
        
        $file->appendChild($this->xml->createAttribute("os"))->
                appendChild($this->xml->createTextNode($row->os));
                                        
        if($row->stable==0) {
            $file->appendChild($this->xml->createAttribute("stable"))->
				appendChild($this->xml->createTextNode("false"));
		} else {
			$file->appendChild($this->xml->createAttribute("stable"))->
                                appendChild($this->xml->createTextNode("true"));
		}

        return $file;
    }
}
?>