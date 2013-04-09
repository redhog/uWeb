<table class="front-page">
 <?php
  $objects = getObjects($_SERVER["PATH_INFO"],
 		        2,
 		        array('Front-page' => 'yes'),
			array('Body', 'Image'));
 
  echo "<tr>\n";
  $width = 0;
  foreach ($objects as $id => $obj)
   {
    $width += 1;
    $path = anyPath(objectPaths($obj));
    $properties = objectProperties($obj);
    $link = "{$_SERVER["SCRIPT_NAME"]}{$path}?{$_SERVER["QUERY_STRING"]}";

    echo "<td class='front-page'>\n";
    if ($properties['Image'])
     echo "<a href='{$link}'><img class='icon' src='{$scriptDirUrl}/files{$properties['Image'][1]}' alt='' /></a><br />\n";
    echo "<a href='{$link}'>{$properties['Body'][1]}</a>\n";
    echo "</td>\n";
   }
  echo "</tr>\n";

  $properties = objectProperties(anyObject(getObjects($_SERVER["PATH_INFO"],
						      0)));
  echo "<tr>\n";
  echo "<td class='front-page' colspan='{$width}'>\n";
  echo $properties['Body'][1] . "\n";
  echo "<dl class='properties'>\n";
  foreach ($properties as $name => $value)
   {
    if ($name != 'Visible' && $name != 'Special' && $name != 'Front-page' && $name != "Title" && $name != "Body")
     if ($value[0] != 'File')
      echo "<div><dt>{$name}</dt><dd>{$value[1]}</dd></div>";
    elseif (   endsWith($value[1], '.jpg')
	    || endsWith($value[1], '.png')
	    || endsWith($value[1], '.gif'))
     echo "<div><dt>{$name}</dt><dd><img src='{$scriptDirUrl}/files{$value[1]}' /></dd></div>";
    else
     echo "<div><dt>{$name}</dt><dd><a href='{$scriptDirUrl}/files{$value[1]}'>Download</a></dd></div>";
   }
  echo "</dl>\n";
  echo "</td>\n";
  echo "</tr>\n";
 ?>
</table>
