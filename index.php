<?php
    $title = "MASGAU";
    include_once 'modules/AModule.php';
    include_once 'modules/Page.php';
    include_once 'modules/Downloads.php';

    include_once 'headers.php';
    if(!isset($module)) {
        $_GET['name'] = 'home';
        $module = AModule::LoadModule('page',$con);
    }
    if(isset($module)) {
        $title .= $module->title();
    }


?>

<!DOCTYPE HTML>
<html>
<head>
<title><?php echo $title; ?></title>
<link media="Screen" href="css/masgau.css" type="text/css" rel="stylesheet" />
<link media="Screen" href="libs/jquery/css/dark-hive/jquery-ui-1.8.19.custom.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="libs/jquery/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="libs/jquery/jquery-ui-1.8.19.custom.min.js"></script>
<script type="text/javascript" src="libs/yoxview/yoxview-init.js"></script>
<script type="text/javascript" src="javascript/masgau.js"></script>

<?php 
    if(isset($module)) {
        $module->headers();
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

<a href="http://masgau.org/"><img src="images/logo.png" class="logo" /></a>

<?php echo Downloads::CreateLink(); ?><img src="images/download.png" class="download" /></a>


<div class="social">
<!-- Place this tag where you want the +1 button to render -->
<g:plusone size="tall"></g:plusone>

<!-- Place this render call where appropriate -->
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>

<div class="fb-like" data-href="http://masgau.org/" data-send="false" data-layout="box_count" data-width="100" data-show-faces="false"></div></div>

<?php 
    $menus = AModule::RunQueryOnConnection("SELECT * FROM masgau_site.menus ORDER BY `order`",$con);
    $i = 1;
    while($row = mysql_fetch_array($menus)) {
        echo '<div class="menu_title" id="menu_title_'.$i.'">'.$row['title'].'</div>';
        $i++;
    }
?>

<div class="shadow_area">
<div class="fadeout">&nbsp;</div>

<?php 
    mysql_data_seek($menus,0);
    $i = 1;
    while($row = mysql_fetch_array($menus)) {
        echo '<div class="menu" id="menu_'.$i.'">';
        echo '<div class="items">';
        
        $items = AModule::RunQueryOnConnection("SELECT * FROM masgau_site.menu_items WHERE menu = ".$row['id']." ORDER BY `order`",$con);
        while($item = mysql_fetch_array($items)) {
            echo AModule::CreateLinkForModule($item['type'],$item['option']).$item['title'].'</a><br />';
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
</div>

</div>

</body>
</html>

<?php mysql_close($con); ?>