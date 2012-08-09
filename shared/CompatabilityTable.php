<?php
include_once 'modules/GameData.php';
class CompatabilityTable {
    private static $db = null;
    private static $decoder;
    private static $playstation_consoles = "'PS1','PS2','PS3','PSP','PSVITA'";
    private static $consoles = "'PS1','PS2','PS3','PSP','PSVITA'";
    private static $universal_roots = array("userdocuments");
    private static $platforms, $medias, $dbr;
    public $max_games = 50;
    private $state = 'current';
    
    public static function init($db) {
        self::$db = $db;
        self::$decoder = $db->Select("compatibility_equivalencies",null,null,"priority");
        self::$platforms = $db->Select("compatibility_platforms",null,array("display"=>1),array("order"));
        self::$medias = $db->Select("compatibility_medias compat",null,array("display"=>1),array("order"));
    }

    public function __construct($db) {
        if(self::$db==null) {
            self::init($db);
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
        $return = '<div class="media_icon has_tooltip">';
        if($media->url==null) {
            $return .= '<img src="/images/media/' . $media->icon . '" alt="' . $media->title . '" title="' . $media->title . '" />';
        } else {
            $return .= '<a href="'.$media->url.'" target="_blank"><img src="/images/media/' . $media->icon . '" alt="' . $media->title . '" title="' . $media->title . '" /></a>';
        }
        $return .= '<div class="tooltip">'.$media->description.'</div>';
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
        
        
        foreach(self::$platforms as $platform) {
            $header .= '<th style="width:' . $platform->width . '">' . $platform->title . '</th>';
        }
        $header .= '<th style="width:20%">Comments</th>';
        $header .= '</tr>';
        return $header;
    }

    public function drawCompatRows($games_data, $make_link = true, $state = 'current') {
        $rows = "";
        foreach($games_data as $row) {
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
    
    protected static function combineArrays() {
        $arrays = func_get_args();
        $return = array();
        foreach($arrays as $array) {
            foreach($array as $item) {
                array_push($return,$item);
            }
        }
        return $return;
    }


    function gatherLocationsFor($name, $version = null) {
        $props = "os, platform, media, region";
        $version_criteria = "ver.name='" . $name . "'";
        if(!is_null($version)) {
            $version_criteria = "ver.id = '".$version."'";            
        }
        
        $paths = self::$db->RunStatement("SELECT 'path' as location_type, ".$props.", ev, path as regex FROM "
            ." game_location_paths paths"
            ." LEFT JOIN  game_locations loc ON loc.id=paths.id"
            ." LEFT JOIN game_versions ver ON loc.game_version=ver.id"
            ." WHERE ".$version_criteria);
            
        $registries = self::$db->RunStatement("SELECT 'registry' as location_type, ".$props.", `key` as regex FROM"
            ." game_location_registry_keys reg"
            ." LEFT JOIN game_locations loc ON loc.id=reg.id"
            ." LEFT JOIN game_versions ver ON loc.game_version=ver.id"
            ." WHERE ".$version_criteria);
            
        $parents = self::$db->RunStatement("SELECT 'parent' as location_type, ".$props.", name, parent_game_version FROM"
            ." game_location_parents game"
            ." LEFT JOIN game_locations loc ON loc.id=game.id"
            ." LEFT JOIN game_versions ver ON loc.game_version=ver.id"
            ." WHERE ".$version_criteria);

        $shortcuts = self::$db->RunStatement("SELECT 'shortcut' as location_type, ".$props.", ev, path FROM"
            ." game_location_shortcuts game"
            ." LEFT JOIN game_locations loc ON loc.id=game.id"
            ." LEFT JOIN game_versions ver ON loc.game_version=ver.id"
            ." WHERE ".$version_criteria);
            
        $ps_codes = self::$db->RunStatement("SELECT 'ps_code' as location_type, ".$props." FROM"
            ." game_playstation_codes code"
            ." LEFT JOIN game_versions ver ON code.game_version=ver.id"
            ." WHERE ".$version_criteria);
                        
        return self::combineArrays($paths,$registries,$parents,$shortcuts,$ps_codes);

    }
    
    function drawCompatRow($game_res, $make_link = true) {
        $new_row = '<tr class="compatibility"><th>';
        $new_row .= '<a href="http://gamesave.info/#'.$game_res->name.'">'. $game_res->title . '</a>';
        $new_row .= '</th>';

        $compats = array();
        foreach(self::$platforms as $platform) {
            $compats[$platform->name] = array();
        }

        // Here we calculate the automatic compatibility entries


        $locations = $this->gatherLocationsFor($game_res->name);
//                            self::superVarDump($locations);

        $compats = $this->processLocations($compats,$locations);

        $data = self::$db->Select("compatibility_override",null,
                                array("name"=>$game_res->name),null);
        $found = false;
        foreach($data as $override) {
            $found = true;
            $compats = $this->addCompat($compats,$override->platform,$override->media);
        }
        
        foreach(self::$platforms as $platform) {
            if (count($compats[$platform->name]) == 0) {
                $new_row .= '<td class="empty ' . $platform->name . '_column">';
            } else {
                $found = true;
                $new_row .= '<td class="medias ' . $platform->name . '_column">';

                $medias = array();
                foreach(self::$medias as $media) {
                    foreach ($compats[$platform->name] as $compat) {
                        
                        
                        if ($media->name==$compat[0]) {
                           $medias = $this->addUnique($medias,self::DrawMediaIcon($media));
                            $found = true;
                        } else if($compat[0]==null&&$platform->name == "playstation") {
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
        
        if(!$found) {
//            return "";
            self::superVarDump($game_res);
            self::superVarDump($locations);
            throw new Exception('No criteria apply to this game:<a href="http://gamesave.info/#'.$game_res->name.'">'.$game_res->name.'</a>');   
        }


        $new_row .= '<td>';

        $data = self::$db->RunStatement("SELECT * FROM game_versions"
        ." WHERE name='" . $game_res->name . "'"
        ." AND (comment != '' OR restore_comment != '')");
        
        $comments = array();
        if($game_res->comment!=null) {
            array_push($comments,$game_res->comment);
        } 
        
        if (sizeof($data)>0) {
            foreach($data as $row) {
                if ($row->comment != null) {
                    $comments = $this->addUnique($comments,$row->comment);
                }
                if ($row->restore_comment != null) {
                    $comments = $this->addUnique($comments,$row->restore_comment);
                }
            }
        }
        
        if (sizeof($comments)==0) {
            $new_row .= 'None';
        } else {
            foreach($comments as $comment) {
                $new_row .= $comment."<br/>";
            }
        }
        $new_row .= '</td></tr>';
        
        return $new_row;
    }
    
    function processLocations($array,$locations) {
        foreach($locations as $location) {
            
            if($location->location_type=="parent"&&$location->parent_game_version!=null) {
                $parent = $this->gatherLocationsFor($location->name,$location->parent_game_version);
                $array = $this->processLocations($array,$parent);
                continue;
            }
            
            foreach(self::$decoder as $criteria) {
                                
                $props = array("location_type","os","platform","media");
                switch($criteria->location_type) {
                    case "path":
                        array_push($props,"ev");  
                        break;
                    case "registry":
                    case "ps_code":
                    case null:
                        break;
                    default:
                        throw new Exception("Don't know how to process criteria for ".$criteria->location_type);
                }
                
                foreach($props as $prop) {
                    if($criteria->$prop!=null && $criteria->$prop != $location->$prop) {
                        continue 2;   
                    }
                }
                
                if($criteria->regex!=null) {
                    if(preg_match(';'.$criteria->regex.';',$location->regex)==0)
                    continue;
                }
                
                $array = $this->addCompat($array,$criteria->compat_platform,$criteria->compat_media,$location->region,$criteria->os);
                if($criteria->stop)
                    break;

                
            }
        }
        return $array;
    }
    
    protected static function SuperVarDump($item) {
        echo '<pre>';
        
        var_dump($item);
        echo '</pre>';
    }

    
    function addUnique($array,$thing) {
        if(!in_array($thing,$array)) {
            array_push($array,$thing);
        }
        return $array;
    }

}

?>
