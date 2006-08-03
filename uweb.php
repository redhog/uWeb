<?php

require("config.php");

session_start();
require("utils.php");
require("template.php");
require("object.php");

require(findTemplateServerPath($_SERVER["PATH_INFO"], "page", $_GET["action"], "php"));
?>
