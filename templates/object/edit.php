<div class="main">
 <div class="object">
  <form action="<?php echo $_SERVER["SCRIPT_NAME"] . $_SERVER["PATH_INFO"] ?>?action=save" method="post" enctype="multipart/form-data">
   <h1><input name="Title" type="text" value="<?php echo $properties['Title'][1]; ?>" /></h1>
   <textarea name="Body"><?php echo $properties['Body'][1]; ?></textarea>
   <dl class="properties">
    <?php
     foreach ($properties as $name => $value)
      {
       if ($name != "Title" && $name != "Body")
        if ($value[0] == 'File')
 	 echo "<div><dt>{$name}</dt><dd><select name='{$name}_orig' width='10'><option value='{$value[1]}'>Old file</option><option></option><input name='{$name}' type='file' value='{$value[1]}' /></dd></div>";
        else
 	 echo "<div><dt>{$name}</dt><dd><input name='{$name}' type='text' value='{$value[1]}' /></dd></div>";
      }
    ?>
    <div>
     <dt>
      <select name="newPropertyName">
       <option></option>
       <?php
	foreach (getProperties() as $name => $type)
         if ($type != 'File')
	  echo "<option>{$name}</option>\n";
       ?>
      </select>
     </dt>
     <dd><input name='newPropertyValue' type='text' value='' /></dd>
    </div>
    <div>
     <dt>
      <select name="newFilePropertyName">
       <option></option>
       <?php
	foreach (getProperties() as $name => $type)
         if ($type == 'File')
	  echo "<option>{$name}</option>\n";
       ?>
      </select>
     </dt>
     <dd><input name='newFilePropertyValue' type='file' value='' /></dd>
    </div>
   </dl>
   <input type="submit" name="saveTypeButton" value="Save changes" />
  </form>
 </div>
 <div class="children">
  <h1>Children</h1>
  <ul>
   <?php

    foreach ($children as $path => $title)
     {
      echo "<li><a href='{$_SERVER["SCRIPT_NAME"]}{$path}?{$_SERVER["QUERY_STRING"]}'>{$title}</a></li>\n";
     }
   ?>
   <li>
    <form action="<?php echo $_SERVER["SCRIPT_NAME"] . $_SERVER["PATH_INFO"] ?>?action=save" method="post">
     <input name='newChildName' type='text' value='' />
     <input type="submit" name="saveTypeButton" value="Add child" />
    </form>
   </li>
  </ul>
 </div>
</div>
