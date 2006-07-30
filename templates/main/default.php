<?php
 $properties = getObjectProperties($_SERVER["PATH_INFO"]);
 $children = getObjectChildren($_SERVER["PATH_INFO"]);

 require(findTemplateServerPath($_SERVER["PATH_INFO"], "conditions", $_GET["action"], "php"));
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title><?php echo $properties['Title'][1]; ?></title>
  <link href="<?php echo findTemplateClientPath($_SERVER["PATH_INFO"], "main", $_GET["action"], "css"); ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo findTemplateClientPath($_SERVER["PATH_INFO"], "top-banner", $_GET["action"], "css"); ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo findTemplateClientPath($_SERVER["PATH_INFO"], "top-menu", $_GET["action"], "css"); ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo findTemplateClientPath($_SERVER["PATH_INFO"], "menu", $_GET["action"], "css"); ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo findTemplateClientPath($_SERVER["PATH_INFO"], "object", $_GET["action"], "css"); ?>" rel="stylesheet" type="text/css" />
 </head>
 <body>
  <table class="window">
   <tr>
    <td colspan="2" class="top-banner">
     <?php require(findTemplateServerPath($_SERVER["PATH_INFO"], "top-banner", $_GET["action"], "php")); ?>
    </td>
   </tr>
   <tr>
    <td rowspan="2" class="menu">
     <?php require(findTemplateServerPath($_SERVER["PATH_INFO"], "menu", $_GET["action"], "php")); ?>
    </td>
    <td class="top-menu">
     <?php require(findTemplateServerPath($_SERVER["PATH_INFO"], "top-menu", $_GET["action"], "php")); ?>
    </td>
   </tr>
   <tr>
    <td class="object">
     <?php require(findTemplateServerPath($_SERVER["PATH_INFO"], "object", $_GET["action"], "php")); ?>
    </td>
   </tr>
  </table>
 </body>
</html>
