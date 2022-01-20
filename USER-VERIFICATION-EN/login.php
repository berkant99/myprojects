<?php require_once 'controllers/authController.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!--Bootstrap for CSS-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link rel='stylesheet' href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <title>Login</title>
</head>

<body>

    <div class="col-md-4 offset-md-4 form-div login">
        <form action="login.php" method="post">
        <a href="http://localhost/projects/USER-VERIFICATION-BG/login.php">
                <img src="bg.jpg" width="40px" height="25px" class="p-viewer3" style="border: 1px solid black;">
            </a><br>
            <h1 class="text-center">Login</h1>
            <br>
            <div style="text-align: center">
                <img src="img.png" width="250px" height="150px" style="border-radius: 50%;">
            </div>
            <br>
            <?php if (isset($_SESSION['message'])) : ?>
                <div class="alert  <?php echo $_SESSION['alert-class']; ?>" style="text-align: center;">
                    <?php
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                    unset($_SESSION['alert-class']);
                    ?>
                </div>
            <?php endif ?>

            <?php if (!empty($errors['login_fail'])) : ?>
                <div class="alert alert-danger" style="text-align: center">
                    <?php echo $errors['login_fail']; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($errors['username'])) : ?>
                <div class="error">
                    <li><?php echo $errors['username']; ?></li>
                </div>
            <?php endif; ?>


            <div class="form-group">
                <label for="username"><i class="fa fa-user"></i></label>
                <input type="text" name="username" placeholder="Enter your username or email..." />
            </div>


            <?php if (!empty($errors['password'])) : ?>
                <div class="error">
                    <li><?php echo $errors['password']; ?></li>
                </div>
            <?php endif; ?>

            <?php if (count($passworderrors) > 0) : ?>
                <div class="error">
                    <?php foreach ($passworderrors as $error) : ?>
                        <li><?php echo $error ?></li>
                    <?php endforeach ?>
                </div>
            <?php endif ?>

            <div class="form-group">
                <label for="password"><i class="fa fa-lock"></i></label>
                <input type="password" name="password" placeholder="Enter password..." id="pass_log_id" />
                <span toggle="#password-field" class="fa fa-fw fa-eye-slash field_icon toggle-password p-viewer2"></span>
            </div>

            <div class="wrap">
                <button type="submit" name="login-btn" class="button">Log in</button>
            </div>

            <p class="text-center">Not yet a member?<a href="signup.php"> Sign Up</a></p>
            <div style="font-size: 0.8em; text-align: center;"><a href="forgot_password.php">Forgot your password?</a></div>
        </form>
    </div>
    <script>
        $(document).on('click', '.toggle-password', function() {

            $(this).toggleClass("fa-eye-slash fa-eye");

            var input = $("#pass_log_id");
            input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
        });
    </script>
</body>

</html>