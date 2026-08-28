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

    if (!preg_match('/^09[0-9]{9}$/', $phone)) {
        $_SESSION['error'] = "شماره موبایل وارد شده صحیح نمی‌باشد";
        header("Location: register.php");
        exit();
    }
    
    if (
        strlen($pass) < 8 ||
        !preg_match('/[0-9]/', $pass) ||
        !preg_match('/[!@#$%^&*()_\-+=]/', $pass)
    ) {
        $_SESSION['error'] = "رمز عبور باید حداقل ۸ کاراکتر باشد و شامل حداقل یک عدد و یک علامت باشد";
        header("Location: register.php");
        exit();
    }

    $stmt = mysqli_prepare($link, "SELECT 1 FROM users WHERE username = ? OR email = ? OR phone = ?");

    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $phone);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    mysqli_stmt_close($stmt);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['error'] = "این نام کاربری یا شماره موبایل یا ایمیل قبلاً ثبت شده است";
        header("Location: register.php");
        exit();
    }

    $stmt = mysqli_prepare($link, "INSERT INTO users (namefamily, username, pass, email, phone)
              VALUES (?, ?, ?, ?, ?)");

    mysqli_stmt_bind_param($stmt, "sssss", $namefamily, $username, $pass, $email, $phone);
    
    $insertResult = mysqli_stmt_execute($stmt);

    $insertResultRows = mysqli_stmt_affected_rows($stmt);

    mysqli_stmt_close($stmt);

    if ($insertResult && $insertResultRows === 1) {
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
