<?php
session_start();

require_once "config.php";

if (isset($_POST['id']) && !empty($_POST['id']) &&
    isset($_POST['namefamily']) && !empty($_POST['namefamily']) &&
    isset($_POST['username']) && !empty($_POST['username']) &&
    isset($_POST['pass']) && !empty($_POST['pass']) &&
    isset($_POST['email']) && !empty($_POST['email']) &&
    isset($_POST['phone']) && !empty($_POST['phone'])
) {


    $id = $_POST['id'];
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

    $query2 = "SELECT * FROM users WHERE (username = '$username' OR email = '$email' OR phone = '$phone') AND id != '$id'";
    $result2 = mysqli_query($link, $query2);
    if (mysqli_num_rows($result2) > 0) {
        $_SESSION['error'] = "این نام کاربری یا شماره موبایل یا ایمیل قبلاً ثبت شده است";
        header("Location: personal.php");
        exit();
    }

    $_SESSION['namefamily'] = $namefamily;
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['phone'] = $phone;

    $query = "UPDATE users SET namefamily = '$namefamily' , username = '$username' , pass = '$pass' , 
     email = '$email' , phone = '$phone' WHERE id = '$id' ";

         if (mysqli_query($link, $query)) {
            $_SESSION['ok'] = "تغییرات با موفقیت اعمال شد";
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