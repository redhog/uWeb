<?php
 require(findTemplateServerPath($_SERVER["PATH_INFO"], "conditions", $_GET["action"], "php"));

 unset($_POST["saveTypeButton"]);
 $names = array();
 $types = array();
 foreach ($_POST as $name => $value)
  {
   if (endsWith($name, '_name'))
    $names[substr($name, 0, strlen($name) - strlen('_name'))] = $value;
   elseif (endsWith($name, '_type'))
    $types[substr($name, 0, strlen($name) - strlen('_type'))] = $value;
   else
    die("Don't know what to do with " . $name);
  }
 setProperties($names, $types);
 header("Status: 303 See Other");
 header("Location: {$_SERVER["SCRIPT_NAME"]}{$_SERVER["PATH_INFO"]}?action=edit");
?>
