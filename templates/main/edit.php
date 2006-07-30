<?php
 session_start();
 if (!isset($_SESSION['user']))
  {
   header("Status: 303 See Other");
   header("Location: {$_SERVER['SCRIPT_NAME']}{$_SERVER['PATH_INFO']}?action=log-in");
   exit(1);
  }

 $properties = getObjectProperties($_SERVER["PATH_INFO"]);
 $children = getObjectChildren($_SERVER["PATH_INFO"]);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title><?php echo $properties['Title'][1]; ?></title>
  <link href="<?php echo findTemplateClientPath($_SERVER["PATH_INFO"], "main", "edit", "css"); ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo findTemplateClientPath($_SERVER["PATH_INFO"], "top-menu", $_GET["action"], "css"); ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo findTemplateClientPath($_SERVER["PATH_INFO"], "menu", $_GET["action"], "css"); ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo findTemplateClientPath($_SERVER["PATH_INFO"], "object", $_GET["action"], "css"); ?>" rel="stylesheet" type="text/css" />
 </head>

 <body>
  <?php require(findTemplateServerPath($_SERVER["PATH_INFO"], "top-menu", "edit", "php")); ?>
  <?php require(findTemplateServerPath($_SERVER["PATH_INFO"], "menu", "edit", "php")); ?>
  <?php require(findTemplateServerPath($_SERVER["PATH_INFO"], "object", "edit", "php")); ?>
 </body>
</html>