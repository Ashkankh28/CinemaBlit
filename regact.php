<?php
session_start();

require_once "config.php";

if (
    isset($_POST['namefamily']) && !empty($_POST['namefamily']) &&
    isset($_POST['username']) && !empty($_POST['username']) &&
    isset($_POST['pass']) && !empty($_POST['pass']) &&
    isset($_POST['email']) && !empty($_POST['email']) &&
    isset($_POST['phone']) && !empty($_POST['phone'])
) {
    $namefamily = $_POST['namefamily'];
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "پست الکترونیکی وارد شده صحیح نمی‌باشد";
        header("Location: register.php");
        exit();
    }

    $query2 = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $result2 = mysqli_query($link, $query2);
    if (mysqli_num_rows($result2) > 0) {
        $_SESSION['error'] = "این نام کاربری یا ایمیل قبلاً ثبت شده است";
        header("Location: register.php");
        exit();
    }

    $query = "INSERT INTO users (namefamily, username, pass, email, phone)
              VALUES ('$namefamily', '$username', '$pass', '$email', '$phone')";
    $result = mysqli_query($link, $query);

    if ($result) {
        $_SESSION['ok'] = "عضویت شما در سایت با موفقیت انجام شد";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error'] = "خطا در ذخیره‌سازی کاربر در پایگاه داده";
        header("Location: register.php");
        exit();
    }
} else {
    $_SESSION['error'] = "لطفاً تمام فیلدها را پر کنید";
    header("Location: register.php");
    exit();
}
?>
