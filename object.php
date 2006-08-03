<?php
$dbconn = pg_connect("dbname={$dbname} user={$dbuser} password={$dbpwd}")
 or die('Could not connect: ' . pg_last_error());

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

function getObjects($path, $relation = 0, $requires = array(), $properties = NULL)
 {
  // $relation is 0 for getting object at path, 1 for its children, 2 for its descendants.
  // $requires is an array of attribute values that must be present.
  // $properties is either a list of properties to return, or NULL to return all
  global $dbconn;

  $path = pg_escape_string($path);

  if ($relation == 0)
   $rel = $path;
  else
   {
    if ($path != '/') $path .= '/';
    if ($relation == 1) $rel = "{$path}[^/]*";
    elseif ($relation == 2) $rel = "{$path}%";
   }

  $req = '';
  foreach ($requires as $name => $value)
   $req .= " and exists (select *" .
	   "              from object_property, property" .
	   "              where     object_property.object = object_relation.object" .
	   "                    and object_property.value = '{$value}'" .
	   "                    and object_property.property = property.id" .
	   "                    and property.name = '{$name}')";

  $prop = '';
  if ($properties !== NULL)
   if (count($properties) > 0)
    {
     $props = array();
     foreach ($properties as $name)
      {
       $name = pg_escape_string($name);
       $props[] = "property.name = '{$name}'";
      }
     $props = implode(" or ", $props);
     $prop = " and ({$props})";
    }
   else
    $prop = " and false";
  $sql = "select object_relation.object, object_relation.path, null, null, null" .
         " from object_relation, object_property, property" .
         " where     object_relation.path similar to '{$rel}'" .
         "           $req" .
         " union select object_relation.object, object_relation.path, property.name, property_type.name, object_property.value" .
         "  from object_relation, object_property, property, property_type" .
         "  where     object_relation.path similar to '{$rel}'" .
         "            $req" .
         "        and object_property.object = object_relation.object" .
         "        and property.id = object_property.property" .
         "        and property_type.id = property.type" .
         "           $prop";
  $objectRows = pg_query($dbconn, $sql)
   or die('Could query: ' . pg_last_error());

  $results = array();
  while ($objectRow = pg_fetch_row($objectRows))
   {
    if (!array_key_exists($objectRow[0], $results))
     $results[$objectRow[0]] = array('paths' => array($objectRow[1]),
				     'properties' => array());
    if (!in_array($objectRow[1], $results[$objectRow[0]]['paths']))
     $results[$objectRow[0]]['paths'][] = $objectRow[1];
    if ($objectRow[2] != NULL)
     if (!array_key_exists($objectRow[2], $results[$objectRow[0]]['properties']))
      $results[$objectRow[0]]['properties'][$objectRow[2]] = array($objectRow[3], $objectRow[4]);
   }
  return $results;
 }

function anyObject($objects)
 {
  $objects = array_values($objects);
  return $objects[0];
 }

function objectPaths($object)
 {
  return $object['paths'];
 }

function anyPath($paths)
 {
  return $paths[0];
 }

function objectProperties($object)
 {
  return $object['properties'];
 }
?>
