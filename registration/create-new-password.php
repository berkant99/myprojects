<?php
<div class="header">
  	<h2>Reset your password</h2>
  </div>
<?php
$selector = $_GET["selector"];
$validator = $_GET["validator"];
if(empty($selector)||empty($validator))
{
    echo "Could not validate!";
}
else{
   if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false)
{
    ?>

<form method="post" action="includes/reset-request.inc.php">
  	<div class="input-group">
  	  <label>Email
        <input type="hidden" name="selector" placeholder="Enter your email address here." value="<?php echo $selector; ?>">
        <input type="hidden" name="validator" placeholder="Enter your email address here." value="<?php echo $validator; ?>">
    <input type="password" name="pwd">
    <input type="password" name="pwd-reset"> 
    </div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reset-password-submit">Reset</button>
  	</div>
  </form>

    <?php
}
}
?>
