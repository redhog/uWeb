<?php

require(findTemplateServerPath($_SERVER["PATH_INFO"], "conditions", $_GET["action"], "php"));

function mkdir_r($dirName, $rights=0777){
   $dirs = explode('/', $dirName);
   $dir='';
   foreach ($dirs as $part) {
       $dir.=$part.'/';
       if (!is_dir($dir) && strlen($dir)>0)
	if (!mkdir($dir, $rights)) return false;
   }
   return true;
}

if ($_POST["saveTypeButton"] == "Add child")
 {
  createObject("{$_SERVER["PATH_INFO"]}/{$_POST["newChildName"]}");
  header("Status: 303 See Other");
  header("Location: {$_SERVER['SCRIPT_NAME']}{$_SERVER['PATH_INFO']}/{$_POST['newChildName']}?action=edit");
 }
elseif ($_POST["saveTypeButton"] == "Save changes")
 {
  if ($_POST["newPropertyName"] != '')
   $_POST[$_POST["newPropertyName"]] = $_POST["newPropertyValue"];
  if ($_POST["newFilePropertyName"] != '')
   {
    $_FILES[$_POST["newFilePropertyName"]] = $_FILES["newFilePropertyValue"];
    unset($_FILES["newFilePropertyValue"]);
   }
  foreach ($_FILES as $name => $uploadFile)
   {
    if ($uploadFile['name'] == '')
     $_POST[$name] = $_POST[$name . '_orig'];
    else
     {
      $basedir = dirname($_SERVER["SCRIPT_FILENAME"]) . "/files";
      $dir = $_SERVER["PATH_INFO"];
      mkdir_r($basedir . $dir, 0770, TRUE)
       or die("Unable to create dir " . $dir); 
      $file = $dir . '/' . $uploadFile['name'];
      move_uploaded_file($uploadFile['tmp_name'], $basedir . $file)
       or die("You evil crackur, that's not a file!");
      $_POST[$name] = $file;
     }
    unset($_POST[$name . '_orig']);
   }
  unset($_POST["newPropertyName"]);
  unset($_POST["newPropertyValue"]);
  unset($_POST["newFilePropertyName"]);
  unset($_POST["newFilePropertyValue"]);
  unset($_POST["saveTypeButton"]);

  foreach ($_POST as $name => $value)
   if ($value == '')
    unset($_POST[$name]);
  setObjectProperties($_SERVER["PATH_INFO"], $_POST);
  header("Status: 303 See Other");
  header("Location: {$_SERVER['SCRIPT_NAME']}{$_SERVER['PATH_INFO']}?action=edit");
 }

?>
