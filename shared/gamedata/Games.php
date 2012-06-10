<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* 
 * Description of Games
 *
 * @author TKMAYN9
 */
class Games {
    private $document;
    public $games = array();


    public function loadFromXml($xml_file,$schema) {
        global $wgOut;
        //$wgOut->addWikiText($xml_file);
        echo 'Loading From XMl File: '.$xml_file;
        $this->document = new DOMDocument();
        $this->document->load($xml_file);
        
        if(!$this->document->schemaValidate($schema))
            throw new Exception("VALIDATION FAILED!!!!");
        
        $nodes = $this->document->getElementsByTagName('games')->item(0);

        require_once('Game.php');
        foreach ($nodes->childNodes as $node) {
            if ($node->localName == 'game') {
                $name = $node->attributes->getNamedItem('name')->value;
                if (array_key_exists($name,$this->games)&&$this->games[$name] != null) {
                    $game = $this->games[$name];
                } else
                    $game = new Game();
                $game->loadFromXml($node);

                $this->games[$name] = $game;
            }
        }
    }

    public static function getVersionId($name,$con) {
	global $settings;
        $ver_resul = AXmlData::RunQuery("SELECT * FROM ".$settings['sql_database'].".xml_versions WHERE string = '".$name."'",$con);
        $row = mysql_fetch_assoc($ver_resul);
        $ver_id = $row['id'];
        return $ver_id;
    }

    public function loadFromDb($file,$version,$con) {
        $ver_id = self::getVersionId($version,$con);
        global $settings;
        if($file!=null) {
            $result = AXmlData::RunQuery("select * from ".$settings['sql_database'].".xml_file_versions"
                                        ." where file = '".$file."' AND version in (0,".$ver_id.")",$con);

            if($row = mysql_fetch_assoc($result)) {
                $criteria = $row['game_criteria'];
                $version_criteria = $row['version_criteria'];
            }
        }
        
        if($criteria!=null)
            $sql = 'select * from '.$settings['sql_database'].'.games WHERE '.$criteria.' order by name asc';
        else
            $sql = 'select * from '.$settings['sql_database'].'.games order by name asc';

        $result = AXmlData::RunQuery($sql,$con);

        require_once('Game.php');
        while ($row = mysql_fetch_assoc($result)) {
            $game = new Game();
            $game->loadFromDb($row['name'],$con,$version_criteria);
            $this->games[$game->name] = $game;
        }        
    }
    
    public function writeToDb($replace,$con,$file) {
        global $wgOut;
	$types = array("Game", "System", "Mod", "Expansion");
	foreach($types as $type) {
		echo "<details open=\"true\"><summary>Writing ".$type."s</summary>";
	        foreach ($this->games as $game) {
			if($game->type == $type) {
        	    		$game->writeToDb($replace,$con,$file);
			}
        	}
		echo "</details>";
	}
    }

}

?>
