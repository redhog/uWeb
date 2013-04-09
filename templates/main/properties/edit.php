<div class="main">
 <div class="object">
  <form action="<?php echo $_SERVER["SCRIPT_NAME"] . $_SERVER["PATH_INFO"] ?>?action=save" method="post">
   <h1>Properties</h1>
   Properties available for objects:
   <dl class="properties">
    <?php
     $types = getPropertyTypes();
     foreach (getProperties($_SERVER["PATH_INFO"]) as $name => $type)
      {
       echo "<div>";
       echo " <dt><input name='{$name}_name' type='text' value='{$name}' /></dt>";
       echo " <dd>";
       echo "  <select name='{$name}_type'>";
       echo "   <option></option>";
       foreach ($types as $availableType)
	if ($availableType == $type)
	 echo "   <option selected='1'>{$availableType}</option>";
	else
	 echo "   <option>{$availableType}</option>";
       echo "  </select>";
       echo " </dd>";
       echo "</div>";
      }
    ?>
    <div>
     <dt>
      <input name="_name" type="text" />
     </dt>
     <dd>
      <select name="_type">
       <option></option>
       <?php
	foreach ($types as $name)
	 echo "<option>{$name}</option>\n";
       ?>
      </select>
     </dd>
    </div>
   </dl>
   <input type="submit" name="saveTypeButton" value="Save changes" />
  </form>
 </div>
</div>
