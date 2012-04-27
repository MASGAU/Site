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
class PlayStationCode {
    public $suffix;
    public $prefix;
    public $append;
    public $type;
    
    function loadFromDb($row) {
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
        $wgOut->addHTML('<tr><td>'.$this->prefix.'|'.$this->suffix.'</td></tr>');
    }
    
    public function writeToDb($id) {
        global $wgOut;
        $dbw = wfGetDB(DB_MASTER);
        $wgOut->addWikiText('*** Writing playstation code ' . $this->prefix. '-'.$this->suffix.' to database');
        $dbw->insert('masgau_game_data.playstation_codes', array('game_version'=>$id,
            'prefix'=>$this->prefix,
            'append'=>$this->append,
            'type'=>$this->type,
            'suffix'=>$this->suffix), 
                $fname = 'Database::insert', $options = array());
        
    }
    
}

?>
