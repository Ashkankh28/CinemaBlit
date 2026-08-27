<?php
session_start();

if(!isset($_SESSION['usertype']) || ($_SESSION['usertype'] != "admin")){
    header("Location: 404page.php");
    exit();
}

require_once "config.php";

if (isset($_GET['tickid'])) {
    $tickid = $_GET['tickid'];
    $selquery = "SELECT * FROM ticket WHERE tickid = $tickid";
    $selresult = mysqli_query($link , $selquery);
    $selrow = mysqli_fetch_array($selresult);
    $tickets = $selrow['tickcount'];
    $movid = $selrow['movid'];
    
    $query = "UPDATE seats SET reserved = 0 , tickid = 0 WHERE tickid = $tickid";
    
    $movieQuery = "SELECT movid FROM movies WHERE movid = $movid";
    $movieResult = mysqli_query($link, $movieQuery);

    if (!$movieResult || mysqli_num_rows($movieResult) === 0) {
        $_SESSION['error'] = "فیلم مربوط به این سفارش پیدا نشد";
        header("Location: orders.php");
        exit();
    }
    
    $query2 = "UPDATE movies SET tickets = tickets + $tickets WHERE movid = $movid";
    
    $query3 = "DELETE FROM ticket WHERE tickid = $tickid";
    
    if(mysqli_query($link,$query) && mysqli_query($link,$query2) && mysqli_query($link,$query3)){
        $_SESSION['ok'] = "سفارش با موفقیت حذف شد";
        header("Location:  orders.php");
        exit();
    }
    else{
        $_SESSION['error'] = "خطایی در حذف سفارش رخ داد";
        header("Location: orders.php");
        exit();
    }
}
else{
    $_SESSION['error'] = "خطایی در حذف سفارش رخ داد";
    header("Location: orders.php");
    exit();
}
?>
