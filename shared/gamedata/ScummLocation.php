<?php
require_once 'Location.php';
class ScummLocation extends Location {
    //put your code here
    
    public $name;
    
    public function loadfromDb($id,$con) {
        $sql = 'select * from masgau_game_data.game_scummvm where id = '.$id.'';
        $result = mysql_query($sql);
        
        if($row = mysql_fetch_assoc($result)) {
            $this->name = $row['name'];
        }        
        parent::loadFromDb($id,$con);
    }
    
    public function loadFromXml($node) {
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
                default:
                    throw new Exception($attribute->name.' not supported');
            }
        }
        
        parent::loadFromXml($node);
    }
    
    public function writeToDb($id,$con) {
        global $wgOut;

        $insert = array('name'=>$this->name);
        
        $this->writeAllToDb($id,'masgau_game_data.game_scummvm', $insert,$con,"Writing ScummVM Location to Database");

    }    
}

?>
