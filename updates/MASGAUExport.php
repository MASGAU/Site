<?php
include_once '../gamesaveinfo/api/APIController.php';

class MASGAUExport extends APIController {
    protected $slink;
    
    public function __construct($sitelink, $gamelink) {
        parent::__construct($gamelink);
        $this->slink = $sitelink;
        
    }

    protected function drawExporterList() {
        echo '<h1>MASGAU Auto-Update</h2>';
        
        echo "Exporter not specified, available options:";
        echo "<ul>";
        foreach($this->exporters as $row) {

          echo '<li>';
          echo '<a href="/updates/?exporter='.$row->name.'">'.$row->title.'</a>';
            echo '<ul>';
            $files = $this->slink->Select("xml_files",null,array("exporter"=>$row->name),"file");
            foreach($files as $file) {
              echo '<li><a href="/updates/?exporter='.$row->name.'&file='.$file->file.'">'.$file->file.'</a></li>';
            }
            echo '</ul>';
            echo '</li>';
        }
        echo "</ul>";
    }

    protected function export($exporter, $criteria = null) {
        if(is_null($criteria)) {
            include_once $exporter."UpdateList.php";
            $class = $exporter."UpdateList";
            $updates = new $class($this->slink,$this->link);
            $updates->drawPage();            
        } else {
            $files = $this->slink->Select("xml_files",null,
                        array("exporter"=>$exporter,
                                "file"=>$criteria),
                        "file");
            if(sizeof($files)==0) {
                throw new Exception("NO VALID FILE SPECIFIED: ".$criteria);
            }
            $file = $files[0];
            
            return parent::export($exporter,$file->criteria);
        }
    }

}

?>
