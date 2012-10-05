<?php
include_once 'AModule.php';

class Downloads extends AModule
{
    
    private $body;
    public function footer() {
    }


    private $release_features = array(
        "All-new interface!",
        "Portable AND Desktop version in one installer! Just choose which kind of install you want!",
        'Support for <a href="http://gamesave.info/">GameSave.Info</a> data!',
        "The ability to add custom games, and a new automated analyzer system!",
        "Half a  year's worth of little changes and fixes, see the Changelog for a complete list"
        );
    private $test_features = array(
        "Nothing in particular"
        );

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
        <ul>';
        foreach($this->release_features as $feature) {
            echo "<li>".$feature."</li>";
        
        }
        echo '</ul>
        </p>
        ';
        
        echo ''
        
        .'<p>No guarantees that this won\'t destroy your computer and all that.</p>'
        
        . '</td></tr><tr><td>'
                
        .'<h2><a href="https://docs.google.com/open?id=0By2Mfv6zO9SkVGktb1NCWnJqMkU" onlick="_gaq.push([\'_trackEvent\', \'downloads\', \'unstable\', \'TEST\']);return true;">';
        
        
        echo 'Download <B>UNSTABLE TEST</B><br/>version for Windows</a></h2>';
        
        echo '</td><td>';
        echo '<p>Features currently in testing:'
        .'<ul>';
        foreach($this->test_features as $feature) {
            echo "<li>".$feature."</li>";
        
        }
        echo '</ul>'
        .'</p>'

        .'</td></tr><tr><td>'
                
        .'<h2><a href="https://github.com/MASGAU/MASGAU/downloads">Download Older Versions</a></h2>'
        
        .'</td><td>'
        .'<h2><a href="https://github.com/MASGAU/">Source Code (GitHub)</a></h2>'
        
        .'</td></tr><tr><td>Mirrors: '
        
        .'<a href="http://download.cnet.com/Masgau/3000-2242_4-75761200.html?part=dl-&subj=dl&tag=button"><img src="http://i.i.com.com/cnwk.1d/i/dl/button/dl-button_a.gif" alt="Get it from CNET Download.com!" height="60" width="150" align="center" border="0"></a> '
        
        
        .'<a href="http://www.soft82.com/download/windows/masgau/"><img src="http://www.soft82.com/images/download_buttons/download_button_1.gif" width="158" height="44" border="0" alt="Download From Soft82.com"></a>'
        ;
        
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
