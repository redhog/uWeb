<div class="main">
 <div class="object">
  <h1><?php echo $properties['Title'][1]; ?></h1>
  <?php echo $properties['Body'][1]; ?>
  <dl class="properties">
   <?php
    foreach ($properties as $name => $value)
     {
      if ($name != "Title" && $name != "Body")
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
  <ul>
   <?php

    foreach ($children as $path => $title)
     {
      echo "<li><a href='{$_SERVER["SCRIPT_NAME"]}{$path}?{$_SERVER["QUERY_STRING"]}'>{$title}</a></li>\n";
     }
   ?>
  </ul>
 </div>
</div>
