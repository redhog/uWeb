<?php
function findTemplateRecurse($path, $templateDir, $action, $type)
 {
  global $scriptDir;

  if ($action == '') $action = 'view';
  if (!beginsWith($path, '/')) $path = '/' . $path; // Handle nasty cases...


  $template = $templateDir . $path . '/nonrecursive.' . $action . '.' . $type;
  if (file_exists($scriptDir . $template))
   return $template;
  while (true)
   {
    $concpath = $path; if ($path != '/') $concpath .= '/';
    $template = $templateDir . $concpath . $action . '.' . $type;
    if (file_exists($scriptDir . $template))
     return $template;
    if ($path == '/')
     return NULL;
    $path = dirname($path);
   }
 }

function findTemplate($path, $template, $action, $type)
 {
  global $templatesdirs;
  foreach ($templatesdirs as $templatesdir)
   if ($result = findTemplateRecurse($path, "/{$templatesdir}/" . $template, $action, $type))
    return $result;
  foreach ($templatesdirs as $templatesdir)
   if ($result = findTemplateRecurse($path, "/{$templatesdir}/" . $template, 'default', $type))
    return $result;
  return NULL;
 }

function findTemplateServerPath($path, $template, $action, $type)
 {
  global $scriptDir;
  return $scriptDir . findTemplate($path, $template, $action, $type);
 }

function findTemplateClientPath($path, $template, $action, $type)
 {
  global $scriptDirUrl;
  return $scriptDirUrl . findTemplate($path, $template, $action, $type);
 }

function findTemplateSet($path, $templateSet, $action, $type)
 {
  global $scriptDir;
  global $templatesdirs;

  $res = array();
  foreach ($templatesdirs as $templatesdir)
   if (   file_exists($scriptDir . '/'. $templatesdir . '/' . $templateSet)
       && ($dh = opendir($scriptDir . '/'. $templatesdir . '/' . $templateSet)))
    {
     while (($file = readdir($dh)) !== false)
      if ($file != '.' && $file != '..' && ($template = findTemplate($path, $templateSet . '/' . $file, $action, $type)) != NULL)
       $res[] = $template;
     closedir($dh);
    }
  return $res;
 }

function findTemplateSetServerPath($path, $templateSet, $action, $type)
 {
  global $scriptDir;

  $paths = array();
  foreach (findTemplateSet($path, $templateSet, $action, $type) as $path)
   $paths[] = $scriptDir . $path;
  return $paths;
 }

function findTemplateSetClientPath($path, $templateSet, $action, $type)
 {
  global $scriptDirUrl;
  $paths = array();
  foreach (findTemplateSet($path, $templateSet, $action, $type) as $path)
   $paths[] =  $scriptDirUrl . $path;
  return $paths;
 }

?>
