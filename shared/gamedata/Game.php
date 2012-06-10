<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Game
 *
 * @author TKMAYN9
 */
 include_once 'AXmlData.php';
class Game extends AXmlData {

    public $name = null;
    public $title;
    public $type;
    public $versions = array();

    function __construct() {
    	parent::__construct("games");
    }
    public function loadFromDb($name,$con,$criteria = null) {
	$sql = 'select * from '.$this->table.' where name = \''.$name.'\'';
        $result = mysql_query($sql);
        
        if($row = mysql_fetch_assoc($result)) {
            $this->name = $row['name'];
            $this->title = $row['title'];
	$this->type = $row['type'];
                require_once 'GameVersion.php';
            $sql = 'select * from '.self::$database.'.'.GameVersion::$table_name.' where name = \'' . $name . '\'';
            if($criteria!=null) {
                $sql .= ' AND '.$criteria;
            }
            $result = mysql_query($sql);

            while ($sub_row = mysql_fetch_assoc($result)) {
                $version = new GameVersion();
                $version->loadFromDb($sub_row['id'],$con);
                
                $i = sizeof($this->versions);
                $this->versions[$i] = $version;
            }
        }        
        
        
    }   
    
    public function loadFromXml($node) {
        require_once 'GameVersion.php';
        global $wgOut;
        foreach ($node->attributes as $attribute) {
            switch ($attribute->name) {
                case 'name':
                    if($this->name==null)
                        $this->name = $attribute->value;
                    else if ($this->name != $attribute->value)
                        throw new Exception('GAME MISMATCH ' . $this->name . ' ' . $attribute->value);
                    break;
                case 'type':
			$this->type = $attribute->value;		
			break;
		//default:
                //throw new Exception($attribute->name.' not supported');
            }
        }
        $i = sizeof($this->versions);
        $version = new GameVersion();
        $this->versions[$i] = $version;
        $version->loadFromXml($node);
    }

    public function getTitle() {
        global $wgOut;
        
        $titles = array();
        foreach($this->versions as $version) {
            if(!array_key_exists($version->title,$titles)||$titles[$version->title]==null)
                $titles[$version->title] = 0;
            else
                $titles[$version->title]++;
        }
        $candidate = null;
        foreach(array_keys($titles) as $title) {
            if($titles[$title]>$candidate||$candidate==null) {
                $candidate = $title;
            }
        }
            
        return $candidate;
    }
    
    public function writeToDb($replace,$con,$file = null) {        
        $data = self::RunQuery("SELECT * FROM ".$this->table.""
                                ." WHERE name = '".$this->name."'",$con);
    
                        $path = pathinfo($file);
        echo '<details open="true">';
        if(mysql_num_rows($data)==0) {
            echo '<summary style="color:red">'.$this->getTitle().' ('.$this->name.') ';
            $fields = array('name'=>$this->name,
                        'title'=>$this->getTitle());
            $fields['type'] = $this->type;    
		echo '('.$this->type.') ';        

            echo '(ADDING)</summary>';
                        
                        
            self::InsertRow($this->table, $fields
                    ,$con,"Writing game to database"); 
        } else {
            echo '<summary style="color:green">'.$this->getTitle().' ('.$this->name.') (';
            echo 'EXISTS)</summary>';
        }
        
        foreach($this->versions as $version) {
            $version->writeToDb($replace,$con);
        }
        echo '</details>';
        
    }
}

?>
