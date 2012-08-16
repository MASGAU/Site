<?php
include_once 'AModule.php';

class Downloads extends AModule
{
    
    private $body;
    public function footer() {
    }

    public function draw() {
        
        echo 'MASGAU is technically still Beta, so please add all problems found to the <a href="https://github.com/MASGAU/MASGAU/issues/new">Issues List</a>';

        
        
        echo '<h2>Download Installer (Desktop AND Portable!)</h2>';
        echo '<p>You can download the latest version from the <a href="https://github.com/MASGAU/">GitHub page</a>, or from here:</p>';
        echo '<h3><a href="https://github.com/downloads/MASGAU/MASGAU/MASGAU-0.99.0-Beta-Setup.exe" onlick="_gaq.push([\'_trackEvent\', \'downloads\', \'stable\', \'0.99.0\']);return true;">DOWNLOAD MASGAU V.0.99 BETA FOR WINDOWS</a></h3>';
        
        
        echo '
        <p>Release highlights:
        <ul>
        <li>All-new interface!</li>
        <li>Portable AND Desktop version in one installer! Just choose which kind of install you want!</li>
        <li>Support for <a href="http://gamesave.info/">GameSave.Info</a> data!</li>
        <li>The ability to add cusotm games, and a new automated analyzer system!</li>
        <li>Half a  year\'s worth of little changes and fixes, see the Changelog for a complete list</li>
        </ul>
        </p>
        ';
        
        echo ''
        .'<p>MASGAU REQUIRES <a href="http://www.microsoft.com/NET/">Microsoft\'s .NET framework</a> to be installed. Setup will  download and install it automatically if it isn\'t.</p>'
        
        .'<p>No guarantees that this won\'t destroy your computer and all that.</p>'
        
                
        .'<h2>Download Older Versions</h2>'
        .'<p>All the previous releases of MASGAU are available here:</p>'
        
        .'<h3><a href="https://github.com/MASGAU/MASGAU/downloads">https://github.com/MASGAU/MASGAU/downloads</a></h3>'
        
        .'<h2>Download Test Build</h2>'
        
        .'<p>This link always points to the latest test build:</p>';
        
        echo '<h3><a href="https://docs.google.com/open?id=0By2Mfv6zO9SkZXB2R01vVDNXSE0" onlick="_gaq.push([\'_trackEvent\', \'downloads\', \'unstable\', \'TEST\']);return true;">DOWNLOAD MASGAU <B>TEST</B> VERSION FOR WINDOWS</a></h3>';
        echo '<p>Features currently in testing:'
        .'<ul>'
        .'<li>Nothing! Haha!</li>'
        .'</ul>'
        .'</p>'
        
        .'<h2>Download Source Code (GitHub)</h2>'
        .'<p>The source code for MASGAU is available through GitHub</p>'
        
        .'<h3><a href="https://github.com/MASGAU/">https://github.com/MASGAU/</a></h3>';
    }
        
    public function title() {
        return " - Downloads";
    }
    
    public function headers() {
        echo '<link media="Screen" href="/css/pages.css" type="text/css" rel="stylesheet" />';
        echo '<script type="text/javascript" src="/js/pages.js"></script>';
    }

    
    public function ajax() { 
        
    }
    
    public static function CreateLink() {
        return '<a href="/downloads/">';
    }

}
?>
