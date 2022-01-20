<?php require_once 'controllers/authController.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!--Bootstrap for CSS-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link rel='stylesheet' href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

    <title>Forgot password</title>
</head>

<body>

    <div class="col-md-4 offset-md-4 form-div login">
        <form action="forgot_password.php" method="post">
            <h3 class="text-center">Recover your password</h3>
            <!--success message-->
            <?php if (isset($_SESSION['message'])) : ?>
                <div class="alert  <?php echo $_SESSION['alert-class']; ?>" style="text-align: center;">
                    <?php
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                    unset($_SESSION['alert-class']);
                    ?>
                </div>
            <?php endif ?>
            <!--common message-->
            <?php if (!empty($errors['email']) && (isset($_POST['forgot-password']))) : ?>
                <div class="alert alert-warning" style="text-align: center;">
                    Please enter your email address you used to sign up on this site
                    and we will assist you in recovering your password.
                </div>
            <?php elseif (!(isset($_POST['forgot-password'])) && (!empty($errors['email']))) : ?>
                <div class="alert alert-warning" style="text-align: center;">
                    Please enter your email address you used to sign up on this site
                    and we will assist you in recovering your password.
                </div>
            <?php endif; ?>


            <?php if (!empty($errors['email'])) : ?>
                <div class="error">
                    <li><?php echo $errors['email']; ?></li>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="email"><i class="fa fa-user"></i></label>
                <input type="email" name="email" placeholder="Enter your email address..." />
            </div>
            <div class="wrap">
                <button type="submit" name="forgot-password" class="button">Recover your password</button>
            </div>
        </form>
    </div>
</body>

</html>