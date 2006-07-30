<?php
 $properties = getObjectProperties($_SERVER["PATH_INFO"]);
 $children = getObjectChildren($_SERVER["PATH_INFO"]);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title><?php echo $properties['Title'][1]; ?></title>
  <link href="<?php echo findTemplateClientPath($_SERVER["PATH_INFO"], "main", "view", "css"); ?>" rel="stylesheet" type="text/css" />
 </head>

 <body>
  <?php require(findTemplateServerPath($_SERVER["PATH_INFO"], "top-menu", "view", "php")); ?>
  <?php require(findTemplateServerPath($_SERVER["PATH_INFO"], "menu", "view", "php")); ?>
  <?php require(findTemplateServerPath($_SERVER["PATH_INFO"], "object", "view", "php")); ?>
 </body>
</html>
