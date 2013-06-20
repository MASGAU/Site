<?php
require_once 'AUpdateList.php';
abstract class AGameSaveInfo2UpdateList extends AUpdateList {
        
    public function __construct($gamelink) {
        parent::__construct($gamelink);
    }
    protected function programCriteria() {
        return null;   
    }

    

     public function getFiles() {
      $files = array(
          "system.xml"=>array(
              "criteria"=>"system",
              "comment"=>"Contains profiles for backing up system-related files"
              ),
          "deprecated.xml"=>array(
              "criteria"=>"deprecated",
              "comment"=>"This file contains game data that was originally mislabeled, or for some other reason incorrect to the point that backup support had to be removed. The main purpose of these is to allow deprecated games to be able to still restore."
              ),
          "numeric.xml"=>array(
              "criteria"=>"!system/0*/1*/2*/3*/4*/5*/6*/7*/8*/9*",
              "comment"=>"This file contains games, mods and expansions that start with a number"
              )
          );   
          
          foreach (range('a', 'z') as $letter) {
              $files[$letter.".xml"] = array(
              "criteria"=>"!system/".$letter."*/".strtoupper($letter)."*",
              "comment"=>"This file contains games, mods and expansions that start with the letter ".strtoupper($letter)
              );
                            
            }
          
          
          return $files;
     }


    protected function createFileElement($name, $info) {
        
            $file = $this->xml->createElement("data");
                    
            $file->appendChild($this->xml->createAttribute("name"))->
                    appendChild($this->xml->createTextNode($name));
            $file->appendChild($this->xml->createAttribute("date"))->
                    appendChild($this->xml->createTextNode(
                                    AExporter::formatDate($this->last_updated)));
            $file->appendChild($this->xml->createAttribute("url"))->
                    appendChild($this->xml->createTextNode($this->curPageURL() . '/' . $this->exporterName() . '/' . $name));
            $this->root->appendChild($file);        
    }


    protected function createProgramElement() {
        $file = $this->xml->createElement("program");
        $file->appendChild($this->xml->createAttribute("name"))->
                appendChild($this->xml->createTextNode(self::$latest_program_version["name"]));
        $file->appendChild($this->xml->createAttribute("date"))->
                appendChild($this->xml->createTextNode(self::$latest_program_version["release_date"]));
        $file->appendChild($this->xml->createAttribute("url"))->
                appendChild($this->xml->createTextNode($this->pageURL()."/downloads/"));
                
                
        $file->appendChild($this->xml->createAttribute("majorVersion"))->
                appendChild($this->xml->createTextNode(self::$latest_program_version["major"]));
        $file->appendChild($this->xml->createAttribute("minorVersion"))->
                appendChild($this->xml->createTextNode(self::$latest_program_version["minor"]));
        $file->appendChild($this->xml->createAttribute("revision"))->
                appendChild($this->xml->createTextNode(self::$latest_program_version["revision"]));

        
        $file->appendChild($this->xml->createAttribute("os"))->
                appendChild($this->xml->createTextNode(self::$latest_program_version["os"]));
                                        
        return $file;
    }
}
?>