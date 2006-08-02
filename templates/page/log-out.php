<?php
 session_start();
 unset($_SESSION['user']);
 header("Status: 303 See Other");
 header("Location: {$_SERVER["SCRIPT_NAME"]}{$_SERVER["PATH_INFO"]}?action=view");
?>
