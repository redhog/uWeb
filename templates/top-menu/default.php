<ul class="top-menu">
 <?php
  $items = explode('/', $_SERVER["PATH_INFO"]);
  unset($items[0]);
  $path = '';
  echo "<li><a href='{$_SERVER["SCRIPT_NAME"]}/?{$_SERVER["QUERY_STRING"]}'>Home</a></li>\n";
  foreach ($items as $item)
   {
    $path .= '/' . $item;
    echo "<li><a href='{$_SERVER["SCRIPT_NAME"]}{$path}?{$_SERVER["QUERY_STRING"]}'>{$item}</a></li>\n";
   }
 ?>
</ul>
