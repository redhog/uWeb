<?php
 $properties = getObjectProperties($_SERVER["PATH_INFO"]);
 $children = getObjectChildren($_SERVER["PATH_INFO"], array('Visible', 'Title', 'Icon'));
?>
<div class="object">
 <img class="image" src="<?php echo "{$scriptDirUrl}/files{$properties['Image'][1]}"; ?>" alt="" />
 <h1><?php echo $properties['Title'][1]; ?></h1>
 <?php echo $properties['Body'][1]; ?>
 <dl class="properties">
  <?php
   foreach ($properties as $name => $value)
    {
     if ($name != "Title" && $name != "Body" && $name != "Image")
      if ($value[0] != 'File')
       echo "<div><dt>{$name}</dt><dd>{$value[1]}</dd></div>";
     elseif (   endsWith($value[1], '.jpg')
	     || endsWith($value[1], '.png')
	     || endsWith($value[1], '.gif'))
      echo "<div><dt>{$name}</dt><dd><img src='{$scriptDirUrl}/files{$value[1]}' /></dd></div>";
     else
      echo "<div><dt>{$name}</dt><dd><a href='{$scriptDirUrl}/files{$value[1]}'>Download</a></dd></div>";
    }
  ?>
 </dl>
</div>
<div class="children">
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
</div>
