<?php
$scriptDir = dirname($_SERVER["SCRIPT_FILENAME"]);
$scriptDirUrl = dirname($_SERVER["SCRIPT_NAME"]);

if (!function_exists('array_combine')) {
 require_once 'PHP/Compat/Function/array_combine.php';
}

if (!function_exists('array_diff_key')) {
 require_once 'PHP/Compat/Function/array_diff_key.php';
}

function beginsWith($str, $sub)
 {
  return (substr($str, 0, strlen($sub)) === $sub);
 }

function endsWith($str, $sub)
 {
  return (substr($str, strlen($str) - strlen($sub)) === $sub);
 }
?>