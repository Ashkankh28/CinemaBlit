<?php
session_start();

require_once "config.php";

if (isset($_POST['namefamily']) && !empty($_POST['namefamily']) &&
    isset($_POST['username']) && !empty($_POST['username']) &&
    isset($_POST['pass']) && !empty($_POST['pass']) &&
    isset($_POST['email']) && !empty($_POST['email']) &&
    isset($_POST['phone']) && !empty($_POST['phone'])
) {

    $id = $_SESSION['id'];
    $namefamily = $_POST['namefamily'];
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "پست الکترونیکی وارد شده صحیح نمی‌باشد";
        header("Location: personal.php");
        exit();
    }

    if (!preg_match('/^09[0-9]{9}$/', $phone)) {
        $_SESSION['error'] = "شماره موبایل وارد شده صحیح نمی‌باشد";
        header("Location: personal.php");
        exit();
    }
    
    if (
        strlen($pass) < 8 ||
        !preg_match('/[0-9]/', $pass) ||
        !preg_match('/[!@#$%^&*()_\-+=]/', $pass)
    ) {
        $_SESSION['error'] = "رمز عبور باید حداقل ۸ کاراکتر باشد و شامل حداقل یک عدد و یک علامت باشد";
        header("Location: personal.php");
        exit();
    }

    $stmt = mysqli_prepare($link, "SELECT 1 FROM users WHERE (username = ? OR email = ? OR phone = ?) AND id != ?");

    mysqli_stmt_bind_param($stmt, "sssi", $username, $email, $phone, $id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['error'] = "این نام کاربری یا شماره موبایل یا ایمیل قبلاً ثبت شده است";
        header("Location: personal.php");
        exit();
    }
    
    mysqli_stmt_close($stmt);

    $stmt = mysqli_prepare($link, "UPDATE users SET namefamily = ? , username = ?, pass = ?, email = ?, phone = ? WHERE id = ?");

    mysqli_stmt_bind_param($stmt, "sssssi", $namefamily, $username, $pass, $email, $phone, $id);
   
    $updateResult = mysqli_stmt_execute($stmt);
   
    mysqli_stmt_close($stmt);

         if ($updateResult) {
            $_SESSION['ok'] = "تغییرات با موفقیت اعمال شد";

                $_SESSION['namefamily'] = $namefamily;
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['phone'] = $phone;

            header("Location: personal.php");
            exit;
        } else {
            $_SESSION['error'] = "خطا در اعمال تغییرات ";
            header("Location: personal.php");
            exit;
        }
} else{
    $_SESSION['error'] = "خطایی به هنگام اعمال تغییرات رخ داده است";
    header("Location: personal.php");
    exit();
}
?>