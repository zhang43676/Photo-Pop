<link rel = "stylesheet" type = "text/CSS" href="../login.css" /> 

<html>
<body class = "help">

<h1> PhotoPop User Documentation:<br><h1><h3>
<ul>
<a href="#instal1">Installation Guide</a><br>
<a href="#manual">User Manual</a>
<ul>
<li><a href="#user">User Management Module</a></li>
<li><a href="#security">Security Module</a></li>
<li><a href="#uploading">Uploading Module</a></li>
<li><a href="#display">Display Module</a></li>
<li><a href="#search"<>Search Module</a></li>
<li><a href="#data">Data Analysis Module</a></li>
</ul></ul></h3>
<h1>Installation Guideline:</h1>
We are using  Oracle as our database tier and PHP as our web server tier. 

<ol>
<li>Copy all our files into a folder called &quot;c391www&quot; in your main directory on the lab machines.</li>
<li>Go into your c391www directory and type &quot;make&quot; (this gives the PHP files permission to execute).</li>
<li>Go into SqlPlus and run setup.sql and additional_setup.sql.</li>
<li>Go to &quot;http://clive.cs.ualberta.ca/~your_ccid/oracle_signin.php&quot;.</li>
<li>Enter your CCID as well as your Oracle login and password.</li>
<li>You will be taken to the login page and can now begin your PhotoPop adventure!<br>
If you are not taken to the login page, there was a problem with your Oracle signin so re-try.</li>
</ol>

<a id="manual"><h1>User Manual:</h1></a>
<a id="user"><h2>User Management Module</h2></a>
At the login page you can either login or click the &quot;Signup&quot; button to take you to the registration page. The administrator has to register with the username &quot;admin&quot;.
<br><br>
Once logged in, you will be taken to PhotoPop where there is a menu along the top of the page that takes you to the different modules: 
<ul>
<li>&quot;Admin View&quot;(only for admin),&quot;User View&quot; and &quot;Top 5&quot; takes you the Display Module</li>
<li>&quot;Groups&quot; takes you to the Security Module</li>
<li>&quot;Data Analysis&quot; takes you to the Data Analysis Module (if you are admin)</li>
<li>&quot;Upload&quot; takes you to the Uploading Module</li>
<li>&quot;Search&quot; takes you to the Search Module</li></ul>
There is another menu in the upper left corner:
<ul>
<li>&quot;Help Me&quot; lets you view this user documentation online</li>
<li>&quot;Settings&quot; lets you change details that you set during registration</li>
<li>&quot;Logout&quot; signs you out</li></ul>

<a id="security"><h2>Security Module</h2></a>
On the &quot;Groups&quot; page, you will see a list of groups you created and a list of groups you belong to. Click &quot;Edit&quot; to edit groups you own and click &quot;View&quot; to view groups you are a part of.
<br><br>
You can create a group by entering a name and then clicking the &quot;Create new group&quot; button. On the &quot;Edit&quot; page you can add new members by entering their username and clicking &quot;Add new member&quot;. Click the &quot;Delete&quot; button beside the member to remove them from the group.
<br><br>
When you are editing or viewing a group page, you can also click &quot;Change my notice&quot; to update your notice which all members of the group can see.

<a id="uploading"><h2>Uploading Module</h2></a>
After going to the group page, you select how much images you want to upload, up to 20. It&quot;s okay if you select more than you need, you can leave some of the file upload bars blank. Enter an optional subject, place and description, and set the date and permissions. The possible permissions are &quot;Private&quot;,&quot;Public&quot; and then any other groups you belong to.
Once a picture is uploaded you have a confirmation message and are displayed both the image and the thumbnail. The thumbnail is used when images are displayed in lists. If the file is bad or you left it blank it will say &quot;Bad File&quot; - this does not prevent the other images from loading so don't worry, just try again with the image that failed.

<a id="display"><h2>Display Module</h2></a>
If you are an admin, you get the &quot;Admin View&quot; link in the menu bar, you get to see all pictures regardless of permissions. If you are a user, you get the &quot;User View&quot; link in the menu bar, you get to see all pictures permitted by your group membership and the pictures membership.
<br><br>
When users and admin click the &quot;Top 5&quot; link in the menu bar, they see the top 5 pictures (of the pictures they are permitted to see depending on admin/user status). The popularity in the top 5 is based on the number of unique vistors that have clicked on the pictures.
<br><br>
When viewing a list of images (either while in Admin/User View or Top 5), if you click on the image you can see a bigger version of the picture as well as details like who created it, the group, and other descriptive information. If you click on an image that is owned by you, you will additionally get an &quot;Edit&quot; button. When you click on this button you will see entry fields for permission, subject, place and description (auto-filled with the current values). You can update the fields deseired, and after clicking &quot;Update&quot; you will be brought back to the image which now displays the new information.

<a id="search"><h2>Search Module</h2></a>
You have a couple different ways of searching through images. It will only return results of pictures that you are allowed to see.
<ul>
<li>If you just enters a keyword, the search results are ordered by a secret formula that determines the relevancy of each picture to your keywords.</li>
<li>If the user enters a time period, they can choose to rank by most recent first or most recent last, and then the pictures will be displayed that fall in that time range.</li><li>If you enter both a keyword and a time period, you can choose to rank by most recent first or most recent last, and then the pictures will be displayed that fall in that time range and match that keyword.
</li>
</ul>
<a id="data"><h2>Data Analysis Module</h2></a>
You can only access this if you are an admin. 
<br><br>
The data cube used to analyze is generated upon entering this page. In order to get the latest data, refresh the page, otherwise you can continue performing analysis queries using the same cube.
<br><br>
First select the dimensions you do NOT wish to aggregate be clicking 1 or more dimension check boxes. For &quot;User&quot; and &quot;Subject&quot;, you can further slice the dimension by entering a value in the provided text box beside the dimension. For &quot;Time&quot;, you can choose to slice the dimension in terms of yearly, monthly, weekly, or select a specific slice using the drop down menu.
<br><br>
CAREFUL - make sure you select the dimension if you want to slice it, do NOT just choose the slice! For example, if you want to slice on the year 2013, you MUST select &quot;Time&quot; and you must choose to slice it yearly. Likewise, if you want to slice on user &quot;Alice&quot;, you must choose dimension &quot;User&quot;. 

</body>
</html>