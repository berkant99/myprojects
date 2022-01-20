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
    <title>Reset your password</title>
</head>

<body>

    <div class="col-md-4 offset-md-4 form-div login">
        <form action="reset_password.php" method="post">
            <h3 class="text-center">Reset your password</h3>

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

            <div class="form-group">
                <label for="password"><i class="fa fa-lock"></i></label>
                <input type="password" name="passwordConf" id="myInput" placeholder="Repeat password..." />
            </div>

            <div class="wrap">
                <button type="submit" name="reset-password" class="button">Reset Password</button>
            </div>
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