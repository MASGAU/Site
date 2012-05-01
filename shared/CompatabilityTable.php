<?php
include_once 'modules/GameData.php';
class CompatabilityTable {
    private static $con = null;
    private static $decoder;
    private static $playstation_consoles = "'PS1','PS2','PS3','PSP','PSVITA'";
    private static $consoles = "'PS1','PS2','PS3','PSP','PSVITA'";
    private static $universal_roots = array("userdocuments");
    private static $platforms, $medias, $dbr;
    public $max_games = 50;
    private $state = 'current';
    
    protected static function runQuery($query) {
        $data = mysql_query($query, self::$con);
    
        if($data) {
            return $data;
        } else {
            echo mysql_error()."<br /><br />";
            echo $query."<br /><br />";
        }
    }

    public static function init($con) {
        self::$con = $con;
        self::$decoder = self::runQuery("SELECT * FROM masgau_game_data.compatibility_equivalencies ORDER BY priority");
        self::$platforms = self::runQuery("SELECT * FROM masgau_game_data.compatibility_platforms compat"
            ." WHERE compat.display = 1"
            ." ORDER BY compat.order ASC");
        self::$medias = self::runQuery("SELECT * FROM masgau_game_data.compatibility_medias compat"
            ." WHERE compat.display = 1"
            ." ORDER BY compat.order ASC");
    }

    public function __construct($con) {
        if(self::$con==null) {
            self::init($con);
        }
    }

    public function drawTable($games_data, $make_link = true) {
        $table = $this->beginTable();
        $table .= $this->drawCompatHeader();
        $table .= $this->drawCompatRows($games_data, $make_link);
        $table .= $this->endTable();
        $table .= '<script type="text/javascript">setUpFades();</script>';
        return $table;
    }

    public function beginTable() {
        return '<table class="compatibility" cellpadding="5" cellspacing="0" border="1">'."\n";
    }

    public function endTable() {
      return '</table>'."\n";
    }
    private $i = 1;
    
    private static function DrawMediaIcon($media) {
        $return = '<div class="media_icon">';
        if($media['url']==null) {
            $return .= '<img src="images/media/' . $media['icon'] . '" alt="' . $media['title'] . '" title="' . $media['title'] . '" />';
        } else {
            $return .= '<a href="'.$media['url'].'" target="_blank"><img src="images/media/' . $media['icon'] . '" alt="' . $media['title'] . '" title="' . $media['title'] . '" /></a>';
        }
        $return .= '<div class="description">'.$media['description'].'</div>';
        $return .= '</div>';
        return $return;
    }
    
    
    public static function DrawLegend() {
        mysql_data_seek (self::$medias , 0) ;
        $medias = array();
        while($media = mysql_fetch_array(self::$medias)) {
            if($media['display']) {
                echo self::DrawMediaIcon($media);
            }
        }
    }
    
    public function drawCompatHeader() {
        $header;
        $header = '<tr class="compatibility_header">';
        $header .= '<th style="width:20%"></th>';
        
        
        mysql_data_seek ( self::$platforms , 0) ;
        while($platform = mysql_fetch_array(self::$platforms)) {
            $header .= '<th style="width:' . $platform['width'] . '">' . $platform['title'] . '</th>';
        }
        $header .= '<th style="width:20%">Comments</th>';
        $header .= '</tr>';
        return $header;
    }

    public function drawCompatRows($games_data, $make_link = true, $state = 'current') {
        $rows = "";
        mysql_data_seek ( $games_data , 0) ;
        while($row = mysql_fetch_array($games_data)) {
            if ($this->i == 0) {
                // Prints the table header every 50 or so, or when we're at a new letter
                $rows .= $this->drawCompatHeader();
            }
            $rows .= $this->drawCompatRow($row, $make_link, $state);
            $this->i++;
            if ($this->i == $this->max_games) {
                $this->i = 0;
            }
        }
        return $rows;
    }

    function addCompat($compats,$platform,$media,$region = null,$platform_title = null) {
        $data = array($media,$region,$platform_title);
        if(!in_array($data,$compats[$platform])) {
            array_push($compats[$platform],$data );
        }
        return $compats;
    }
    
    function drawCompatRow($game_res, $make_link = true, $state = 'current') {
        $new_row = '<tr class="compatibility"><th>';
        if($make_link) {
            $new_row .= GameData::CreateLink($game_res['name']) . $game_res['title'] . '</a>';
        } else {
            $new_row .= $game_res['title'];
        }
        $new_row .= '</th>';

        $compats = array();
        mysql_data_seek (self::$platforms , 0) ;
        while($platform = mysql_fetch_array(self::$platforms)) {
            $compats[$platform['name']] = array();
        }


// Here we calculate the automatic compatibility entries
        $locations = self::runQuery("SELECT * FROM masgau_game_data.game_versions ver"
            ." LEFT JOIN masgau_game_data.game_locations loc ON loc.game_version=ver.id"
            ." LEFT JOIN masgau_game_data.game_paths paths ON loc.id=paths.id"
            ." LEFT JOIN masgau_game_data.game_parents parents ON loc.id=parents.id"
            ." WHERE ver.name='" . $game_res['name'] . "'"
            ." ORDER BY ver.region");
                
        $compats = $this->processLocations($compats,$locations);

        $data = self::runQuery("SELECT * FROM masgau_game_data.compatibility_override"
                                ." WHERE name = '". $game_res['name'] . "'");
        while($override = mysql_fetch_array($data)) {
            $compats = $this->addCompat($compats,$override['platform'],$override['media']);
        }
        
        mysql_data_seek (self::$platforms , 0) ;
        while($platform = mysql_fetch_array(self::$platforms)) {
            if (count($compats[$platform['name']]) == 0) {
                $new_row .= '<td class="empty ' . $platform['name'] . '_column">';
            } else {
                $new_row .= '<td class="medias ' . $platform['name'] . '_column">';
                mysql_data_seek (self::$medias , 0) ;
                $medias = array();
                while($media = mysql_fetch_array(self::$medias)) {
                    foreach ($compats[$platform['name']] as $compat) {
                       // print_r($compat);
                        if ($media['name']==$compat[0]) {
                            if ($platform['name'] == "dos" && $compat[0] == "disc") {
                                $medias = $this->addUnique($medias,'<img src="images/media/floppy.png" alt=Disk />');
                            } else {
                               $medias = $this->addUnique($medias,self::DrawMediaIcon($media));
                            }
                            $found = true;
                        } else if($compat[0]==null&&$platform['name'] == "playstation") {
                            $medias = $this->addUnique($medias, $compat[2].' ('.$compat[1].')<br/>');
                        }
                    }
                }
                foreach($medias as $media) {
                    $new_row .= $media;
                }
            }
            $new_row .= '</td>';
        }


        $new_row .= '<td>';

        $data = self::runQuery("SELECT * FROM masgau_game_data.game_versions"
        ." WHERE name='" . $game_res['name'] . "'"
        ." AND (comment != '' OR restore_comment != '')");
        
        $row = mysql_fetch_array($data);
        if ($row == false) {
            $new_row .= 'None';
        } else {
            mysql_data_seek ($data , 0) ;
            while($row = mysql_fetch_array($data)) {
                if ($row['comment'] != null) {
                    $new_row .= $row['comment'];
                }
                if ($row['restore_comment'] != null) {
                    $new_row .= $row['restore_comment'];
                }
            }
        }

        $new_row .= '</td></tr>';
        
        return $new_row;
    }
    
    function processLocations($array,$locations) {
        while($location = mysql_fetch_array($locations)) {
            if($location['parent_game_version']!=null) {
                $parent = self::runQuery("SELECT * FROM masgau_game_data.game_versions ver"
                    ." LEFT JOIN masgau_game_data.game_locations loc ON loc.game_version=ver.id"
                    ." LEFT JOIN masgau_game_data.game_paths paths ON loc.id=paths.id"
                    ." LEFT JOIN masgau_game_data.game_parents parents ON loc.id=parents.id"
                    ." WHERE ver.id='" . $location['parent_game_version'] . "'"
                    ." ORDER BY ver.region");
                    $array = $this->processLocations($array,$parent);
                continue;
            }
            
            mysql_data_seek(self::$decoder,0);
            while($criteria = mysql_fetch_array(self::$decoder)) {
                //print_r($criteria);
                if($criteria['platform']!=$location['platform']&&$criteria['platform']!=null) {
                    continue;
                } else {
                }
                if($criteria['ev']!=$location['ev']&&$criteria['ev']!=null) {
                    continue;
                }   
                if($criteria['regex']!=null) {
                    if(preg_match(';'.$criteria['regex'].';',$location['path'])==0)
                    continue;
                }
                $array = $this->addCompat($array,$criteria['compat_platform'],$criteria['compat_media'],$location['region'],$criteria['platform']);
                if($criteria['stop'])
                    break;
            }
        }
        return $array;
    }
    
    
    
    function addUnique($array,$thing) {
        if(!in_array($thing,$array)) {
            array_push($array,$thing);
        }
        return $array;
    }

}

?>
