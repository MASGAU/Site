<?php
$title = 'How To Use';
$content = '


<h2>Modes</h2>


<p>So that you don\'t have to be an admin to use it, MASGAU has 2 different modes it can run in: Single User Mode and All Users Mode. Both of these modes have icons in the Start Menu, and you can switch between them using the button in the lower-left corner of the main window.</p>
<table><tr><td>
<h3>Single User Mode</h3>

<p>This mode can be used by any user. It only scans the current user\'s folders and publicly readable system-wide folders. 
Depending on the specific setup, Single User Mode may or may not be able to restore all saves. 
If a permission problem occurs, MASGAU will prompt with a choice of elevating MASGAU with admin privileges to complete a restore.</p>
</td><td width="50%">
<h3>All Users Mode</h3>

<p>This mode can only be used by admins or a user with admin credentials. 
It scans all possible locations for every user on the system. 
Since it requires elevation, this mode can restore any save to any location.
</p>
</td></tr><tr><td colspan="2">
<p>Both of these modes will use the same settings, which are stored per-user.</p>
</td></tr></table>


<center>
<h2>The Main Window</h2>
This is what the main window looks like. Hover the mouse over the various parts for explanations!
<br/>
<div class="hoverable_image" style="width:800px;">
<img src="../../images/using/mainwindow.jpg"/>

<div style="left:0px;top:4px;width:55px;height:24px;" class="has_tooltip">
<div class="tooltip">
Opens a menu containing items to:
<ul>
<li>View The About Screen</li>
<li>Quit The Program</li>
</ul>
</div>
</div>

<div style="left:172px;top:4px;width:55px;height:24px;" class="has_tooltip">
<div class="tooltip">
Switches to the settings tab (see further down for an explanation of that)
</div>
</div>

<!-- Window controls -->
<div style="right:48px;top:4px;width:24px;height:24px;" class="has_tooltip">
<div class="tooltip">
Minimizes the window
</div>
</div>

<div style="right:24px;top:4px;width:24px;height:24px;" class="has_tooltip">
<div class="tooltip">
Toggles fullscreen mode
</div>
</div>

<div style="right:0px;top:4px;width:24px;height:24px;" class="has_tooltip">
<div class="tooltip">
Send the window to the notification tray<br/>
Does NOT close MASGAU, to do that use the top-left menu<br/>
or right-click the notificaiton icon and click "Exit"
</div>
</div>

<!-- Game section -->
<div style="left:0px;top:28px;width:55px;height:74px;" class="has_tooltip">
<div class="tooltip">
Re-scans your computer for games and save archives.<br/>
Save archives are only detected in the backup folder.
</div>
</div>

<div style="left:55px;top:28px;width:65px;height:24px;" class="has_tooltip">
<div class="tooltip">
Opens a dialog to add a custom game to MASGAU (see further down for an explanation of that)
</div>
</div>

<div style="left:55px;top:52px;width:65px;height:24px;" class="has_tooltip">
<div class="tooltip">
If a custom game is selected in the game list, this button will let you delete it.<br/>
You cannot delete game data that came with MASGAU, or was downloaded in an update.
</div>
</div>

<div style="left:55px;top:76px;width:65px;height:24px;" class="has_tooltip">
<div class="tooltip">
Generates reports on custom games to send back to me so that I can add it to MASGAU\'s official game data.
</div>
</div>


<!-- Back up section -->

<div style="left:125px;top:28px;width:70px;height:74px;" class="has_tooltip">
<div class="tooltip">
Back up all of the detected games to the backup folder
</div>
</div>


<div style="left:195px;top:28px;width:160px;height:24px;" class="has_tooltip">
<div class="tooltip">
Backs up only the games selected in the games list
</div>
</div>

<div style="left:195px;top:52px;width:150px;height:24px;" class="has_tooltip">
<div class="tooltip">
Lets you choose specific files from a specific location for a specific game,<br/>
and back that up to a locaiton and file name of your choice.<br/>
Only enabled when one game is selected.
</div>
</div>

<div style="left:195px;top:76px;width:150px;height:24px;" class="has_tooltip">
<div class="tooltip">
Allows you to change or open the backup folder
</div>
</div>

<!-- Restore section -->

<div style="left:370px;top:28px;width:100px;height:74px;" class="has_tooltip">
<div class="tooltip">
Restore the archives selected in the archives list<br/>
See further down for an example of the restore window
</div>
</div>


<div style="left:470px;top:28px;width:100px;height:24px;" class="has_tooltip">
<div class="tooltip">
Opens a file browser so you can select an archive to restore<br/>
See further down for an example of the restore window
</div>
</div>

<!-- Other section -->

<div style="left:590px;top:28px;width:40px;height:74px;" class="has_tooltip">
<div class="tooltip">
Deletes the detected game data for the games selected in the games list<br/>
This is obviously very dangerous. Careful.
</div>
</div>

<div style="left:630px;top:28px;width:60px;height:74px;" class="has_tooltip">
<div class="tooltip">
Checks if there is an update for the game data, or for MASGAU itself.<br/>
MASGAU will automatically check for updates on startup, and if there are some found,<br/>
this button will change its label to reflect what updates are available.
</div>
</div>

<div style="left:690px;top:28px;width:70px;height:74px;" class="has_tooltip">
<div class="tooltip">
Sends me an e-mail with whatever you want to tell me :)
</div>
</div>


<!-- main section! -->

<div style="left:0px;top:118px;width:520px;height:350px;" class="has_tooltip">
<div class="tooltip">
A list of games detected on your computer.<br/>
This is where you can select specific games
</div>
</div>

<div style="right:220px;top:118px;width:50px;height:350px;" class="has_tooltip">
<div class="tooltip">
Enables/disables monitoring for each individual game<br/>
See further down for an explanation of monitoring
</div>
</div>


<div style="right:0px;top:118px;width:200px;height:350px;" class="has_tooltip">
<div class="tooltip">
A list of detected archives for the games selected in the games list<br/>
If no games are selected, or there are no archives for the games selected,<br/>
then this list will not be visible
</div>
</div>

<div style="left:3px;top:473px;width:24px;height:24px;" class="has_tooltip">
<div class="tooltip">
Indicates wether MASGAU is running in:
    <ul>
    <li>Single User Mode (the icon with one person)</li>
    <li>All Users Mode (the icon with two people)</li>
    </ul>
Clicking will switch between these modes
</div>
</div>

<div style="left:27px;top:473px;width:224px;height:24px;" class="has_tooltip">
<div class="tooltip">
Tells how many games were detected (obviously)
</div>
</div>

<div style="right:41px;bottom:4px;width:124px;height:24px;" class="has_tooltip">
<div class="tooltip">
Tells how many games have monitoring enabled<br/>
See further down for an explanation of monitoring
</div>
</div>


<div style="right:17px;bottom:4px;width:24px;height:24px;" class="has_tooltip">
<div class="tooltip">
Indicates wether Steam has been detected<br/>
Clicking opens a folder browser to manually set the Steam path
</div>
</div>

<div style="right:0px;bottom:4px;width:14px;height:14px;" class="has_tooltip">
<div class="tooltip">
Resizes the window
</div>
</div>


</div>
<h3>Dragging a MASGAU archive (files that end with .gb7)<br/>onto any part of the window will open a restore dialog for that archive</h3>
</center>




<h2>The Settings Tab</h2>
<center>
<div class="hoverable_image" style="width:750px;">
<img src="../../images/using/settingstab.jpg"/>

<div style="left:55px;top:4px;width:105px;height:24px;" class="has_tooltip">
<div class="tooltip">
Switches back to the main tab, the one with the backup and restore buttons and stuff
</div>
</div>

<div style="left:0px;top:28px;width:135px;height:24px;" class="has_tooltip">
<div class="tooltip">
Allows you to change or open the backup folder<br/>
And yes, it is the same as the button on the other tab
</div>
</div>

<div style="left:0px;top:52px;width:135px;height:24px;" class="has_tooltip">
<div class="tooltip">
Adds and remove Alternate Save Folders<br/>
These are used to specify non-standard locations for your games,<br/>
like fi you keep your games in C:\Games or something
</div>
</div>

<div style="left:135px;top:28px;width:155px;height:74px;" class="has_tooltip">
<div class="tooltip">
If this is enabled, when MASGAU adds new files to an archive it will check how long it has been since the creation of that archive.<br/>
If the time is greater than what is specified here, MASGAU makes a copy of the archive before adding to it.<br/>
If the number of extra copies grows larger than the max specified here, the oldest archive(s) will be deleted.
</div>
</div>


<div style="left:290px;top:32px;width:205px;height:24px;" class="has_tooltip">
<div class="tooltip">
Sets the e-mail address used as the from address when sending error or game reports
</div>
</div>


<div style="left:290px;top:56px;width:205px;height:20px;" class="has_tooltip">
<div class="tooltip">
By default MASGAU only archives new files with a newer modified date than the archive.<br/>
If this is checked, MASGAU will always back up every file it finds.<br/>
</div>
</div>


<div style="left:290px;top:76px;width:205px;height:24px;" class="has_tooltip">
<div class="tooltip">
Enables or disables MASGAU starting when you log on to your computer.<br/>
</div>
</div>


</div>
</center>

<h2>The Restore Window</h2>

<center>
<p>This window appears when you double-click an archive,<br/>
or drag an archive onto the main window, or when you select an archive to restore in the main window.</p>
<div class="hoverable_image" style="width:506px;">
<img src="../../images/using/restorewindow.jpg"/>

<div style="left:20px;top:30px;width:450px;height:20px;" class="has_tooltip">
<div class="tooltip">
This displays or lets the user choose (depending on how many are found) the location that MASGAU is going to restore the save to
</div>
</div>

<div style="left:20px;top:90px;width:450px;height:20px;" class="has_tooltip">
<div class="tooltip">
Displays or lets the user choose which user to restore the save to
</div>
</div>


<div style="bottom:6px;right:380px;width:100px;height:30px;" class="has_tooltip">
<div class="tooltip">
The restore normally opens in single-user mode, so if a user is needed then only one will be shown.<br/>
Clicking this button will restart the restore in all-users mode, so you can restore to a different user.
</div>
</div>

<div style="bottom:6px;right:256px;width:120px;height:30px;" class="has_tooltip">
<div class="tooltip">
Allows the specifying of a different restore location than the ones detected by MASGAU
</div>
</div>

<div style="bottom:6px;right:158px;width:95px;height:30px;" class="has_tooltip">
<div class="tooltip">
Allows the choosing of specific files in the archive to restore
</div>
</div>

<div style="bottom:6px;right:80px;width:75px;height:30px;" class="has_tooltip">
<div class="tooltip">
Begins the restore process
</div>
</div>

<div style="bottom:6px;right:6px;width:70px;height:30px;" class="has_tooltip">
<div class="tooltip">
Cancels the restore.<br/>
If restoring multiple files, this will cancel restoring all of them.
</div>
</div>

</div>
</center>

<h2>Adding A Custom Game</h2>

<center>
<div class="hoverable_image" style="width:750px;">
<img src="../../images/using/addgame.jpg" width="750"/>

<div style="left:135px;top:84px;width:505px;height:324px;" class="has_tooltip">
<div class="tooltip">
Do I seriously need to explain this?<br/>
The little question mark icons explain what to type for the file names.
</div>
</div>


</div>
<p>After a game is added, MASGAU will ask if it\'s okay to submit a report on that game.
If allowed, MASGAU will scan the computer for information related to the game and create a text report.
It will display this report for editing, which is perfectly acceptable, and give the options of saving the report for later e-mailing to <a href="mailto:submissions@gamesave.info">submissions@GameSave.Info</a> or sending the report to that address automatically.

Note: Submitted reports are uploaded to the GitHub server, and can be browsed at <a href="https://github.com/GameSaveInfo/Reports">GameSave.Info\'s GitHub Report Repository</a></p>
</center>



<h2>Monitoring</h2>
<center>
<p>If monitoring is enabled for a game, MASGAU (as long as it\'s running) will watch that game for any new files and automatically archive them.
This means that all your saves will be automatically archived without you having to go through all the hard gruelling work of pushing a backup button!
</p>
<div class="hoverable_image" style="width:750px;">
<img src="../../images/using/monitor.jpg" width="750"/>

<div style="left:30px;top:100px;width:350px;height:220px;" class="has_tooltip">
<div class="tooltip">
This is the main window. While important, it\'s not the monitor icon.<br/>
That\'s in the lower right of this picture, it\'s colored red.
</div>
</div>


<div style="left:190px;top:400px;width:30px;height:20px;" class="has_tooltip">
<div class="tooltip">
Okay, close, but this isn\'t it either.<br/>
Keep going right.
</div>
</div>


<div style="left:660px;top:400px;width:20px;height:20px;" class="has_tooltip">
<div class="tooltip">
This icon, right here? That\'s the monitor icon.
</div>
</div>


</div>
<p>
There\'s a red icon in the notification tray that doesn\'t really do anything itself, but if you click it the main window will dissapear, even the task bar icon,
almost as if it\'s living inside the tiny red icon! Click it again and the window will appear again! 
So if you decide to leave MASGAU running to monitor your games, you can make it be practically invisible!
The icon will pop up tiny message baloons if MASGAU has anything important to tell you.
If you have MASGAU living in the icon when you exit it, or log off your computer, when it starts up again it will still be living in the icon.
</p></center>


';
$footer = "";
?>