<?php
 require(findTemplateServerPath($_SERVER["PATH_INFO"], "conditions", $_GET["action"], "php"));
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title><?php echo $properties['Title'][1]; ?></title>
  <link href="<?php echo findTemplateClientPath($_SERVER["PATH_INFO"], "page", $_GET["action"], "css"); ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo findTemplateClientPath($_SERVER["PATH_INFO"], "top-banner", $_GET["action"], "css"); ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo findTemplateClientPath($_SERVER["PATH_INFO"], "top-menu", $_GET["action"], "css"); ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo findTemplateClientPath($_SERVER["PATH_INFO"], "menu", $_GET["action"], "css"); ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo findTemplateClientPath($_SERVER["PATH_INFO"], "main", $_GET["action"], "css"); ?>" rel="stylesheet" type="text/css" />
  <?php
   foreach (findTemplateSetClientPath($_SERVER["PATH_INFO"], "libs", $_GET["action"], "css") as $template)
    echo "<link href='$template' rel='stylesheet' type='text/css' />\n";
   foreach (findTemplateSetClientPath($_SERVER["PATH_INFO"], "libs", $_GET["action"], "js") as $template)
    echo "<script type='text/javascript' src='$template'></script>\n";
  ?>
 </head>
 <body>
  <table class="page">
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
    <td class="main">
     <?php require(findTemplateServerPath($_SERVER["PATH_INFO"], "main", $_GET["action"], "php")); ?>
    </td>
   </tr>
  </table>
 </body>
</html>
