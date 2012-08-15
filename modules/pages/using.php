<?php
$title = 'How To Use';
$content = '<p>I tried to make MASGAU as automated as possible, so with any luck this page won\'t really be necessary.</p>

<thumb src="using/startmenu.jpg" width="200" alt="MASGAU In My Start Menu" /><h2>Modes</h2>


<p>So that you don\'t have to be an admin to use it, MASGAU has 2 different modes it can run in: Single User Mode and All Users Mode. </p>

<h3>Single User Mode</h3>

<p>This mode can be used by any user. It only scans the current user\'s folders and publicly readable system-wide folders. Depending on the specific setup, Single User Mode may or may not be able to restore all saves. If a permission problem occurs, MASGAU will prompt with a choice of elevating MASGAU with admin privileges to complete a restore. This mode is configured per-user.</p>

<h3>All Users Mode</h3>

<p>This mode can only be used by admins or a user with admin credentials. It scans all possible locations for every user on the system. Since it requires elevation, this mode can restore any save to any location. This mode also allows access to the Schedule tab, as even reading the scheduled task requires admin privileges. This mode is globally configured for all users. A scheduled task will use this mode\'s config for backup path, steam override, and alternate install paths.</p>

<thumb src="using/settings.jpg" width="200" alt="The Settings Tab"/>
<h2>Settings</h2>
<p>I\'ve tried to keep the settings to a minimum, and only one of them is actually necessary.</p>

<h3>Auto-check For Updates</h3>
<p>New for 0.8! MASGAU can check for updated game information and program versions. Checking this box will make MASGAU automatically check for these updates when you start the program. This setting also applies to the Monitor.</p>

<h3>Ignore Dates During Backup</h3>
<p>By default MASGAU will only archive a file if its modification time is more recent then the last backup of the game. Use this checkbox to override this behavior.</p>

<h3>Check For Updates</h3>
<p>New for 0.8! This button will force MASGAU to immediately check for updates.</p>

<h3>Backup Path</h3>
<p>This is where to put the archives of the game saves. You should choose a folder on a non-system drive if possible, so that if your system drive dies you still have your saves.</p>

<h3>Steam Path</h3>
<p>MASGAU checks your computer\'s registry to find where Steam is installed. If you installed Steam you should never have to touch this setting. If you\'re like my good buddy Mikey, you might have Steam installed on an external drive, and it wasn\'t necessarily on the system you\'re currently on. You can point MASGAU to this location here, and it will remember it on that computer henceforth. The reset button will tell MASGAU to re-attempt detecting Steam on the system, and if not found MASGAU will default to Not Detected.</p>

<h3>E-Mail Address</h3>
<p>MASGAU can send in reports on errors and new games (at your request, of course), but sometimes I\'ll need to contact you for more info to help fix the problem or add the game. You can set the e-mail address that I will see here.</p>

<h3><a name="alt_install_paths">Alternate Install Paths</a></h3>
<p>Some people don\'t install their game where they ought. For games that store their saves and settings in the user\'s folder this is not a problem, but for those that store their saves and settings in the install folder, this becomes an issue. To help with this, you can add additional paths that will be searched when a game config specifies %INSTALLLOCATION%.  For this to work you must install the games while only changing the Program Files folder to the new location. For example, American McGee\'s Alice installs to:
<code lang="text">
   C:\Program Files\EA GAMES\American McGee\'s Alice
</code></p>'.
'<p>Now let\'s say you keep your games in F:\Games. You would add F:\Games to the Alternate Install Paths and make sure that Alice installs to:
<code lang="text">
   F:\Games\EA GAMES\American McGee\'s Alice
</code></p>
<p>MASGAU will automatically eliminate folders starting at the beginning of the root to check variations of the install location. For example, the above will also try:
<code lang="text">
   F:\Games\American McGee\'s Alice
</code></p>
<p>Of course if there is a registry entry pointing to the game, this is a moot point.</p>

<h3>Make Extra Backups</h3>
<p>Click this button and every so often MASGAU will switch to a new archive when backing up, leaving an archive containing saves only up to that time.</p>

<thumb src="using/backup.jpg" width="200" alt="The Backup Tab"/>
<h2>Backing Up</h2>
<p>To back up all the detected games, just click <i>Back Everything Up</i>. To back up a single game, select it\'s name from the list and click <i>Back This Up</i>. To back up multiple selected games, just select the games you want then click <i>Back These Up</i>. To exercise futility, click <i>Back Nothing up</i>. <i>Redetect Games</i> uses my patent-pending "Really Obvious Naming™" technology. If you hover the mouse over a detected game, a ToolTip will display containing all the detected roots for the game, as well as any comments pertinent to the game.</p>

<p>The checkbox in the backup column controls whether that game is backed up when clicking "Back Everything Up", as well as if the game is watched by the Monitor. When running in All Users mode, it also controls the game being backed up by the scheduled task backup.</p>

<thumb src="using/backupcontextmenu.jpg" width="200" alt="Backup Tab\'s Context Menu"/>
<h3>Context Menu</h3>
<p>New for 0.4! You can right-click in the detected list to reveal a context menu providing per-game functions and options.</p>

<thumb src="using/manualbackup.jpg" width="200" alt="The Custom Backup Window"/>
<h4>Create Custom Archive</h4>
<p>MASGAU can create an archive using only the files you specify. Perfect for sending a save or two to a friend, or uploading onto a save sharing site!</p>
<h4>Back This/These Up</h4>
<p>A duplication of the button below the backup list.</p>
<h4>Purge</h4>
<p>Ever have a game leave saves behind after it\'s uninstalled? Then purge is for you! This will try to wipe whatever was detected from your hard drive. If you don\'t have the right permissions it\'ll try anyway and let you know if it was successful or not. This option is obviously the most dangerous thing in MASGAU, so use it with caution. I accept no responsibility if you accidentally delete your 60-hour Mass Effect save, but you should feel bad anyway for playing it for so long.</p>
<h4>Enable Backup</h4>
<p>Provides a way to enable/disable multiple game backups. Or one at a time if you feel like wasting time.</p>

<thumb src="using/backupprogress.jpg" width="200" alt="A Backup In Progress"/>
<h3>Backup Progress</h3>
<p>While backing up, a progress bar appears at the bottom along with a Stop button. The Stop button that will terminate the backup job after the current file has been archived. Please don\'t pid-kill MASGAU while it\'s backing up, it can leave a mess.</p>

<thumb src="using/restore.jpg" width="200" alt="The Restore Tab"/>

<h2>Restoring</h2>
<p>MASGAU makes 2 kinds of archives: user and global. For user the name of the user is recorded in the archive\'s file name, in the form of GameName«UserName.gb7. Global are only named after the game, as in GameName.gb7. All detected restores will appear in a list in the <i>Restore</i> tab. To restore an archive, find the game in the list. Then click the plus sign next to the game to show all the archives related to the game. There will never be more than one <i>Global</i> archive, but it can contain the saves from several users depending on how the game saves. Just double click a <i>Global</i> or one of the users and it will attempt to restore it. If you double-click a user, it will ask you what user you want to restore it to. Most restores require that the game is detected by the backup system, so that MASGAU can figure out where the saves need to go.</p>

<p>If you have a .gb7 file, such as one a friend e-mailed to you, you should be able to just double-click it and it will be restored to your system.</p>

<p>New for 0.8! The Restore tab now has a "Restore Other Save(s)" button, allowing you to browse to one or more saves and restore it/them.</p>

<p>New for 0.9! Saves are also sorted out by platform and region, so that saves that are not compatible with another platform or region will not be restored to the wrong location. Saves are also sorted into types, so that Settings, Saves, and other various types of files will be separated into different archives.</p>

<thumb src="using/schedule.jpg" width="200" alt="The Schedule Tab"/>
<h2>Scheduling</h2>
<p>This tab will only appear under All Users Mode. Here you can set a schedule to automatically run backups. In order to be able to see all the saves on the system, the task requires the username and password of an admin user. It will automatically enter the name of the admin that it\'s running as, but you must provide a password to add or change the task. This sadly does not work on Windows XP Home.</p>

<thumb src="using/about.jpg" width="200" alt="The About Tab"/>
<h2>About</h2>
<p>This tab shows the current version, and a complete list of all the contributors, along with a count and tooltip-list of all the games they\'ve contributed information on. Also has a link to the MASGAU web page at the bottom.</p>

<thumb src="using/masgaumonitor.jpg" width="200" alt="Desktop Running Monitor"/>
<h2>MASGAU Monitor</h2>
<p>New for 0.4! MASGAU Monitor is a tray application that watches detected save game roots for changes. When one is reported, the file is grabbed as soon as the game releases it and archived. Together with the "Extra Backups" option this can be used to create multiple backups of savegames in real-time. Handy if your save gets corrupted. <p>

<thumb src="using/monitorcontext.jpg" width="200" alt="The Monitor\'s Context Menu"/>
<p>Right-clicking the Monitor icon opens a context menu providing several options. <i>Rescan Games</i> will make Monitor re-scan the system for games, as well as refresh any settings that may have been changed in MASGAU\'s other modules. Clicking <i>Exit</i> will shut down the Monitor.</p>

<thumb src="using/monitorgameslist.jpg" width="200" alt="The Monitor\'s Game List"/>
<p>Clicking <i>Settings...</i> in the context menu will open the Monitor-specific settings window. The first tab is a list of all the detected games, along with checkboxes to control monitor\'s behavior. The Backup column controls whether Monitor will watch that game for saves to be archived (this setting is shared with the Task and Main module). The sync column controls MASGAU\'s newest feature:</p>

<h3>Synchronization</h3>
<thumb src="using/monitorsettings.jpg" width="200" alt="The Monitor\'s Settings Tab"/>
<p>New for 0.9! MASGAU Monitor can also has a synchronization function that maintains an identical folder structure of all the sync-enabled game saves. Just enable the games you want to sync the saves for, pick the sync path, and MASGAU will copy all those games saves into that folder (sorted into subfolders by game of course). If anything changes in either the save folder OR the sync folder, MASGAU will make the same change happen to the other folder. With this, you can put your sync folder in something like a dropbox folder, then do the same on another computer, keeping your saves in sync between computers.</p>

<thumb src="using/analyzer.jpg" width="200" alt="The Analyzer"/>
<h2><a name="analyzer">Analyzer</a></h2>
<p>Analyzer is a tool for gathering information about unsupported games so I can add them to MASGAU. Use is simple (sort of):
<thumb src="using/analyzerscanning.jpg" width="200" alt="Analyzer Scanning A Game"/>
<ol>
<li>Type in the name of the game.
<li>Use the buttons to specify where the game is installed.
<li>Use the buttons to specify where the game keeps its saves.
<li>Click the Scan button.
<li>Wait for the scan to finish.
<thumb src="using/analyzerreport.jpg" width="200" alt="An Analyzer Report"/>
<li>(Optional) Edit the report
<li>Click the E-Mail button to send me the report.
<li>Do something else.
</ul></p>
<p>Note: Submitted reports are uploaded to the GitHub server, and can be browsed at <a href="https://github.com/MASGAU/MASGAU/tree/data/Reports">https://github.com/MASGAU/MASGAU/tree/data/Reports</a></p>';
$footer = "";
?>