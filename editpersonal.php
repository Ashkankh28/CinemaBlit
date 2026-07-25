<?php
session_start();
$link = mysqli_connect("localhost", "root", "", "cinemablit");
if (mysqli_connect_errno()) {
    exit("خطا: " . mysqli_connect_error());
}

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

    $_SESSION['namefamily'] = $namefamily;
    $_SESSION['username'] = $username;
    $_SESSION['pass'] = $pass;
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