<?php
if (isset($_POST["reset-request-submit"])) {
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "localhost/registration/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

    $expires = date("U") + 1800;

    require 'dbh.inc.php';

    $userEmail = $_POST["email"];

    $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "ERROR1!";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute($stmt);
    }

    $sql = "INSERT INTO pwdeset (pswResedEmail, pwdResetSelector, pwdResetToken, pedResetExpires) VALUES (?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
   /* if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "ERROR2!";
        exit();
    } else {*/
        $hashedtoken = password_hash($token,PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss", $userEmail,$selector,$hashedtoken,$expires);
mysqli_stmt_close($stmt);
mysqli_close($conn);
        
    //}
    mysqli_stmt_execute($stmt);

    $to = $userEmail;

    $subject = 'Reset your password for mmtuts';

    $message = '<p>SEND</p>';

    $message .= 'Reset link: ';

    $message .= '<a href="'.$url.'">'.$url.'</a>';

    $headers = "From: registartion <berko_99@abv.bg>\r\n";

    $headers .= "Reply to: <berko_99@abv.bg>\r\n";

    $headers = "Content-type text\html\r\n";

    mail($to,$subject,$message,$headers);

    header("Location: ../reset-password.php?reset=success");
} else {
    header("Location: ../index.php");
}
