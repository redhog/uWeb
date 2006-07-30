<?php
 session_start();
 $user = pg_escape_string($_POST['user']);
 $pwd = pg_escape_string($_POST['password']);
 pg_fetch_row(pg_query($dbconn, "select * from account where name='{$user}' and password='{$pwd}'"))
  or die("You don't exist, go away.");
 $_SESSION['user'] = $_POST['user'];
 header("Status: 303 See Other");
 header("Location: {$_SERVER["SCRIPT_NAME"]}{$_SERVER["PATH_INFO"]}?action=edit");
?>
