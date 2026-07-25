<?php
session_start();
$link = mysqli_connect("localhost", "root", "", "cinemablit");
if (mysqli_connect_errno()) {
    exit("خطا: " . mysqli_connect_error());
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM users WHERE id = $id";
    if(mysqli_query($link,$query)){
        $_SESSION['ok'] = "کاربر با موفقیت حذف شد";
        header("Location: adminuser.php");
        exit();
    }
    else{
        $_SESSION['error'] = "خطایی در حذف کاربر رخ داد";
        header("Location: adminuser.php");
        exit();
    }
}
else{
    $_SESSION['error'] = "خطایی در حذف کاربر رخ داد";
    header("Location: adminuser.php");
    exit();
}
?>
