<h1>Main menu</h1>
<ul>
 <?php
  echo "<li><a href='{$_SERVER["SCRIPT_NAME"]}/?filter=Special:yes'>Specials</a></li>\n";
  $children = getObjects('/',
			 1,
			 array('Visible' => 'yes'),
			 array('Title', 'Icon'));
  foreach ($children as $id => $obj)
   {
    $path = anyPath(objectPaths($obj));
    $properties = objectProperties($obj);
    echo "<li><a href='{$_SERVER["SCRIPT_NAME"]}{$path}?{$_SERVER["QUERY_STRING"]}'>{$properties['Title'][1]}</a></li>\n";
   }
 ?>
</ul>
<h1>Actions</h1>
<ul>
 <?php
  if ($_GET["action"] == "view")
   echo "<li><a href='{$_SERVER["SCRIPT_NAME"]}{$_SERVER["PATH_INFO"]}?action=edit'>Edit</a></li>";
  else
   echo "<li><a href='{$_SERVER["SCRIPT_NAME"]}{$_SERVER["PATH_INFO"]}?action=view'>View</a></li>";
  if (isset($_SESSION['user']))
   echo "<li><a href='{$_SERVER["SCRIPT_NAME"]}{$_SERVER["PATH_INFO"]}?action=log-out'>Log out</a></li>";
 ?>
</ul>
