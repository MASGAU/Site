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
          "deprecated.xml"=>array(
              "criteria"=>"deprecated",
              "comment"=>"This file contains game data that was originally mislabeled, or for some other reason incorrect to the point that backup support had to be removed. The main purpose of these is to allow deprecated games to be able to still restore."
              ),
          "dos.xml"=>array(
              "criteria"=>"DOS",
              "comment"=>"This file contains games that are for the DOS platform. Most of these make use of DOSBOX for their installs."
              ),
          "flash.xml"=>array(
              "criteria"=>"Flash",
              "comment"=>"This file contains games that are based on Flash"
              ),
          "games.xml"=>array(
              "criteria"=>"!os/!media/!system/!SteamCloud/!ScummVM/!Flash",
              "comment"=>"This file contains games that have saves that are compatible with more than one platform"
              ),
          "mods.xml"=>array(
              "criteria"=>"mod",
              "comment"=>"This file contains mods for other games, which have all been moved to their respective platform xmls"
              ),
          "ps1.xml"=>array(
              "criteria"=>"PS1",
              "comment"=>"This file contains PlayStation games"
              ),
          "ps2.xml"=>array(
              "criteria"=>"PS2",
              "comment"=>"This file contains PlayStation 2 games"
              ),
          "ps3.xml"=>array(
              "criteria"=>"PS3",
              "comment"=>"This file contains PlayStation 3 games"
              ),
          "psp.xml"=>array(
              "criteria"=>"PSP",
              "comment"=>"This file contains PSP (PlayStation Portable) games"
              ),
          "scummvm.xml"=>array(
              "criteria"=>"ScummVM",
              "comment"=>"This file contains games that are run through the ScummVM project"
              ),
          "steam.xml"=>array(
              "criteria"=>"SteamCloud",
              "comment"=>"This file contains games whose saves are only compatible with Steam releases of the game"
              ),
          "system.xml"=>array(
              "criteria"=>"system",
              "comment"=>"Contains profiles for backing up system-related files"
              ),
          "windows.xml"=>array(
              "criteria"=>"game/expansion/Windows",
              "comment"=>"This file contains game for Microsoft Windows"
              )
          );
     }
     
     
    protected function createFileElement($name, $info) {
            $file = $this->xml->createElement("file");
            $file->appendChild($this->xml->createAttribute("name"))->
                    appendChild($this->xml->createTextNode("data/".$name));
            $file->appendChild($this->xml->createAttribute("last_updated"))->
                    appendChild($this->xml->createTextNode(
                                    AExporter::formatDate($this->last_updated)));
            $file->appendChild($this->xml->createAttribute("url"))->
                    appendChild($this->xml->createTextNode($this->curPageURL() . '/MASGAU11/' . $name));
            $this->root->appendChild($file);        
    }

    protected function createProgramElement() {
        $file = $this->xml->createElement("program");
        $file->appendChild($this->xml->createAttribute("majorVersion"))->
                appendChild($this->xml->createTextNode(self::$latest_program_version["major"]));
        $file->appendChild($this->xml->createAttribute("minorVersion"))->
                appendChild($this->xml->createTextNode(self::$latest_program_version["minor"]));
        $file->appendChild($this->xml->createAttribute("revision"))->
                appendChild($this->xml->createTextNode(self::$latest_program_version["revision"]));
        $file->appendChild($this->xml->createAttribute("url"))->
                appendChild($this->xml->createTextNode($this->pageURL()."/".self::$latest_program_version["filename"]));
        $file->appendChild($this->xml->createAttribute("date"))->
                appendChild($this->xml->createTextNode(self::$latest_program_version["release_date"]));
        return $file;
    }


}
?>