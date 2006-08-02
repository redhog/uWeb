<?php
if (!function_exists('array_combine')) {
   function array_combine($a, $b) {
       $c = array();
       if (is_array($a) && is_array($b))
           while (list(, $va) = each($a))
               if (list(, $vb) = each($b))
                   $c[$va] = $vb;
               else
                   break 1;
       return $c;
   }
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