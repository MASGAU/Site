<?php
require_once 'AUpdateList.php';
class GameSaveInfo20UpdateList extends AUpdateList {
        
    public function __construct($gamelink) {
        parent::__construct($gamelink);
    }
    protected function programCriteria() {
        return null;   
    }

    protected function exporterName() {
        return "GameSaveInfo20";
    }

     public function getFiles() {
      return array(
          "system.xml"=>array(
              "criteria"=>"System",
              "comment"=>"Comment"
              ),
          "deprecated.xml"=>"",
          "games.xml"=>""
          );   
     }


    protected function createFileElement($name, $info) {
        
            $file = $this->xml->createElement("file");
            $file->appendChild($this->xml->createAttribute("name"))->
                    appendChild($this->xml->createTextNode($name));
            $file->appendChild($this->xml->createAttribute("date"))->
                    appendChild($this->xml->createTextNode(
                                    AExporter::formatDate($this->last_updated)));
            $file->appendChild($this->xml->createAttribute("url"))->
                    appendChild($this->xml->createTextNode($this->curPageURL() . '/GameSaveInfo20/' . $name));
            $this->root->appendChild($file);        
    }


    protected function createProgramElement() {
        $file = parent::createProgramElement();
        
        $file->appendChild($this->xml->createAttribute("os"))->
                appendChild($this->xml->createTextNode(self::$latest_program_version["os"]));
                                        
        return $file;
    }
}
?>