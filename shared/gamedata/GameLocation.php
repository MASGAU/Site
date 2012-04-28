<?php

require_once 'Location.php';
class GameLocation extends Location {
    //put your code here
    
    public $name;
    public $platform;
    public $region;
    
    public function loadFromDb($id,$con) {
        parent::loadFromDb($id,$con);
        $sql = 'select * from masgau_game_data.game_parents where id = '.$id.'';
        $result = mysql_query($sql);

        if($row = mysql_fetch_assoc($result)) {
            require_once 'GameVersion.php';
            $parent = new GameVersion();
            $parent->loadFromDb($row['parent_game_version'],$con);
            $this->name = $parent->name;
            $this->platform = $parent->platform;
            $this->region = $parent->region;
            
        }        
        
        
        
    }
    
    function loadFromXml($node) {
        global $wgOut;
        foreach($node->attributes as $attribute) {
            switch($attribute->name) {
                case 'append':
                case 'detract':
                case 'platform_version':
                case 'read_only':
                case 'deprecated':
                    break;
                case 'name':
                    $this->name = $attribute->value;
                    break;
                case 'platform':
                    $this->platform = $attribute->value;
                    break;
                default:
                    throw new Exception($attribute->name.' not supported');
            }
        }
        
        parent::loadFromXml($node);
    }
    
    public function writeToDb($id,$con) {
        $criteria = array();
        $criteria['name'] = $this->name;

        if ($this->platform == null) {
            $criteria['platform'] = 'UNIVERSAL';
        } else {
            $criteria['platform'] = $this->platform;
        }

        if ($this->region == null) {
            $criteria['region'] = 'UNIVERSAL';
        } else {
            $criteria['region'] = $this->region;
        }

        $data = self::SelectRow('masgau_game_data.game_versions', 'id', $criteria, null, $con,"Retreiving parent id");
        $row = mysql_fetch_array($data);
        $parent_id = $row['id'];
        
        if($parent_id==null) {
            throw new Exception("Parent '. $this->name. '>'.$this->platform.'>'.$this->region.' not found in database. Make sure a parent is inserted BEFORE its children!");
        }
        
        $insert = array('parent_game_version'=>$parent_id);
        
        $this->writeAllToDb($id,'masgau_game_data.game_parents', $insert, $con, "Writing Parent Game Location to Database");

    }    
}

?>
