<?php
 $children = getObjects($_SERVER["PATH_INFO"],
			1,
			array(),
			array('Visible', 'Title', 'Icon'));
?>
<h1>Children</h1>
<table>
 <?php

  foreach ($children as $id => $obj)
   {
    $path = anyPath(objectPaths($obj));
    $properties = objectProperties($obj);

    $cls = 'visible';
    if ($properties['Visible'][1] != 'yes')
     $cls = 'invisible';

    echo "<tr class='$cls'>\n";
    $link = "{$_SERVER["SCRIPT_NAME"]}{$path}?{$_SERVER["QUERY_STRING"]}";

    echo "<td>\n";
    if ($properties['Icon'])
     echo "<a href='{$link}'><img class='icon' src='{$scriptDirUrl}/files{$properties['Icon'][1]}' alt=''/></a>\n";
    echo "</td>\n";

    echo "<td><a href='{$link}'>{$properties['Title'][1]}</a></td>\n";
    echo "</tr>\n";
   }


 ?>
 <tr>
  <td></td>
  <td>
   <form action="<?php echo $_SERVER["SCRIPT_NAME"] . $_SERVER["PATH_INFO"] ?>?action=save" method="post">
    <input name='newChildName' type='text' value='' />
    <input type="submit" name="saveTypeButton" value="Add child" />
   </form>
  </td>
 </tr>
</table>
