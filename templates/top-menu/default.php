<link href="<?php echo findTemplateClientPath($_SERVER["PATH_INFO"], "top-menu", "view", "css"); ?>" rel="stylesheet" type="text/css" />
<div class="top-menu">
 <ul>
  <?php
   $items = explode('/', $_SERVER["PATH_INFO"]);
   unset($path[0]);
   $path = '';
   echo "<li><a href='{$_SERVER["SCRIPT_NAME"]}?{$_SERVER["QUERY_STRING"]}'>/</a></li>\n";
   foreach ($items as $item)
    {
     $path .= '/' . $item;
     echo "<li><a href='{$_SERVER["SCRIPT_NAME"]}{$path}?{$_SERVER["QUERY_STRING"]}'>{$item}</a></li>\n";
    }
  ?>
 </ul>
</div>
