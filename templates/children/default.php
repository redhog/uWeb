<?php
 $children = getObjectChildren($_SERVER["PATH_INFO"], array('Visible', 'Title', 'Icon'));
?>
<h1>Children</h1>
<table>
 <?php

  foreach ($children as $path => $attributes)
   if ($attributes['Visible'] != 'no')
    {
     echo "<tr>\n";
     $link = "{$_SERVER["SCRIPT_NAME"]}{$path}?{$_SERVER["QUERY_STRING"]}";

     echo "<td>\n";
     if ($attributes['Icon'])
      echo "<a href='{$link}'><img class='icon' src='{$scriptDirUrl}/files{$attributes['Icon']}' alt=''/></a>\n";
     echo "</td>\n";

     echo "<td><a href='{$link}'>{$attributes['Title']}</a></td>\n";
     echo "</tr>\n";
    }
 ?>
</table>
