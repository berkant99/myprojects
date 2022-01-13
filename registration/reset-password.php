<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Reset your password</h2>
  </div>
  <form method="post" action="includes/reset-request.inc.php">
  <p align="center">An e-mail will be send to you with instructions on how to reset your password.</p>
  	<div class="input-group">
  	  <label>Email<font color="red">*</font></label>
  	  <input type="email" name="email" placeholder="Enter your email address here.">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reset-request-submit">Send</button>
  	</div>
  </form>
<?php
if(isset($_GET["reset"]))
{
    if($_GET["reset"]=="success")
    {
        echo "Check your e-mail!";
    }
}
?>
</body>
</html>