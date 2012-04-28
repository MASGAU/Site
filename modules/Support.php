<?php
include_once 'AModule.php';
include_once 'shared/CompatabilityTable.php';
include_once 'shared/GamesList.php';

class Support extends AModule
{
    private $criterias;
    private $filter;
    private $table="current";
    private $criteria_index = 'A';
    private $true_index = 'A';

    private $database = 'masgau_game_data';
    private $criteria = "games.type != 'system'";
    private $game_tables;
    public function footer() {
    }

    private function init() {
        $this->criterias = $this->getGameLetters(true);
        
        if(isset($_GET["filter"])) {
            $filter = $_GET["filter"];
        } else {
            $filter = "A";
        }
        
        if (array_key_exists($filter, $this->criterias)) {
            $this->filter = $filter;
        } else if ($filter == "NUMBERS") {
            $this->filter = '#';
        }
        
        $this->game_tables = $this->database . '.games games';
        if ($this->table == "upcoming") {
            $this->game_tables .= ", ". $this->database . '.compatibility compat';
            $this->criteria .= " AND compat.state = 'upcoming'";
            $this->criteria .= " AND games.name = compat.name";
        } else {
            $this->game_tables .= ", ". $this->database . '.game_versions versions';
            $this->criteria .= " AND versions.name = games.name";
        }

    }


    public static function CreateLink($name) {
        return '<a href="?module=support#'.urlencode($name).'">';
    }

    
    public function title() {
        $this->init();



        return " - Game Compatibility";
    }
    
    public function headers() {
        echo '<link media="Screen" href="css/support.css" type="text/css" rel="stylesheet" />';
        echo '<script type="text/javascript" src="javascript/support.js"></script>';
    }

    
    public function draw() {
        

        $query = "SELECT type, count(DISTINCT games.name) as count FROM ".$this->game_tables
            ." WHERE ".$this->criteria
            ." GROUP BY games.type";
        $data = $this->runQuery($query);
    
        $counts = array();
        $i = 0;
        $count = 0;
        $game_counts = array();
        while($row = mysql_fetch_array($data)) {
            $counts[$row['type']] = $row['count'];
            $game_counts[$i] = $row['count'];
            if ($row['count'] == 1)
                $game_counts[$i] .= ' ' . $row['type'];
            else
                $game_counts[$i] .= ' ' . $row['type'] . 's';
            $count += $row['count'];
            $i++;
        }
        $count_string = '';
        if ($count > 0) {
            for ($i = 0; $i < sizeof($game_counts); $i++) {
                $count_string .= $game_counts[$i];
                if ($i < sizeof($game_counts) - 2) {
                    $count_string .= ', ';
                } else if ($i < sizeof($game_counts) - 1) {
                    $count_string .= ' and ';
                }
            }
            if (sizeof($game_counts) > 1) {
                $count_string .= ' (' . $count . ' total)';
            }
        } else {
            $count_string = "currently no games (for now)";
        }
    
        if ($this->table == "current") {
            $query = "SELECT max(last_updated) as date FROM masgau_game_data.xml_files";
            $data = $this->runQuery($query);
            $row = mysql_fetch_array($data);
            echo '<p>This list reflects the game compatibility of the current data, which was released on ' . $row['date'] . '.</p>';
            echo '<p>According to this list ' . $count_string;
            if ($count == 1) {
                echo ' is';
            } else {
                echo ' are';
            }
            echo ' currently supported across various platforms.</p>';
        } else {
            echo '<p>This list reflects the changes in game compatibility of the upcoming data release.</p>';
            echo '<p>According to this list ' . $count_string . ' will be added/updated with the next data update.</p>';
        }

        echo '<p>Unless implicitly stated only the US English install locations are supported. If you know the paths for other languages, please let me know.';
        echo '<p>If your experience differs from what is presented here, please e-mail me at <a href="mailto:sanmadjack@masgau.org">sanmadjack@masgau.org</a>. We will figure it out.';

        echo '<div id="ajax"></div>';
}


public function ajax() {
        $this->init();
        if ($this->table == "current") {
            echo '<div style="width:100%;text-align:center;" class="filter_letters">';
            $links = '';
            foreach (array_keys($this->criterias) as $key) {
                if ($key == $this->filter) {
                    $links .=  $key;
                } else {
                    if ($key == '#')
                        $links .= '<a href="?module=support#NUMBERS">' . $key . '</a>';
                    else
                        $links .= '<a href="?module=support#'.$key.'">' . $key . '</a>';
                }
                $links .= ' ';
            }
            echo $links;

            echo '</div>';
            
            if(!isset($this->filter))
                return;

            $this->criteria .= " AND ". $this->criterias[$this->filter];
            
            
        }


        $query = "SELECT DISTINCT games.name, games.title FROM ".$this->game_tables
            ." WHERE ".$this->criteria
            ." ORDER BY games.name ASC";
            
            $data = $this->runQuery($query);
    
        if($data) {
            $table = new CompatabilityTable($this->connection);
            $output = $table->drawTable($data);
            echo $output;
        }
        
        if ($this->table == "current") {
            echo '<div style="width:100%;text-align:center;" class="filter_letters">';
            $links = '';
            foreach (array_keys($this->criterias) as $key) {
                if ($key == $this->filter) {
                    $links .=  $key;
                } else {
                    if ($key == '#')
                        $links .= '<a href="?module=support#NUMBERS">' . $key . '</a>';
                    else
                        $links .= '<a href="?module=support#'.$key.'">' . $key . '</a>';
                }
                $links .= ' ';
            }
            echo $links;

            echo '</div>';
            
            $this->criteria .= " AND ". $this->criterias[$this->filter];
            
            
        }        
        
    }

}
?>
