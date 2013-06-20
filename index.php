<?php
    $title = "MASGAU";
	include_once 'modules/AModule.php';
    include_once 'modules/Page.php';
    include_once 'modules/Downloads.php';

    include_once 'headers.php';
    if(!isset($module)) {
        $_GET['name'] = 'home';
        $module = AModule::LoadModule('page');
    }
    if(isset($module)) {
        $title .= $module->title();
    }
    
    
?>

<!DOCTYPE HTML>
<html>
<head>
<title><?php echo $title; ?></title>

<meta name="description" content="A save game backup and resture utility. Creates easy-to-use archives that can be restored to any supported system." />

<link media="Screen" href="/css/masgau.css" type="text/css" rel="stylesheet" />
<link media="Screen" href="/libs/tooltip.css" type="text/css" rel="stylesheet" />
<link media="Screen" href="/libs/jquery/css/dark-hive/jquery-ui-1.8.19.custom.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="/libs/jquery/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/libs/jquery/jquery-ui-1.8.19.custom.min.js"></script>
<script type="text/javascript" src="/libs/yoxview/yoxview-init.js"></script>
<script type="text/javascript" src="/libs/tooltip.js"></script>
<script type="text/javascript" src="/js/masgau.js"></script>

<?php 
    if(isset($module)) {
        $module->headers();
    }
?>

<?php
global $test_mode;
echo $test_mode;
if(!$test_mode) {
echo "<script type=\"text/javascript\">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-28092952-1']);
  _gaq.push(['_setDomainName', 'masgau.org']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>";
}
?>
</head>
<body>
<div class="left_side side">&nbsp;</div>
<div class="right_side side">&nbsp;</div>

<div class="body_box">
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=241294469250236";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<a href="http://masgau.org/"><img src="/images/logo.png" class="logo" /></a>

<div class="download">

<?php 

$agent = $_SERVER['HTTP_USER_AGENT'];


include_once 'updates/AUpdateList.php';
$version = AUpdateList::$latest_program_version;
$version_string = "v.".$version['major'].".".$version['minor'].".".$version['revision'];

echo '<a href="http://masgau.org/downloads/'.$version['filename'].'" target="_blank" onclick="_gaq.push([\'_trackEvent\',\'Download\',\''.$version['name'].'\',this.href]);">';

?>


<img src="/images/download.png" /><br/>

<?php
echo '<p>'.$version_string.' FOR WINDOWS</p>'   ;     

//echo $agent;

?>
</div>

</a>



<?php 
    $menus = array(
        "For The Users"=>array(
            array("Download MASGAU!","downloads",null),
            array("Using MASGAU (Screenshots!)","page","using"),
            array("Current Game Support","support",null),
            array("Automatically Backup Your Saves On The Net","page","cloud"),
            ),
        "For The Geeks"=>array(
            array("How To Contribute","page","contribute"),
//            array("How MASGAU Works","page","how"),
            array("How To Add New Games","page","xml_spec"),
  //          array("How To Use The Analyzer","page","analyzer"),
            array("Game Database","hyperlink","http://gamesave.info/"),
            array("Changelog","hyperlink","https://github.com/MASGAU/MASGAU/blob/master/Docs/changelog.txt"),
            array("Data Changelog","hyperlink","https://github.com/GameSaveInfo/Data/blob/master/changelog.txt"),
            array("MASGAU on GitHub","hyperlink","https://github.com/MASGAU/"),
            ),
        "For Some Help"=>array(
            //array("Forums","hyperlink","http://forums.masgau.org/"),
            array("Report A Problem!","hyperlink","https://github.com/MASGAU/MASGAU/issues/new"),
            array("MASGAU On Twitter","hyperlink","http://twitter.com/MASGAU/"),
            array("MASGAU On Facebook","hyperlink","http://www.facebook.com/masgau"),
            array("MASGAU On Google+","hyperlink","http://plus.google.com/115220090159606871198"),
            array("My Blog","hyperlink","http://sanmadjack.blogspot.com/"),
            ),
        "For Fun"=>array(
            array("MASGAU on alternativeTo","hyperlink","http://alternativeto.net/software/masgau/"),
            array("Contributor Hall of Fame","contributors",null),
            )
        );
    
    
    $i = 1;
    foreach(array_keys($menus) as $row) {
        echo '<div class="menu_title" id="menu_title_'.$i.'">'.$row.'</div>';
        $i++;
    }
?>

<div class="shadow_area">
<div class="fadeout">&nbsp;</div>

<?php 
    $i = 1;
    foreach($menus as $row) {
        echo '<div class="menu" id="menu_'.$i.'">';
        echo '<div class="items">';
        
        foreach($row as $item) {
            echo AModule::CreateLinkForModule($item[1],$item[2]).$item[0].'</a><br />';
        }
        
        echo '</div></div>';
        $i++;
    }
?>


<?php 
if(isset($module)) {
    echo '<div class="content yoxiew">';
    $module->draw(); 
} else {
    echo '<script type="text/javascript">home_page = true;</script>';
    echo '<div class="content home_content">';
}
    echo '<div class="clear_both"></div>';
    echo '</div>';
?>

<div class="shadowin">&nbsp;</div>
<div class="shadowout">&nbsp;</div>

<div class="fadein">&nbsp;</div>
</div>

<div class="footer">
<?php 
if(isset($module)) {
    echo $module->footer(); 
}
?>
<br/>MASGAU is created by Matthew Barbour and various other contributors
</div>

<div class="social_footer">
<div style="float:right;margin-right:10px;">
<span id="a2itemwidget"></span>
<script src="http://api.alternativeto.net/software/masgau/widgetjs/blue" type="text/javascript"></script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=183744235777";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
</div>
<div style="float:right;margin-right:10px;">
<div class="fb-like" data-href="https://www.facebook.com/masgau" data-send="false" data-layout="box_count" data-width="450" data-show-faces="true"></div>
</div>

<div style="float:right;margin-right:10px;">
<!-- Place this tag where you want the +1 button to render. -->
<div class="g-plusone" data-size="tall" data-href="https://plus.google.com/b/115220090159606871198/115220090159606871198"></div>

<!-- Place this tag after the last +1 button tag. -->
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
</div>

</div>

</div>

</body>
</html>

