<?php

session_start();

require 'config/db.php';
require_once 'emailController.php';

$errors = array();
$passworderrors = array();
$username = "";
$email = "";

// if user click on the sign up button
if (isset($_POST['signup-btn'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    //$password = $_POST['password'];
    $passwordConf = $_POST['passwordConf'];
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    //validation
    if (empty($username)) {
        $errors['username'] = "Username required!";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email address is invalid!";
    }
    if (empty($email)) {
        $errors['email'] = "Email required!";
    }
    if (empty($password)) {
        $errors['password'] = "Password required!";
    }
    if (!empty($password) && !empty($passwordConf)) {
        if ($password !== $passwordConf) {
            $passworderrors[6] = "The two password do not match!";
        }
    }
    if (!empty($password)) {
        if (strlen($password) < 8) {
            $passworderrors[0] = "Password must be at least 8 characters in length!";
        }

        if (!preg_match("/\d/", $password)) {
            $passworderrors[1] = "Password should contain at least one digit!";
        }
        if (!preg_match("/[A-Z]/", $password)) {
            $passworderrors[2] = "Password should contain at least one Capital Letter!";
        }
        if (!preg_match("/[a-z]/", $password)) {
            $passworderrors[3] = "Password should contain at least one small Letter!";
        }
        if (!preg_match("/\W/", $password)) {
            $passworderrors[4] = "Password should contain at least one special character!";
        }
        if (preg_match("/\s/", $password)) {
            $passworderrors[5] = "Password should not contain any white space!";
        }
    }
    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        if ($user['username'] === $username) {
            $errors['username'] = "Username already exists!";
        }

        if ($user['email'] === $email) {
            $errors['email'] = "Email already exists!";
        }
    }
    if ((count($errors) == 0) && (count($passworderrors) == 0)) {
        $token = bin2hex(random_bytes(50));
        $verified = false;
        $sql = "INSERT INTO users (username, email, verified, token, password) VALUES (?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssiss', $username, $email, $verified, $token, $password);
        $stmt->execute();
        // login user
        $user_id = $conn->insert_id;
        $_SESSION['id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['verified'] = $verified;
        sendVerficationEmail($email, $token);
        //flash message
        $_SESSION['message'] = "You are now logged in!";
        $_SESSION['alert-class'] = "alert-success";
        header('location: index.php');
        exit();
    }
}
// login form
if (isset($_POST['login-btn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    //validation
    if (empty($username)) {
        $errors['username'] = "Username required!";
    }
    if (empty($password)) {
        $errors['password'] = "Password required!";
    }

    if (count($errors) == 0) {
        $sql = "SELECT * FROM users WHERE email=? OR username=? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($password === $user['password']) {
            //login success
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['verified'] = $user['verified'];
            //flash message
            $_SESSION['message'] = "You are now logged in!";
            $_SESSION['alert-class'] = "alert-success";
            header('location: index.php');
            exit();
        } else {
            $errors['login_fail'] = "Wrong username/password combination!";
        }
    }
}


//logout
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['id']);
    unset($_SESSION['username']);
    unset($_SESSION['email']);
    unset($_SESSION['verified']);
    header('location: login.php');
    exit();
}

//verify
function verifyUser($token)
{
    global $conn;
    $sql = "SELECT * FROM users WHERE token='$token' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $updete_query = "UPDATE users SET verified=1 WHERE token='$token'";

        if (mysqli_query($conn, $updete_query)) {
            //login success
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['verified'] = 1;
            //flash message
            $_SESSION['message'] = "Your email address was successfully verified!";
            $_SESSION['alert-class'] = "alert-success";
            header('location: index.php');
            exit();
        }
    } else {
        echo "User not found!";
    }
}

if (isset($_POST['forgot-password'])) {
    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email address is invalid!";
    }
    if (empty($email)) {
        $errors['email'] = "Email required!";
    }

    if (count($errors) == 0) {
        $sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);
        $token = $user['token'];
        sendPasswordResetLink($email, $token);
        $_SESSION['message'] = "An email has been sent to your email address to with a link to reset your password.";
        $_SESSION['alert-class'] = "alert-success";
        header('location: forgot_password.php');
        exit(0);
    }
}

if (isset($_POST['reset-password'])) {
    $password = $_POST['password'];
    $passwordConf = $_POST['passwordConf'];

    if (empty($password) || empty($passwordConf)) {
        $errors['password'] = "Password required!";
    }

    if (!empty($password) && !empty($passwordConf)) {
        if ($password !== $passwordConf) {
            $passworderrors[6] = "The two password do not match!";
        }
    }

    if (!empty($password)) {
        if (strlen($password) < 8) {
            $passworderrors[0] = "Password must be at least 8 characters in length!";
        }

        if (!preg_match("/\d/", $password)) {
            $passworderrors[1] = "Password should contain at least one digit!";
        }
        if (!preg_match("/[A-Z]/", $password)) {
            $passworderrors[2] = "Password should contain at least one Capital Letter!";
        }
        if (!preg_match("/[a-z]/", $password)) {
            $passworderrors[3] = "Password should contain at least one small Letter!";
        }
        if (!preg_match("/\W/", $password)) {
            $passworderrors[4] = "Password should contain at least one special character!";
        }
        if (preg_match("/\s/", $password)) {
            $passworderrors[5] = "Password should not contain any white space!";
        }
    }

    $email = $_SESSION['email'];
    if (count($errors) == 0 && count($passworderrors) == 0) {
        $sql = "UPDATE users SET password='$password' WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $_SESSION['message'] = "Your password was successfully changed!";
            $_SESSION['alert-class'] = "alert-success";
            header('location: login.php');
            exit(0);
        }
    }
}

function resetPassword($token)
{
    global $conn;
    $sql = "SELECT * FROM users WHERE token='$token' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    $_SESSION['email'] = $user['email'];
    header("location: reset_password.php");
    exit();
}
