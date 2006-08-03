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
?>
