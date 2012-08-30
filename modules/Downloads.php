<?php
include_once 'AModule.php';

class Downloads extends AModule
{
    
    private $body;
    public function footer() {
    }

    public function draw() {
        
        echo '<br/><center>MASGAU is awesome, but it\'s not perfect, so please add all problems found to the <a href="https://github.com/MASGAU/MASGAU/issues/new">Issues List</a></center>';

        echo '<table><tr><td>';
        
        include_once 'updates/AUpdateList.php';
        $version = AUpdateList::$latest_program_version;
        $version_string = "v.".$version['major'].".".$version['minor'].".".$version['revision'];
        
        
        echo '<h2><a href="'.$version['url'].'" onlick="_gaq.push([\'_trackEvent\', \'downloads\', \'stable\', \''.$version_string.'\']);return true;">';
    //    echo '<p>You can download the latest version from the <a href="https://github.com/MASGAU/">GitHub page</a>, or from here:</p>';
        echo 'Download '.$version_string.' Installer for Windows<br />(Desktop AND Portable!)</a></h2>'        
        .'<p>MASGAU REQUIRES <a href="http://www.microsoft.com/NET/">Microsoft\'s .NET framework</a> to be installed. Setup will  download and install it automatically if it isn\'t.</p>';
        
        echo '</td><td>';
        echo '
        <p>Release highlights:
        <ul>
        <li>All-new interface!</li>
        <li>Portable AND Desktop version in one installer! Just choose which kind of install you want!</li>
        <li>Support for <a href="http://gamesave.info/">GameSave.Info</a> data!</li>
        <li>The ability to add custom games, and a new automated analyzer system!</li>
        <li>Half a  year\'s worth of little changes and fixes, see the Changelog for a complete list</li>
        </ul>
        </p>
        ';
        
        echo ''
        
        .'<p>No guarantees that this won\'t destroy your computer and all that.</p>'
        
        . '</td></tr><tr><td>'
                
        .'<h2><a href="https://docs.google.com/open?id=0By2Mfv6zO9SkZXB2R01vVDNXSE0" onlick="_gaq.push([\'_trackEvent\', \'downloads\', \'unstable\', \'TEST\']);return true;">';
        
        
        echo 'Download <B>UNSTABLE TEST</B><br/>version for Windows</a></h2>';
        
        echo '</td><td>';
        echo '<p>Features currently in testing:'
        .'<ul>'
        .'<li>A new custom list view to overcome the shortcomings of the stock list view</li>'
        .'</ul>'
        .'</p>'

        .'</td></tr><tr><td>'
                
        .'<h2><a href="https://github.com/MASGAU/MASGAU/downloads">Download Older Versions</a></h2>'
        
        .'</td><td>'
        .'<h2><a href="https://github.com/MASGAU/">Source Code (GitHub)</a></h2>';
        
        echo '</td></tr></table>';

    }
        
    public function title() {
        return " - Downloads";
    }
    
    public function headers() {
        echo '<link media="Screen" href="/css/downloads.css" type="text/css" rel="stylesheet" />';
        echo '<script type="text/javascript" src="/js/pages.js"></script>';
    }

    
    public function ajax() { 
        
    }
    
    public static function CreateLink() {
        return '<a href="/downloads/">';
    }

}
?>
