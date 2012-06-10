<?php
abstract class AXmlData {
	protected static $database;
	protected $table;
	function __construct($table) {
		global $settings;
		self::$database = $settings['sql_database'];
		$this->table = self::$database.".".$table;
	}


    public static function SelectRow($db,$fields,$criteria,$options,$con,$message = null) {
        $sql = "SELECT";
        if($fields==null) {
            $sql .= " *";
        } else if(is_array($fields)) {
            foreach ($fields as $key => $value) {
                $sql .= ' '.$field;
                if(!is_numeric($key)) {
                    $sql .= ' $key';
                }
                $sql .= ',';
            }                
            $sql = trim($sql,',');
        } else {
            $sql .= ' '.$fields;
        }
        $sql .= ' FROM '.$db;
        
        if($criteria!=null) {
            $sql .= ' WHERE';
            if(is_array($criteria)) {
                foreach ($criteria as $key => $value) {
                    $sql .= ' '.$key." = '".mysql_real_escape_string($value)."' AND ";
                }                
            } else {
                $sql .= ' '.$criteria;
            }
        }
        $sql = substr($sql,0,strlen($sql)-5);

        if($message!=null) {
            echo "<details><summary>".$message."</summary><pre>";
            print_r($fields);
            print_r($criteria);
            print_r($options);
            echo $sql;
            echo "</pre></details>";
        }
        return self::RunQuery($sql,$con);
        
    }
    
    public static function UpdateRow($db,$criteria,$values,$con,$message = null) {
            $sql = "UPDATE ".$db;
            if($values!=null) {
                $sql .= " SET";
                foreach ($values as $key => $value) {
                    $sql .= " ".$key." = '".mysql_real_escape_string($value)."',";
                }
                $sql = trim($sql,', ');            
            } else {
                throw new Exception("NEED VALUES");
            }
            if($criteria!=null) {
                $sql .= " WHERE ";
                foreach ($criteria as $key => $value) {
                    $sql .= $key." = '".mysql_real_escape_string($value)."' AND ";
                }
                $sql = substr($sql,0,strlen($sql)-5);
            }
            if($message!=null) {
                echo "<details><summary>".$message."</summary><pre>";
                print_r($criteria);
                print_r($values);
                echo $sql;
                echo "</pre></details>";
            }
            self::RunQuery($sql,$con);
    }

    public static function DeleteRow($db,$id,$con,$message = null) {
            $sql = "DELETE FROM ".$db." ";
            if($id!=null) {
                $sql .= "WHERE ";
                foreach ($id as $key => $value) {
                    $sql .= $key." = '".mysql_real_escape_string($value)."' AND ";
                }
                $sql = substr($sql,0,strlen($sql)-5);
            } else {
            }
            if($message!=null) {
                echo "<details><summary>".$message."</summary><pre>";
                print_r($id);
                echo $sql;
                echo "</pre></details>";
            }
            self::RunQuery($sql,$con);
    }


    public static function ResetAutoIncrement($db,$con,$message = null) {
            $sql = "ALTER TABLE ".$db." AUTO_INCREMENT = 0";
            if($message!=null) {
                echo "<details><summary>".$message."</summary><pre>";
                echo $sql;
                echo "</pre></details>";
            }
            self::RunQuery($sql,$con);
    }
    
    // Returns the ID (if any) of the new row
    public static function InsertRow($db,$value_array,$con, $message = null) {
        if(is_array($value_array)) {            
            $sql = "INSERT INTO ".$db." (";
            $fields = '';
            $values = '';
            foreach ($value_array as $key => $value) {
                $fields .= $key.',';
                $values .= "'".mysql_real_escape_string($value)."',";
            }
            $sql .= trim($fields,',').') VALUES ('.trim($values,',').')';
            if($message!=null) {
                echo "<details><summary>".$message."</summary><pre>";
                print_r($value_array);
                echo $sql;
                echo "</pre></details>";
            }
            self::RunQuery($sql,$con);
            return mysql_insert_id($con);
        } else {
            throw new Exception("Need a fucking array!");
        }
        
    }
    public static function RunQuery($query, $con) {
        $data = mysql_query($query, $con);
        
        if($data) {
            return $data;
        } else {
            echo mysql_error()."<br /><br />";
            echo $query."<br /><br />";
        }
    }

    public abstract function loadFromDb($row, $con);
    public abstract function loadFromXml($node);
    public abstract function writeToDb($id, $con);
}
?>
