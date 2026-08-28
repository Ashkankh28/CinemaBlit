<?php
session_start();

if(!isset($_SESSION['usertype']) || ($_SESSION['usertype'] != "admin")){
    header("Location: 404page.php");
    exit();
}

require_once "config.php";

if (isset($_GET['tickid'])) {
    $tickid = $_GET['tickid'];

    $stmt = mysqli_prepare($link, "SELECT tickcount, movid FROM ticket WHERE tickid = ?");

    mysqli_stmt_bind_param($stmt, "i", $tickid);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    $tickets = $row['tickcount'];
    $movid = $row['movid'];
    $reset = 0;

    $movieStmt = mysqli_prepare($link, "SELECT 1 FROM movies WHERE movid = ?");
    
    mysqli_stmt_bind_param($movieStmt, "i", $movid);
    mysqli_stmt_execute($movieStmt);

    $movieResult = mysqli_stmt_get_result($movieStmt);

    if (!$movieResult || mysqli_num_rows($movieResult) === 0) {
        $_SESSION['error'] = "فیلم مربوط به این سفارش پیدا نشد";
        header("Location: orders.php");
        exit();
    }

    mysqli_stmt_close($movieStmt);

    $stmt = mysqli_prepare($link, "UPDATE seats SET reserved = ? , tickid = ? WHERE tickid = ?");

    mysqli_stmt_bind_param($stmt, "iii", $reset, $reset, $tickid);

    $updateResult = mysqli_stmt_execute($stmt);
    $seatAffected = mysqli_stmt_affected_rows($stmt);
    
    mysqli_stmt_close($stmt);
    

    $stmt = mysqli_prepare($link, "UPDATE movies SET tickets = tickets + ? WHERE movid = ?");

    mysqli_stmt_bind_param($stmt, "ii", $tickets, $movid);

    $updateResult2 = mysqli_stmt_execute($stmt);
    $movieAffected = mysqli_stmt_affected_rows($stmt);
    
    mysqli_stmt_close($stmt);
    

    $stmt = mysqli_prepare($link, "DELETE FROM ticket WHERE tickid = ?");

    mysqli_stmt_bind_param($stmt, "i", $tickid);
    
    $deleteResult = mysqli_stmt_execute($stmt);
    $ticketAffected = mysqli_stmt_affected_rows($stmt);
    
    mysqli_stmt_close($stmt);
    
    if($updateResult && $seatAffected > 0 && $updateResult2 &&
       $movieAffected === 1 && $deleteResult && $ticketAffected === 1){
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
