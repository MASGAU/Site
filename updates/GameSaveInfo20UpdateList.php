<?php
require_once 'AGameSaveInfo2UpdateList.php';
class GameSaveInfo20UpdateList extends AGameSaveInfo2UpdateList {
        
    public function __construct($gamelink) {
        parent::__construct($gamelink);
    }

    protected function exporterName() {
        return "GameSaveInfo20";
    }
}
?>