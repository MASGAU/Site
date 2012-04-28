<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Location
 *
 * @author TKMAYN9
 */
 include_once 'AXmlData.php';
abstract class Location extends AXmlData {
    public $append = null;
    public $detract = null;
    public $platform_version = null;
    public $deprecated = false;
    
    
    public function loadFromDb($id,$con) {
        $sql = 'select * from masgau_game_data.game_locations where id = '.$id.'';
        $result = mysql_query($sql);
        
        if($row = mysql_fetch_assoc($result)) {
            $this->append = $row['append'];
            $this->detract = $row['detract'];
            $this->platform_version = $row['platform_version'];
            $this->deprecated = $row['deprecated'];
        }        
    }
    
    public function loadFromXml($node) {
        global $wgOut;
        foreach($node->attributes as $attribute) {
            switch($attribute->name) {
                case 'append':
                    $this->append = $attribute->value;
                    break;
                case 'detract':
                    $this->detract = $attribute->value;
                    break;
                case 'platform_version':
                    $this->platform_version = $attribute->value;
                    break;
                case 'read_only':
                case 'deprecated':
                    if($attribute->value=="true")
                        $this->deprecated = true;
                    break;
                default:
                    //throw new Exception($attribute->name.' not supported');
            }
        }
    }

    protected function writeAllToDb($id,$table,$sub_insert, $con , $message = null) {
        $insert = array('game_version'=>$id);
                
        if($this->append!=null) 
                $insert['append']= $this->append;
        if($this->detract!=null)
                $insert['detract']= $this->detract;
        if($this->platform_version!=null)
                $insert['platform_version']= $this->platform_version;
        if($this->deprecated!=null)
                $insert['deprecated']= $this->deprecated;
        
        $sub_insert['id'] = self::InsertRow('masgau_game_data.game_locations', $insert, $con,"Writing common location information");
        
        self::InsertRow($table, $sub_insert, $con,$message);
        
        }            
}

?>
