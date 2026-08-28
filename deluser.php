<?php
session_start();

if(!isset($_SESSION['usertype']) || ($_SESSION['usertype'] != "admin")){
    header("Location: 404page.php");
    exit();
}

require_once "config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = mysqli_prepare($link, "DELETE FROM users WHERE id = ?");

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    
    $deleteResult = mysqli_stmt_affected_rows($stmt);

    mysqli_stmt_close($stmt);
    
    if($deleteResult === 1){
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
