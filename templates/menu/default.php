<div class="menu">
 <h1>Main menu</h1>
 <ul>
  <?php
   foreach (getObjectChildren('/') as $path => $title)
    {
     echo "<li><a href='{$_SERVER["SCRIPT_NAME"]}{$path}?{$_SERVER["QUERY_STRING"]}'>{$title}</a></li>\n";
    }
  ?>
 </ul>
 <h1>Actions</h1>
 <ul>
  <li><a href='<?php echo "{$_SERVER["SCRIPT_NAME"]}{$_SERVER["PATH_INFO"]}?action=view" ?>'>View</a></li>
  <li><a href='<?php echo "{$_SERVER["SCRIPT_NAME"]}{$_SERVER["PATH_INFO"]}?action=edit" ?>'>Edit</a></li>
  <li><a href='<?php echo "{$_SERVER["SCRIPT_NAME"]}{$_SERVER["PATH_INFO"]}?action=log-out" ?>'>Log out</a></li>
 </ul>
</div>