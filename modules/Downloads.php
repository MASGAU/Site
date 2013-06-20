<?php
include_once 'AModule.php';

class Downloads extends AModule
{
    
    private $body;
    public function footer() {
    }



    private $test_features = array(
        "Nothing in particular"
        );

    public function draw() {
        
        echo '<br/><center>MASGAU is awesome, but it\'s not perfect, so please add all problems found to the <a href="https://github.com/MASGAU/MASGAU/issues/new">Issues List</a></center>';

        echo '<table><tr><td>';
        
        include_once 'updates/AUpdateList.php';
        $version = AUpdateList::$latest_program_version;
        $version_string = "v.".$version['major'].".".$version['minor'].".".$version['revision'];
        
        
        echo '<h2><a href="'.$version['filename'].'" target="_blank" onclick="_gaq.push([\'_trackEvent\',\'Download\',\''.$version['name'].'\',this.href]);">';
    //    echo '<p>You can download the latest version from the <a href="https://github.com/MASGAU/">GitHub page</a>, or from here:</p>';
        echo 'Download '.$version_string.' Installer for Windows<br />(Desktop AND Portable!)</a></h2>'        
        .'<p>MASGAU REQUIRES <a href="http://www.microsoft.com/NET/">Microsoft\'s .NET framework</a> to be installed. Setup will  download and install it automatically if it isn\'t.</p>';
        
        echo '</td><td>';
        echo '
        <p>Release highlights:
        <ul>';
        foreach($version['features'] as $feature) {
            echo "<li>".$feature."</li>";
        
        }
        echo '</ul>
        </p>
        ';
        
        echo ''
        
        .'<p>No guarantees that this won\'t destroy your computer and all that.</p>'
        
        . '</td></tr><tr><td>'
                
        .'<h2><a href="https://docs.google.com/open?id=0By2Mfv6zO9SkVGktb1NCWnJqMkU" target="_blank" onclick="_gaq.push([\'_trackEvent\',\'Download\',\'Unstable\',this.href]);">';
        
        
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
                
        .'<h2>Download Older Versions</h2>';
        
        $old_version = AUpdateList::$old_program_versions;
        foreach($old_version as $version) {
            echo '<center><b><a href="'.$version.'" target="_blank" onclick="_gaq.push([\'_trackEvent\',\'Download\',\''.$version.'\',this.href]);">';
            echo $version."</a></b></center>";
        }

        echo '</td><td>'
        .'<h2><a href="https://github.com/MASGAU/">Source Code (GitHub)</a></h2>';
        
        echo '</td></tr><tr><td colspan="2">Award/emblem things: ';
        
        echo '<a href="http://www.soft82.com/download/windows/masgau/" target="_blank"><img src="http://www.soft82.com/images/produse/clean_awards/soft82_clean_award_40523.png" width="167" height="129" border="0" alt="Soft82 100% Clean Award For MASGAU" /></a>';
        echo '<a href="http://www.softpedia.com/progClean/MASGAU-Clean-135066.html" target="_blank"><img src="http://www.softpedia.com/base_img/softpedia_free_award_f.gif" /></a>';
        
        echo '</td></tr><tr><td colspan="2">Mirrors: '
        
        .'<a href="http://download.cnet.com/Masgau/3000-2242_4-75761200.html?part=dl-&subj=dl&tag=button" target="_blank" onclick="_gaq.push([\'_trackEvent\',\'Download\',\'CNET\',this.href]);">
        <img src="http://i.i.com.com/cnwk.1d/i/dl/button/dl-button_a.gif" alt="Get it from CNET Download.com!" height="60" width="150" align="center" border="0"></a> '
        
        
        .'<a href="http://www.soft82.com/download/windows/masgau/" target="_blank" onclick="_gaq.push([\'_trackEvent\',\'Download\',\'SOFT82\',this.href]);">
        <img src="http://www.soft82.com/images/download_buttons/download_button_1.gif" alt="Download From Soft82.com"></a>'

        .'<a href="http://www.softpedia.com/get/System/Back-Up-and-Recovery/MASGAU.shtml" target="_blank" onclick="_gaq.push([\'_trackEvent\',\'Download\',\'SoftPedia\',this.href]);">
        <img src="http://s1.softpedia-static.com/base_img/softpedia_logo4a.gif" ></a>'
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
