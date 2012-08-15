<?php
$title = 'How to Contribute';

$content = 'There are a few ways you can contribute, and here\'s the order of priority as far as need goes:
<ol>
<li>Game Information!<br />
MASGAU works in conjunction with <a href="http://gamesave.info">GameSave.Info</a> to provide a comprehensive save information database AND backup solution (fancy words!). If you contribute save information to GameSave.Info, it\'ll automatically be in MASGAU, and vice-versa. There\'s a couple ways you can do this:
<ol>
<li>Use MASGAU\'s Analyzer component to submit game information. 
This is the easiest for you, as it only takes a couple clicks, then I do all the heavy lifting of adding it to the database</li>
<li>E-mail me your custom XML. 
This requires you to write your own XML, 
the format of which is explained over at <a href="http://gamesave.info/xml_format.php">the GameSave.Info site</a>. 
MASGAU will read from game info from any XML file in the data folder, so you can add as many as you want! 
While testing, you should probably not add any entries to the built-in XML files, so you don\'t risk breaking your MASGAU install.</li>
<li>Commit your own XML into <a href="https://github.com/GameSaveInfo/Data">GameSave.Info\'s GitHub Repository</a>. 
This still requires you to write your own XML, but it also takes advantage of GitHub\'s excellent peer review process. 
Just go to the repository, fork it into your own account (register one if you don\'t already have one, they\'re free!) and then commit all you want! 
As long as it\'s in your own fork, you run no risk of damaging GameSave.Info\'s master data files, so you can experiment all you want! 
I watch people\'s forks and offer tips and corrections as they work, so you don\'t have to worry about making any mistakes! 
Once your new data is ready, issue a pull request back into GameSaveInfo/Data. 
Adfter I approve the pull, your data will be part of GameSave.Info!</li>
</ol>
</li>
<li>Programming<br />
MASGAU still needs plenty of work! All you need to do is for it over in GitHub, then start hacking away!
</li>
</ol>';

$footer = '';

?>