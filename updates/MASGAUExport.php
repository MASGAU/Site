<?php
include_once '../gamesaveinfo/api/APIController.php';

class MASGAUExport extends APIController {
    
    public function __construct($gamelink) {
        parent::__construct($gamelink);
        
    }
    private $xml_versions = array(
        "MASGAU11"=>array(),
        "GameSaveInfo20"=>array()
        );


    protected function drawExporterList() {
        echo '<h1>MASGAU Auto-Update</h2>';
        
        echo "Exporter not specified, available options:";
        echo "<ul>";
        
        
        foreach(array_keys($this->xml_versions) as $exporter) {
          echo '<li>';
          echo '<a href="/updates/'.$exporter.'/">'.$exporter.'</a>';
          $class = $exporter.'UpdateList';
          
            include_once $class.'.php';
            $exp = new $class(null,null);
            echo '<ul>';
            $files =  $exp->getFiles();
            foreach(array_keys($files) as $file) {
              echo '<li><a href="/updates/'.$exporter.'/'.$file.'">'.$file.'</a></li>';
            }
            echo '</ul>';
            echo '</li>';
        }
        echo "</ul>";
    }

    protected function export($exporter, $criteria = null, $comment = null, $date  = null) {
        if(is_null($criteria)) {
            include_once $exporter."UpdateList.php";
            $class = $exporter."UpdateList";
            $updates = new $class($this->link);
            $updates->drawPage();            
        } else {
          $class = $exporter.'UpdateList';          
            include_once $class.'.php';
            $exp = new $class(null,null);
            $files =  $exp->getFiles();
            
            if(sizeof($files)==0) {
                throw new Exception("NO VALID FILE SPECIFIED: ".$criteria);
            }
            
            $file = $files[$criteria];
            
            header("Content-Disposition: inline; filename=\"".$criteria."\"");
            
            $update = $this->link->Select("update_history",null,null,"timestamp DESC");
            $update = $update[0];
            
            return parent::export($exporter,$file["criteria"],$file["comment"],$update->timestamp);
        }
    }

}

?>
