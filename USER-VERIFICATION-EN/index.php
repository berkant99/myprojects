<?php
require_once 'controllers/authController.php';

// verify
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    verifyUser($token);
}

// verify
if (isset($_GET['password-token'])) {
    $Passwordtoken = $_GET['password-token'];
    resetPassword($Passwordtoken);
}

if (!isset($_SESSION['id'])) {
    header('location: login.php');
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!--Bootstrap for CSS-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link rel='stylesheet' href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <title>Home</title>
</head>

<body>
    <div class="col-md-4 offset-md-4 form-div login">
        <?php if (isset($_SESSION['message'])) : ?>
            <div class="alert  <?php echo $_SESSION['alert-class']; ?>" style="text-align: center;">
                <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                unset($_SESSION['alert-class']);
                ?>
            </div>
        <?php endif ?>
        <div style="text-align: center;">
            <h3>Welcome, <?php echo $_SESSION['username']; ?></h3>

            <a href="index.php?logout=1" class="logout">Logout</a>
        </div>
        <?php if (!$_SESSION['verified']) : ?>
            <div class="alert alert-warning" style="text-align: center;">
                You need to verify your account!
                Sign in to your email account and click on the verification link we just emailed you at
                <strong><?php echo $_SESSION['email']; ?></strong>
            </div>
        <?php endif; ?>
        <?php if ($_SESSION['verified']) : ?>
            <button class="btn-block btn-lg btn-primary">I am verified</button>
        <?php endif; ?>
    </div>

</body>

</html>