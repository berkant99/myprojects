<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="style.css">
    <script>
function Time()
{
	var d = new Date();
    var m=new Array("January","February","March","April","May","June","July","August","September","October","November","December");
    var i=d.getMonth();
	var date=d.getDate()+"/"+m[i]+"/"+d.getFullYear();
    var h = d.getHours();
    var m = d.getMinutes();
    var s = d.getSeconds();
    if(h < 10) {h = "0" + h;}
    if(m < 10) {m = "0" + m;}
    if(s < 10) {s = "0" + s;}
    var time =date+" | "+h + ":" + m + ":" + s;
	document.getElementById("timedate").innerHTML=time;
	setTimeout(Time,100);
}
</script>
</head>
<body onload="Time()">
  <div class="header">
  	<h2>Register</h2>
  </div>
	
  <form method="post" action="register.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  	  <label>Username<font color="red">*</font></label>
  	  <input type="text" name="username" placeholder="Enter your name here." value="<?php echo $username; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Email<font color="red">*</font></label>
  	  <input type="email" name="email" placeholder="Enter your email address here." value="<?php echo $email; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Password<font color="red">*</font></label>
  	  <input type="password" name="password_1" placeholder="Enter your password.">
  	</div>
  	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2" placeholder="Repeat the password.">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user">Register</button>
  	</div>
  	<p align="center">
        <font color="red">*</font>Required fields!<br>
  		Already a member? <a href="login.php">Sign in</a>
  	</p>
      <div style="text-align: center;" id="timedate"></div>
  </form>
  <?php
  if (isset($_GET["newpwd"]))
  {
	  if($_GET["newpwd"]=="passwordupdated")
	  {
		  echo"Successefully reset";
	  }
  }
  ?>
  <a href="reset-password.php">Forgot your password?</a>
</body>
</html>