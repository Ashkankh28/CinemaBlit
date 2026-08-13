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
    
    $query = "SELECT * FROM users WHERE username = '$username' AND pass = '$password'";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_array($result);
    
    if ($row) {
        $_SESSION['loginstate'] = true;
        
    $_SESSION['id'] = $row['id'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['pass'] = $row['pass'];
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
