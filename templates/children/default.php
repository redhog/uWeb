<?php
 $requires = array('Visible' => 'yes');
 if ($_GET["filter"])
  foreach (explode(',', $_GET["filter"]) as $item)
   {
    $item = explode(':', $item);
    $requires[$item[0]] = $item[1];
   }
 $children = getObjects($_SERVER["PATH_INFO"],
			1,
			$requires,
			array('Title', 'Icon'));
?>
<h1>Children</h1>
<table>
 <?php
  foreach ($children as $id => $obj)
   {
    $path = anyPath(objectPaths($obj));
    $properties = objectProperties($obj);
    echo "<tr>\n";
    $link = "{$_SERVER["SCRIPT_NAME"]}{$path}?{$_SERVER["QUERY_STRING"]}";

    echo "<td>\n";
    if ($properties['Icon'])
     echo "<a href='{$link}'><img class='icon' src='{$scriptDirUrl}/files{$properties['Icon'][1]}' alt=''/></a>\n";
    echo "</td>\n";

    echo "<td><a href='{$link}'>{$properties['Title'][1]}</a></td>\n";
    echo "</tr>\n";
   }
 ?>
</table>
