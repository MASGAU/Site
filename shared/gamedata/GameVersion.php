<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 
/**
 * Description of GameVersion
 *
 * @author TKMAYN9
 */
 include_once 'AXmlData.php';
class GameVersion extends AXmlData {
    
    // Tag properties
    public $title = null;
    public $name;
    public $platform = null;
    public $region = null;
    public $deprecated = false;
    
    public $override_virtualstore = false;
    public $require_detection = false;

    public $comment = null;
    public $restore_comment = null;

    public $locations = array();
    public $files = array();
    public $contributors = array();
    public $ps_codes = array();

    public function loadFromDb($id,$con) {
        $sql = 'select * from masgau_game_data.game_versions where id = '.$id.'';
        $result = mysql_query($sql);
        
        if($row = mysql_fetch_assoc($result)) {
            $this->name = $row['name'];
            if($row['platform']!='UNIVERSAL')
                $this->platform = $row['platform'];
            
            if($row['region']!='UNIVERSAL')
                $this->region = $row['region'];
            
            $this->deprecated = $row['deprecated'];
            
            $this->title = $row['version_title'];
            
            $this->override_virtualstore = $row['override_virtualstore'];
            $this->require_detection = $row['require_detection'];
            
            $this->comment = $row['comment'];
            $this->restore_comment = $row['restore_comment'];
            
            // Load paths
            $sql = 'select * from masgau_game_data.game_locations loc, 
                masgau_game_data.game_paths path where game_version = '.$id.' and loc.id = path.id';
            $result = mysql_query($sql);
            while($row = mysql_fetch_assoc($result)) {
                require_once 'PathLocation.php';
                $loc = new PathLocation();
                $loc->loadfromDb($row['id'],$con);
                
                $c = sizeof($this->locations);
                $this->locations[$c] = $loc;
            }
            
            // Load registry keys
            $sql = 'select * from masgau_game_data.game_locations loc, 
                masgau_game_data.game_registry_keys `keys` where game_version = '.$id.' and loc.id = `keys`.id';
            if($result = mysql_query($sql)) {
                while($row = mysql_fetch_assoc($result)) {
                    require_once 'RegistryLocation.php';
                    $loc = new RegistryLocation();
                    $loc->loadfromDb($row['id'],$con);

                    $c = sizeof($this->locations);
                    $this->locations[$c] = $loc;
                }
            }

            // Load shortcuts
            $sql = 'select * from masgau_game_data.game_locations loc, 
                masgau_game_data.game_shortcuts short where game_version = '.$id.' and loc.id = short.id';
            if($result = mysql_query($sql)) {
                while($row = mysql_fetch_assoc($result)) {
                    require_once 'ShortcutLocation.php';
                    $loc = new ShortcutLocation();
                    $loc->loadfromDb($row['id'],$con);

                    $c = sizeof($this->locations);
                    $this->locations[$c] = $loc;
                }
            }
            
            // Load parents
            $sql = 'select * from masgau_game_data.game_locations loc, 
                masgau_game_data.game_parents par where game_version = '.$id.' and loc.id = par.id';
            if($result = mysql_query($sql)) {
                while($row = mysql_fetch_assoc($result)) {
                    require_once 'GameLocation.php';
                    $loc = new GameLocation();
                    $loc->loadfromDb($row['id'],$con);

                    $c = sizeof($this->locations);
                    $this->locations[$c] = $loc;
                }
            }
            
            
            // Load playstation codes
            $sql = 'select * from masgau_game_data.playstation_codes where game_version = '.$id.'';
            $result = mysql_query($sql);
            while($row = mysql_fetch_assoc($result)) {
                require_once 'PlayStationCode.php';
                $code = new PlayStationCode();
                $code->loadFromDb($row,$con);
                $c = sizeof($this->ps_codes);
                $this->ps_codes[$c] = $code;
            }
            
            // Load files
            $sql = 'select * from masgau_game_data.files where game_version = '.$id.'';
            $result = mysql_query($sql);
            while($row = mysql_fetch_assoc($result)) {
                require_once 'SaveFile.php';
                $code = new SaveFile();
                $code->loadFromDb($row,$con);
                $c = sizeof($this->files);
                $this->files[$c] = $code;
            }
            
             
            // Load contributors
            $sql = 'select * from masgau_game_data.contributions where game_version = '.$id.'';
            $result = mysql_query($sql);
            while($row = mysql_fetch_assoc($result)) {
                $c = sizeof($this->contributors);
                $this->contributors[$c] = $row['contributor'];
            }
        }        
    }
    
    function loadFromXml($node) {
        global $wgOut;
        foreach ($node->attributes as $attribute) {
            switch ($attribute->name) {
                case 'name':
                    $this->name = $attribute->value;
                    break;
                case 'platform':
                    $this->platform = $attribute->value;
                    break;
                case 'country':
                case 'region':
                    $this->region = $attribute->value;
                    break;
                case 'deprecated':
                    if($attribute->value=="true")
                        $this->deprecated = true;
                    break;
                default:
                    throw new Exception($attribute->name . ' not supported');
            }
        }


        foreach ($node->childNodes as $element) {
            $l = sizeof($this->locations);
            $f = sizeof($this->files);
            $c = sizeof($this->contributors);
            $p = sizeof($this->ps_codes);
            switch ($element->localName) {
                case '':
                    break;
                case 'title':
                    $this->title = $element->textContent;
                    break;
                case 'location_registry':
                    require_once 'RegistryLocation.php';
                    $loc = new RegistryLocation();
                    $loc->loadFromXml($element);
                    $this->locations[$l] = $loc;
                    break;
                case 'location_path':
                    require_once 'PathLocation.php';
                    $loc = new PathLocation();
                    $loc->loadFromXml($element);
                    $this->locations[$l] = $loc;
                    break;
                case 'location_shortcut':
                    require_once 'ShortcutLocation.php';
                    $loc = new ShortcutLocation();
                    $loc->loadFromXml($element);
                    $this->locations[$l] = $loc;
                    break;
                case 'location_game':
                    require_once 'GameLocation.php';
                    $loc = new GameLocation();
                    $loc->loadFromXml($element);
                    $this->locations[$l] = $loc;
                    break;
                case 'save':
                case 'ignore':
                case 'identifier':
                    require_once 'SaveFile.php';
                    $file = new SaveFile();
                    $file->loadFromXml($element);
                    $this->files[$f] = $file;
                    break;
                case 'ps_code':
                    require_once 'PlayStationCode.php';
                    $code = new PlayStationCode();
                    $code->loadFromXml($element);
                    $this->ps_codes[$p] = $code;
                    break;
                case 'contributor':
                    $this->contributors[$c] = $element->textContent;
                    break;
                case 'comment':
                    $this->comment = $element->textContent;
                    break;
                case 'restore_comment':
                    $this->restore_comment = $element->textContent;
                    break;
                case 'virtualstore':
                    switch ($element->attributes->getNamedItem('override')->value) {
                        case "yes":
                        case "true":
                            $this->override_virtualstore = true;
                            break;
                                
                    }
                case 'require_detection':
                    $this->require_detection = true;
                    break;
                default:
                    throw new Exception($element->localName . ' not supported');
            }
        }

        echo '<details><summary>'.$this->getVersionString().'</summary>';
        echo '<pre>'.print_r($this,true).'</pre>';
        echo '</details>';

    }


    public function writeToDb($replace,$con) {
        $criteria = ' WHERE name = \'' . $this->name . '\'';

        $insert = array('name' => $this->name);

        if($this->comment!=null)
            $insert['comment'] = $this->comment;
        if($this->restore_comment!=null)
            $insert['restore_comment'] = $this->restore_comment;
        
        if($this->deprecated)
            $insert['deprecated'] = $this->deprecated;
        if($this->override_virtualstore)
            $insert['override_virtualstore'] = $this->override_virtualstore;
        if($this->require_detection)
            $insert['require_detection'] = $this->require_detection;

        if ($this->platform == null) {
            $criteria .= ' AND platform = \'UNIVERSAL\'';
        } else {
            $insert['platform'] = $this->platform;
            $criteria .= ' AND platform = \'' . $this->platform . '\'';
        }

        if ($this->region == null) {
            $criteria .= ' AND region = \'UNIVERSAL\'';
        } else {
            $insert['region'] = $this->region;
            $criteria .= ' AND region = \'' . $this->region . '\'';
        }


        $data = self::RunQuery("SELECT * FROM masgau_game_data.game_versions"
                                .$criteria
                                ,$con);

        echo '<details open="true">';
        if (mysql_num_rows($data)==1) {
            if (!$replace) {
                echo '<summary style="color:yellow;">'.$this->getVersionString().' (';
                echo 'SKIPPING';
                echo ')</summary></details>';
                return;
            }
                echo '<summary style="color:orange;">'.$this->getVersionString().' (';
                echo 'REPLACING';
            
            $row = mysql_fetch_assoc($data);

            $id = $row['id'];
            $insert['id'] = $id;
            echo ')</summary>';
            self::DeleteRow("masgau_game_data.game_versions",array('id'=>$id),$con,"Deleting Current Version ($id)");
        } else {
                echo '<summary style="color:red;">'.$this->getVersionString().' (';
                echo 'ADDING';
                echo ')</summary>';
        }
        
        
        $data = self::RunQuery("SELECT * FROM masgau_game_data.games"
                                ." WHERE name = '" . $this->name . "'",$con);
                                
        $row = mysql_fetch_assoc($data);
        
        if ($this->title != null && $row['title'] != $this->title) {
            $insert['version_title'] = $this->title;
            echo "Has unique version title: ".$this->title;
        }

        $id = self::InsertRow('masgau_game_data.game_versions', $insert, $con, "Adding version");
        
        foreach($this->contributors as $contributor) {
            $data = self::RunQuery("SELECT * FROM masgau_game_data.contributors"
                            ." WHERE name = '".$contributor."'",$con);
                            
            if(mysql_num_rows($data)==0) {
                self::InsertRow('masgau_game_data.contributors', array('name'=>$contributor), $con,'Contributor is new, adding');
            }
            self::InsertRow('masgau_game_data.contributions', 
                    array('game_version'=>$id,
                        'contributor'=>$contributor), $con,"Writing contribution by " . $contributor . " to database");
        }
        
        foreach($this->ps_codes as $ps_code) {
            $ps_code->writeToDb($id,$con);
        }
        
        foreach($this->files as $file) {
            $file->writeToDb($id,$con);
        }
        foreach($this->locations as $location) {
            $location->writeToDb($id,$con);
        }
        
        echo '</details>';
        
    }

    public function getVersionString() {
        $return_me = $this->name;

        if ($this->platform != null)
            $return_me .= '>' . $this->platform;

        if ($this->region != null)
            $return_me .= '>' . $this->region;

        return $return_me;
    }

}

?>
