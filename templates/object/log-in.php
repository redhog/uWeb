<div class="object">
 <form action="<?php echo $_SERVER["SCRIPT_NAME"] . $_SERVER["PATH_INFO"] ?>?action=log-in-save" method="post" enctype="multipart/form-data">
  <h1>Please log in</h1>
  <dl class="properties">
   <div><dt>Username</dt><dd><input name='user' type='text' /></dd></div>
   <div><dt>Password</dt><dd><input name='password' type='password' /></dd></div>
  </dl>
  <input type="submit" name="logInButton" value="Log in" />
 </form>
</div>
