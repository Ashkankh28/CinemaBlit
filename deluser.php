<?php
session_start();

if(!isset($_SESSION['usertype']) || ($_SESSION['usertype'] != "admin")){
    header("Location: 404page.php");
    exit();
}

require_once "config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = mysqli_prepare($link,
    "UPDATE seats s INNER JOIN ticket t ON s.tickid = t.tickid 
     SET s.reserved = 0, s.tickid = 0
     WHERE t.userid = ?");
    
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $restoreStmt = mysqli_prepare($link,
        "UPDATE movies m
        INNER JOIN (
            SELECT movid, SUM(tickcount) AS totalTickets
            FROM ticket
            WHERE userid = ?
            GROUP BY movid
        ) t ON m.movid = t.movid
        SET m.tickets = m.tickets + t.totalTickets");

    mysqli_stmt_bind_param($restoreStmt, "i", $id);
    mysqli_stmt_execute($restoreStmt);
    mysqli_stmt_close($restoreStmt);

    $stmt = mysqli_prepare($link, "DELETE FROM ticket WHERE userid = ?");

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

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
