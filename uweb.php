<?php

$dbconn = pg_connect("dbname=uweb user=uweb password=saltgurka")
 or die('Could not connect: ' . pg_last_error());

$scriptDir = dirname($_SERVER["SCRIPT_FILENAME"]);
$scriptDirUrl = dirname($_SERVER["SCRIPT_NAME"]);

function beginsWith($str, $sub)
 {
  return (substr($str, 0, strlen($sub)) === $sub);
 }

function endsWith($str, $sub)
 {
  return (substr($str, strlen($str) - strlen($sub)) === $sub);
 }

function findTemplateRecurse($path, $template, $action, $type)
 {
  global $scriptDir;
  if (!beginsWith($path, '/')) $path = '/' . $path; // Handle nasty cases...
  $templateDir = $scriptDir . "/templates/" . $template;
  while ($path != '/')
   {
    $template = $path . '/' . $action . '.' . $type;
    if (file_exists($templateDir . $template))
     return $template;
    $path = dirname($path);
   }
  $template = '/' . $action . '.' . $type;
  if (file_exists($templateDir . $template))
   return $template;
  return NULL;
 }

function findTemplate($path, $template, $action, $type)
 {
  $result = findTemplateRecurse($path, $template, $action, $type);
  if ($result) return $result;
  return findTemplateRecurse($path, $template, 'default', $type);
 }

function findTemplateServerPath($path, $template, $action, $type)
 {
  global $scriptDir;
  return $scriptDir . "/templates/" . $template . findTemplate($path, $template, $action, $type);
 }

function findTemplateClientPath($path, $template, $action, $type)
 {
  global $scriptDirUrl;
  return $scriptDirUrl . "/templates/" . $template . findTemplate($path, $template, $action, $type);
 }

function getPropertyTypes()
 {
  global $dbconn;

  $rows = pg_query($dbconn, "select property_type.name from property_type")
   or die('Could query: ' . pg_last_error());
  $result = array();
  while ($row = pg_fetch_row($rows))
   $result[] = $row[0];
  return $result;
 }

function getProperties()
 {
  global $dbconn;

  $rows = pg_query($dbconn, "select property.name, property_type.name from property, property_type where property.type = property_type.id order by property.name")
   or die('Could query: ' . pg_last_error());
  $result = array();
  while ($row = pg_fetch_row($rows))
   $result[$row[0]] = $row[1];
  return $result;
 }

function setProperties($names, $types)
 {
  global $dbconn;

  foreach ($types as $name => $type)
   if ($type == "")
    {
     if ($name != '')
      {
       unset($names[$name]);
       $name = pg_escape_string($name);

       pg_query($dbconn, "delete from property where name='{$name}'")
	or die('Could query: ' . pg_last_error());
      }
    }
   else
    {
     $name = pg_escape_string($name);
     $type = pg_escape_string($type);

     if ($name != '')
      pg_query($dbconn, "update property set type=property_type.id from property_type where property.name='{$name}' and property_type.name='{$type}'")
       or die('Could query: ' . pg_last_error());
    } 
  foreach ($names as $old => $new)
   if ($old != $new)
    if ($new == "")
     {
      $old = pg_escape_string($old);

      pg_query($dbconn, "delete from property where name='{$old}'")
       or die('Could query: ' . pg_last_error());
     }
    else
     {
      $old = pg_escape_string($old);
      $new = pg_escape_string($new);

      if ($old == '')
       {
        $type = pg_escape_string($types['']);
        pg_query($dbconn, "insert into property (name, type) select '{$new}', property_type.id where property_type.name='{$type}'")
         or die('Could query: ' . pg_last_error());
       }
      else
       pg_query($dbconn, "update property set name='{$new}' where name='{$old}'")
        or die('Could query: ' . pg_last_error());
     }
 }

function createObject($path)
 {
  global $dbconn;

  $name = pg_escape_string(basename($path));
  $path = pg_escape_string($path);
  $parentpath = pg_escape_string(dirname($path));

  pg_query($dbconn,
   "insert into object default values;" .
   "insert into object_relation select object_relation.object, '{$path}', currval('object_id_seq') from object_relation where object_relation.path = '{$parentpath}';" .
   "insert into object_property select currval('object_id_seq'), property.id, '{$name}' from property where property.name = 'Title';" .
   "insert into object_property select currval('object_id_seq'), property.id, '' from property where property.name = 'Body';")
   or die('Could query: ' . pg_last_error());
 }

function setObjectProperties($path, $properties)
 {
  global $dbconn;

  $path = pg_escape_string($path);
  $row = pg_fetch_row(pg_query($dbconn, "select object from object_relation where path = '{$path}'"))
   or die('Could query: ' . pg_last_error());
  $object = pg_escape_string($row[0]);

  pg_query($dbconn, "delete from object_property where object_property.object = '{$object}'")
   or die('Could query: ' . pg_last_error());

  foreach ($properties as $name => $value)
   {
    pg_query($dbconn, "insert into object_property select '{$object}', property.id, '{$value}' from property where property.name = '{$name}'")
     or die('Could query: ' . pg_last_error());
   }
  return $result;
 }

function getObjectProperties($path)
 {
  global $dbconn;

  $path = pg_escape_string($path);
  $rows = pg_query($dbconn, "select property.name, property_type.name, object_property.value from object_relation, object_property, property, property_type where object_relation.path = '{$path}' and object_relation.object = object_property.object and object_property.property = property.id and property.type = property_type.id")
   or die('Could query: ' . pg_last_error());
  $result = array();
  while ($row = pg_fetch_row($rows))
   $result[$row[0]] = array($row[1], $row[2]);
  return $result;
 }

function getObjectChildren($path)
 {
  global $dbconn;

  $path = pg_escape_string($path);
  $rows = pg_query($dbconn, "select child.path, object_property.value from object_relation as current, object_relation as child, object_property, property where current.path='{$path}' and child.parent = current.object and object_property.object = child.object and object_property.property = property.id and property.name = 'Title';")
   or die('Could query: ' . pg_last_error());
  $result = array();
  while ($row = pg_fetch_row($rows))
   $result[$row[0]] = $row[1];
  return $result;
 }

$action = $_GET["action"];
if (!$action) $action = 'view';
require(findTemplateServerPath($_SERVER["PATH_INFO"], "main", $action, "php"));
?>
