<?php
require_once 'Location.php';
class PathLocation extends Location {
    //put your code here
    
    public $ev;
    public $path;
   
    public static $table_name = "game_location_paths";

    function __construct() {
    	parent::__construct(self::$table_name);
    }
 
    public function loadfromDb($id,$con) {
	$sql = 'select * from '.$this->table.' where id = '.$id;
        $result = mysql_query($sql);
        
        if($row = mysql_fetch_assoc($result)) {
            $this->ev = $row['ev'];
            $this->path = $row['path'];
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
        
        parent::loadFromXml($node);
    }
    
    public function writeToDb($id,$con) {
        global $wgOut;

        $insert = array('ev'=>$this->ev,'path'=>$this->path);
        
        $this->writeAllToDb($id,$this->table, $insert,$con,"Writing Path Location to Database");

    }    
}

?>
