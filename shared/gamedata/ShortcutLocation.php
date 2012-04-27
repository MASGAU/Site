<?php

require_once 'Location.php';
class ShortcutLocation extends Location {
    //put your code here
    
    public $ev;
    public $path;
    
    public function loadFromDb($id) {
        $sql = 'select * from masgau_game_data.game_shortcuts where id = '.$id.'';
        $result = mysql_query($sql);
        
        if($row = mysql_fetch_assoc($result)) {
            $this->ev = $row['ev'];
            if($this->ev==null) {
                $this->ev = "startmenu";
            }
            $this->path = $row['path'];
        }        
        parent::loadFromDb($id);
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
                case 'environment_variable':
                    $this->ev = $attribute->value;
                    break;
                case 'path':
                    $this->path = $attribute->value;
                    break;
                default:
                    throw new Exception($attribute->name.' not supported');
            }
        }
        
        $wgOut->addHTML('<tr><td>');
        $wgOut->addHTML($this->ev.'|'.$this->path.'|');
        parent::loadFromXml($node);
        $wgOut->addHTML('</td></tr>');
    }

    public function writeToDb($id) {
        global $wgOut;
        $wgOut->addWikiText('*** Writing shortcut ' . $this->ev. '\\'.$this->path.' to database');

        $insert = array('ev'=>$this->ev,'path'=>$this->path);
        
        $this->writeAllToDb($id,'masgau_game_data.game_shortcuts', $insert);

    }        
    
}

?>
