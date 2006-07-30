<?php

if ($_POST["saveTypeButton"] == "Add child")
 {
  createObject("{$_SERVER["PATH_INFO"]}/{$_POST["newChildName"]}");
  header("Status: 303 See Other");
  header("Location: {$_SERVER["SCRIPT_NAME"]}{$_SERVER["PATH_INFO"]}/{$_POST["newChildName"]}?action=edit");
 }
elseif ($_POST["saveTypeButton"] == "Save changes")
 {
  if ($_POST["newPropertyName"] != '')
   {
    $_POST[$_POST["newPropertyName"]] = $_POST["newPropertyValue"];
    unset($_POST["newPropertyName"]);
    unset($_POST["newPropertyValue"]);
   }
  unset($_POST["saveTypeButton"]);
  setObjectProperties($_SERVER["PATH_INFO"], $_POST);
  header("Status: 303 See Other");
  header("Location: {$_SERVER["SCRIPT_NAME"]}{$_SERVER["PATH_INFO"]}?action=edit");
 }

?>
