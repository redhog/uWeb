<?php

require("config.php");

session_start();
require("utils.php");
require("template.php");
require("object.php");

function queryConstruct($setargs = array(), $unsetargs = array())
 {
  return array_diff_key(array_merge($_GET, $setargs), array_flip($unsetargs));
 }

function queryString($args = NULL)
 {
  if ($args === NULL) $args = $_GET;
  $res = array();
  foreach($args as $name => $value)
   $res[] = urlencode($name) . '=' . urlencode($value);
  $res = implode('&', $res);
  return $res;
 }

require(findTemplateServerPath($_SERVER["PATH_INFO"], "page", $_GET["action"], "php"));
?>
