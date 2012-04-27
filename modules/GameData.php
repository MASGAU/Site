<?php
include_once 'AModule.php';
include_once 'Contributors.php';
include_once 'shared/CompatabilityTable.php';

class GameData extends AModule
{
    public function draw() {
                
        echo '<div id="ajax"></div>';
    }
    
    public function title() {
        return " - Game Data";   
    }
    
    public function headers() {
        echo '<link media="Screen" href="css/gamedata.css" type="text/css" rel="stylesheet" />';
        echo '<link media="Screen" href="css/support.css" type="text/css" rel="stylesheet" />';
        echo '<script type="text/javascript" src="javascript/gamedata.js"></script>';
    }
        public function footer() {
    }

    public function ajax() {
        if(isset($_GET["name"])) {
            $name = $_GET["name"];
            echo '<div class="back_link">'.self::CreateLink().'Return To Game List</a></div>';
        
//            echo '<h2>MASGAU Compatibility</h2>';
            require_once 'shared/gamedata//Game.php';
            $game_data = new Game();
            $game_data->loadFromDb($name, null);
            
            echo '<h1>'.$game_data->title.'</h1>';
        
            $data = $this->runQuery("SELECT * FROM masgau_game_data.games"
                                    ." WHERE name = '".$name."'"
                                    ." ORDER BY name ASC");
                                    
            if(mysql_num_rows($data)>0) {
                $compat_table = new CompatabilityTable($this->connection);
                echo $compat_table->drawTable($data, "Current Compatability");
            }
            
            
            
            foreach ($game_data->versions as $version) {
                // Begin title code
                if ($version->region != null) {
                    if ($version->platform != null) {
                        $header = $version->platform . ' - ' . $version->region;
                    } else {
                        $header = $version->region;
                    }
                } else {
                    if ($version->platform != null) {
                        $header = $version->platform;
                    } else {
                        $header = 'Platform Neutral';
                    }
                }
                $header .=' Version';
    
                if ($version->deprecated)
                    $header .= ' (Deprecated)';
    
                if ($version->title != null)
                    $header .= ' (' . $version->title . ')';
    
                // End title code
                
                if ($version->deprecated) {
                    echo '<h4>NOTE: This game version is no longer supported for backup. Archives previously made for this version can still be restored.</h4>';
                }
                if ($version->override_virtualstore) {
                    echo '<h4>NOTE: This game version does not recognize VirtualStore folders.</h4>';
                }
                if ($version->require_detection) {
                    echo '<h4>NOTE: Restoring this game version requires there to already be saves on the system.</h4>';
                }

                
                
                // Side info box
                echo '<div style="float:left;border:solid 1px;padding:5px;width:200px;" class="wikitable">';
        
                echo 'Contributors:<ul>';
                foreach ($version->contributors as $contributor) {
                    echo '<li>'.Contributors::CreateLink($contributor).$contributor.'</a></li>';
                }
                echo '</ul></div>';
    
                    echo '<h2>' . $header . '</h2>';

                //PS codes
                if (sizeof($version->ps_codes) > 0) {
                    echo '<h3>PlayStation Codes</h3><ul>';
                    foreach ($version->ps_codes as $path) {
                        echo '<li>' . $path->prefix . '-' . $path->suffix;
                    }
                    echo '</ul>';
                }
                
                // Paths
                if (sizeof($version->locations) > 0) {
                    echo '<h3>Locations</h3>';
                    $paths = null;
                    $reg_keys = null;
                    $shortcuts = null;
                    $parent_games = null;
                    foreach ($version->locations as $location) {
                        $line = '';
                        if (get_class($location) != "PathLocation") {
                            if ($location->append != null)
                                $line = '<td>' . $location->append . '</td>';
                            else
                                $line = '<td></td>';
    
                            if ($location->detract != null)
                                $line .= '<td>' . $location->detract . '</td>';
                            else
                                $line .= '<td></td>';
                        }
    
                        if ($location->platform_version != null)
                            $line = '<td>Only works with ' . $location->platform_version . '</td>';
    
                        if ($location->platform_version != null)
                            $line = '<td>Only works with ' . $location->platform_version . '</td>';
    
                        if ($location->deprecated)
                            $line .= '<td style="background-color:red">Deprecated</td>';
    
                        switch (get_class($location)) {
                            case "PathLocation":
                                if ($paths == null) {
                                    $paths = '<table class="wikitable"><caption>Paths</caption><tr><th>Environment Variable</th><th>Path</th></tr>';
                                }
                                $paths .= '<tr><td>' . $location->ev . '</td><td>' . $location->path . '</td>' . $line . '</tr>';
                                break;
                            case "RegistryLocation":
                                if ($reg_keys == null) {
                                    $reg_keys = '<table class="wikitable"><caption>Registry Keys</caption><tr><th>Root</th><th>Key</th><th>Value</th><th>Append</th><th>Detract</th></tr>';
                                }
                                $reg_keys .='<tr><td>' . $location->root . '</td><td>' . $location->key . '</td>';
                                if ($location->value == null)
                                    $reg_keys .='<td>(Default)</td>';
                                else
                                    $reg_keys .='<td>' . $location->value . '</td>';
                                $reg_keys .= $line . '</tr>';
                                break;
                            case "ShortcutLocation":
                                if ($shortcuts == null) {
                                    $shortcuts = '<table class="wikitable"><caption>Shortcuts</caption><tr><th>Environment Variable</th><th>Path</th><th>Append</th><th>Detract</th></tr>';
                                }
                                $shortcuts .= '<tr><td>' . $location->ev . '</td><td>' . $location->path . '</td>' . $line . '</tr>';
                                break;
                            case "GameLocation":
                                if ($parent_games == null) {
                                    $parent_games = '<table class="wikitable"><caption>Parent Game Versions</caption><tr>
                                        <th>Game</th><th>Platform</th><th>Region</th><th>Append</th><th>Detract</th></tr>';
                                }
                                $parent_games .= '<tr><td>'.GameData::CreateLink($location->name). $location->name . '</a></td><td>' . $location->platform . '</td><td>' . $location->region . '</td>' . $line . '</tr>';
                                break;
                            default:
                                continue;
                        }
                    }
    
                    if ($paths != null)
                        echo $paths . '</table>';
                    if ($reg_keys != null)
                        echo $reg_keys . '</table>';
                    if ($shortcuts != null)
                        echo $shortcuts . '</table>';
                    if ($parent_games != null)
                        echo $parent_games . '</table>';
                }

                $saves = null;
                $ignores = null;
                $identifiers = null;
                foreach ($version->files as $file) {
    
                    $line = '<tr>';
                    if ($file->mode == 'IDENTIFIER') {
                        $line .= '<td>' . $file->path . '</td>';
                        $line .= '<td>' . $file->name . '</td>';
                    } else {
                        if ($file->name == null)
                            $filename = "* (Includes subfolders)";
                        else
                            $filename = $file->name;
    
                        $line .= '<td>' . $file->path . '</td>';
                        $line .= '<td>' . $filename . '</td>';
                        $line .= '<td>' . $file->type . '</td>';
                        $line .= '<td>' . $file->modified_after . '</td>';
                    }
                    $line .= '</tr>';
    
                    switch ($file->mode) {
                        case 'SAVE':
                            if ($saves == null)
                                $saves = '<table><caption>To Save</caption><tr><th>Path</th><th>Filename</th><th>Type</th><th>Modified After</th></tr>';
                            $saves .= $line;
                            break;
                        case 'IGNORE':
                            if ($ignores == null)
                                $ignores = '<table><caption>To Ignore</caption><tr><th>Path</th><th>Filename</th><th>Type</th><th>Modified After</th></tr>';
                            $ignores .= $line;
                            break;
                        case 'IDENTIFIER':
                            if ($identifiers == null)
                                $identifiers = '<table><caption>Used To Identify Game</caption><tr><th>Path</th><th>Filename</th></tr>';
                            $identifiers .= $line;
                            break;
                    }
                }
    
                if ($saves != null || $ignores != null || $identifiers != null) {
                    echo '<h3>Files</h3>';
                    if ($identifiers != null)
                        echo $identifiers . '</table>';
                    if ($saves != null)
                        echo $saves . '</table>';
                    if ($ignores != null)
                        echo $ignores . '</table>';
                }
    
                if ($version->comment != null) {
                    echo '<h3>Comment</h3>';
                    echo $version->comment;
                }
    
                if ($version->restore_comment != null) {
                    echo '<h3>Restore Comment</h3>';
                    echo $version->restore_comment;
                }
                
                $data = $this->runQuery("SELECT * FROM masgau_game_data.xml_versions ver"
                                        .", masgau_game_data.exporters ex"
                                        ." WHERE ver.exporter = ex.name"
                                        ." ORDER BY major desc, minor desc");

                if($row = mysql_fetch_array($data)) {
                    require_once 'shared/exporters/'.$row['file'];
        
                    echo '<h3>MASGAU '.$row['string'].' XML</h3>';
                    $xml = new DOMDocument();
                    $xml->encoding = 'utf-8';
                    $xml->formatOutput = true;
                    $exporter = new Exporter();
                    $exporter->xml = $xml;
                    $node = $exporter->exportGameVersion($game_data, $version);
                    $xml->appendChild($node);
                    
                    $geshi = new GeSHi($xml->saveXML($node),'xml');
                    echo '<div class="code">'.$geshi->parse_code().'</div>';

                }
                
                echo '<div class="clear_both"></div>';
            }
            
        } else {
            echo '<h3>These are all the games and other things that MASGAU has information for</h3>';
            $data = $this->runQuery("SELECT * FROM masgau_game_data.games"
                                ." ORDER BY name ASC");
            
            $games = array();
            while($row = mysql_fetch_array($data)) {
                $games[$row['name']] = self::CreateLink($row['name']).$row['title'].'</a>';
            }
            echo self::drawInColumns($games,3,true);

        }
    }

    public static function CreateLink($game = null) {
        if($game==null)
        return '<a href="?module=game_data">';
        else
        return '<a href="?module=game_data#'.urlencode($game).'">';
    }

}
?>
