<?php
session_start();

require_once "config.php";

if(isset($_GET['id']) && isset($_GET['movid'])){
    $id = $_GET['id'];
    $movid = $_GET['movid'];

    if (!isset($_POST['seats']) || !is_array($_POST['seats']) || count($_POST['seats']) == 0) {
        $_SESSION['error'] = "هیچ صندلی‌ای انتخاب نشده است";
        header("Location: buy.php?movid=$movid&id=$id");
        exit();
    }

    $seats = array_map('intval', $_POST['seats']);
    $tickcount = count($seats);

    $stmt = mysqli_prepare($link, "SELECT * FROM movies WHERE movid=?");
    
    mysqli_stmt_bind_param($stmt, "i", $movid);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);
    
    $movid = $row['movid'];
    $date = $row['movdate'];
    $showtime = $row['movshowtime'];
    $price = (int)$row['movprice'];
    $tickets = $row['tickets'];
    $datenow = date('Y-m-d');

    $stmt = mysqli_prepare($link, "SELECT * FROM users WHERE id = ?");

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    $row2 = mysqli_fetch_assoc($result);

    $id = $row2['id'];

        $updateStmt = mysqli_prepare($link, "UPDATE movies SET tickets = tickets-? WHERE movid = ? AND tickets >= ?");

        mysqli_stmt_bind_param($updateStmt, "iii", $tickcount, $movid, $tickcount);
        
        $updateResult = mysqli_stmt_execute($updateStmt);

        if (mysqli_stmt_affected_rows($updateStmt) === 0) {
            $_SESSION['error'] = "تعداد بلیط درخواستی بیشتر از بلیط های موجود است";
            header("Location: buy.php?movid=$movid&id=$id");
            exit();
        }

        mysqli_stmt_close($updateStmt);

        $insertStmt = mysqli_prepare($link, "INSERT INTO ticket (userid, movid, tickcount, showdate, showtime, tickprice, created)
                    VALUES (?,?,?,?,?,?,?)");
        
        mysqli_stmt_bind_param($insertStmt, "iiissss", $id, $movid, $tickcount, $date, $showtime, $price, $datenow);

        $insertResult = mysqli_stmt_execute($insertStmt);

        mysqli_stmt_close($insertStmt);

        if ($updateResult && $insertResult) {
            $_SESSION['ok'] = "خرید با موفقیت ثبت شد";
            $tickid = mysqli_insert_id($link);
            
            $reserve = 1;

            foreach ($seats as $seat) {
                $stmt = mysqli_prepare($link, "UPDATE seats SET reserved = ?, tickid = ?
                           WHERE seatid = ? AND movid = ?");

                mysqli_stmt_bind_param($stmt, "iiii", $reserve, $tickid, $seat, $movid);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
        } else {
            $_SESSION['error'] = "خطایی در فرایند ثبت خرید رخ داد";
            header("Location: buy.php?movid=$movid&id=$id");
            exit();
        }

    header("Location: tickcart.php");
    exit();
} else {
    $_SESSION['error'] = "آیدی کاربر یا فیلم دریافت نشده";
    header("Location: buy.php?movid=$movid&id=$id");
    exit();
}
?>