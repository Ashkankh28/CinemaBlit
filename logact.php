<?php
session_start();

require_once "config.php";

if (!isset($_SESSION['loginstate'])) {
    $_SESSION['loginstate'] = false;
}
if ( isset($_POST['username']) && !empty($_POST['username']) && 
     isset($_POST['pass']) && !empty($_POST['pass'])) {

    $username = $_POST['username'];
    $password = $_POST['pass']; 
    
    $stmt = mysqli_prepare($link, "SELECT * FROM users WHERE username = ?");
    
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);
    
    if ($row && password_verify($password, $row['pass'])) {
        $_SESSION['loginstate'] = true;    
        $_SESSION['id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['namefamily'] = $row['namefamily'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['phone'] = $row['phone'];

        if($row['mtype'] == 1){
            $_SESSION['usertype'] = "admin";
        }
        else{
            $_SESSION['usertype'] = "normaluser";
        } 
        header("Location: main-cinemablit.php");
            exit();
    } else {
        $_SESSION['loginstate'] = false;
        $_SESSION['error'] = "نام کاربری یا رمز اشتباه است";
        header("Location: login.php");
        exit();
    }
}
else {
    $_SESSION['error'] = "لطفاً تمام فیلدها را پر کنید";
    header("Location: login.php");
    exit();
}
?>
