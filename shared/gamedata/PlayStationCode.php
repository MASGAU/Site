<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PlayStationCode
 *
 * @author TKMAYN9
 */
 
include_once 'AXmlData.php';
class PlayStationCode extends AXmlData {
    public $suffix;
    public $prefix;
    public $append;
    public $type;
    
	public static $table_name = "game_playstation_codes";

    function __construct() {
	parent::__construct(self::$table_name);
	}

	function loadFromDb($row, $con) {
        $this->prefix = $row['prefix'];
        $this->suffix = $row['suffix'];
        $this->append = $row['append'];
        $this->type = $row['type'];
    }
    
    function loadFromXml($node) {
        global $wgOut;
        
        foreach($node->attributes as $attribute) {
            switch($attribute->name) {
                case 'prefix':
                    $this->prefix = $attribute->value;
                    break;
                case 'suffix':
                    $this->suffix = $attribute->value;
                    break;
                case 'append':
                    $this->append = $attribute->value;
                    break;
                case 'type':
                    $this->type = $attribute->value;
                    break;
                default:
                    throw new Exception($attribute->name.' not supported');
            }
        }
    }
    
    public function writeToDb($id, $con) {
        self::InsertRow($this->table, array('game_version'=>$id,
            'prefix'=>$this->prefix,
            'append'=>$this->append,
            'type'=>$this->type,
            'suffix'=>$this->suffix),$con,'Writing PlayStation Code to database'); 
        
        
    }
    
}

?>
